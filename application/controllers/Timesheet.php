<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timesheet extends CI_Controller {

    var $data;
	var $id;
    var $sess_user_id;

    function __construct() {
        parent::__construct();
        //Loggedin user details
        $this->sess_user_id = $this->common_lib->get_sess_user('id');        
        
        //Render header, footer, navbar, sidebar etc common elements of templates
        $this->common_lib->init_template_elements('site');
        
        // Load required js files for this controller
        $javascript_files = array(
            $this->router->class
        );
        $this->data['app_js'] = $this->common_lib->add_javascript($javascript_files);
		        
        
        
		
		//Check if any user logged in else redirect to login
        $is_logged_in = $this->common_lib->is_logged_in();
        if ($is_logged_in == FALSE) {
			$this->session->set_userdata('sess_post_login_redirect_url', current_url());
            redirect($this->router->directory.'user/login');
        }
        
		$this->load->model('timesheet_model');
		$this->id = $this->uri->segment(3);
		
		//Dropdown
		$this->data['project_arr'] = $this->timesheet_model->get_project_dropdown();
		$this->data['task_task_activity_type_array'] = $this->timesheet_model->get_activity_dropdown();
		$this->data['timesheet_hours'] = $this->timesheet_model->get_timesheet_hours_dropdown();
		
		//View Page Config
		$this->data['page_title'] = $this->router->class.' : '.$this->router->method;
        
    }
	
	function index() {
		$year = $this->uri->segment(3) ? $this->uri->segment(3) : date('Y');
		$month = $this->uri->segment(4) ? $this->uri->segment(4) : date('m');
		$day = date('d');
		
		$template='';
		$template.='{table_open}<table class="table ci-calendar table-sm" border="0" cellpadding="" cellspacing="">{/table_open}';
		$template.='{heading_row_start}<tr class="mn">{/heading_row_start}';
		$template.='{heading_previous_cell}<th class="prevcell"><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}';
		$template.='{heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}';
		$template.='{heading_next_cell}<th class="nextcell"><a href="{next_url}" >&gt;&gt;</a></th>{/heading_next_cell}';
		$template.='{heading_row_end}</tr>{/heading_row_end}';
		$template.='{week_row_start}<tr class="wk_nm">{/week_row_start}';
		$template.='{week_day_cell}<td>{week_day}</td>{/week_day_cell}';
		$template.='{week_row_end}</tr>{/week_row_end}';
		
		$css_days_rows = ($month != date('m'))? 'disabled_m': 'allowed_m';
		$template.='{cal_row_start}<tr class="'.$css_days_rows.'">{/cal_row_start}';
		
		$template.='{cal_cell_start}<td class="day">{/cal_cell_start}';
		$template.='{cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}';
		$template.='{cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}';
		$template.='{cal_cell_no_content}{day}{/cal_cell_no_content}';
		$template.='{cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}';
		$template.='{cal_cell_blank}&nbsp;{/cal_cell_blank}';
		$template.='{cal_cell_end}</td>{/cal_cell_end}';		
		$template.='{cal_row_end}</tr>{/cal_row_end}';	
		
		$template.='{table_close}</table>{/table_close}';
		
		$prefs = array (
               'start_day'    => 'monday',
               'month_type'   => 'short',
               'day_type'     => 'short',
			   'show_next_prev'=>TRUE,			   
			   'template'	  =>  $template
             );
		$this->load->library('calendar',$prefs);
		
		$this->data['entry_for'] = date('Y/m/d');
		
		
		
		$data = array();
		$this->data['cal'] = $this->calendar->generate($year,$month,$data);
		$month_name = date('M', mktime(0, 0, 0, $month, 10));		
		$this->data['page_title'] = 'My Timesheet : '.$month_name.' '.$year;
		
		$this->add();
		
        $this->data['maincontent'] = $this->load->view('site/'.$this->router->class.'/index', $this->data, true);
        $this->load->view('site/_layouts/layout_default', $this->data);
    }
	
	function add() {
        //Check user permission by permission name mapped to db
        //$is_authorized = $this->common_lib->is_auth('timesheet-add');
        
        
        
        if ($this->input->post('form_action') == 'add') {
            if ($this->validate_form_data('add') == true) {
                
				$selected_date_arr = explode(',', $this->input->post('selected_date'));
				//print_r($selected_date_arr); die();
				$batch_post_data = array();
				foreach($selected_date_arr as $key=>$day){
					$year = $this->uri->segment(3) ? $this->uri->segment(3) : date('Y');
					$month = $this->uri->segment(4) ? $this->uri->segment(4) : date('m');
					$batch_post_data[$key] = array(
						'timesheet_date' => $year.'-'.$month.'-'.$day,
						'project_id' => $this->input->post('project_id'),
						'activity_id' => $this->input->post('activity_id'),
						'timesheet_hours' => $this->input->post('timesheet_hours'),
						'timesheet_description' => $this->input->post('timesheet_description'),
						'timesheet_created_by' => $this->sess_user_id,					
						'timesheet_created_on' => date('Y-m-d H:i:s')					
					);
				}
                $insert_id = $this->timesheet_model->insert_batch($batch_post_data);
                if ($insert_id) {
                    $this->common_lib->set_flash_message('Timesheet Entry Added Successfully.', 'alert-success');
                    redirect(current_url());
                }
            }
        }
    }
	
	function validate_form_data($action = NULL) {
        $this->form_validation->set_rules('selected_date', 'calendar date selection', 'required');
        $this->form_validation->set_rules('project_id', 'project selection', 'required');
        $this->form_validation->set_rules('activity_id', 'activity selection', 'required');
        $this->form_validation->set_rules('timesheet_hours', 'time spent', 'required|numeric|less_than[18]|greater_than[0]');
        $this->form_validation->set_rules('timesheet_description', 'description', 'required|max_length[200]');
        $this->form_validation->set_error_delimiters('<div class="validation-error">', '</div>');
        if ($this->form_validation->run() == true) {
            return true;
        } else {
            return false;
        }
    }
		
	function timesheet_stats(){		
		$year = $this->input->get_post('year') ? $this->input->get_post('year') : date('Y');
        $month = $this->input->get_post('month') ? $this->input->get_post('month') : date('m');
        $user_id =  $this->sess_user_id;		
		$response = array(
            'status' => 'init',
            'message' => '',
            'message_css' => '',
            'data' => array(),
        );		
		if($this->input->post('via')=='ajax'){			
			$result_array = $this->timesheet_model->get_timesheet_stats($year, $month, $user_id);			
			if($result_array['num_rows']>0){
				$response = array(
					'status' => 'ok',
					'message' => 'Records fetched',
					'message_css' => 'alert alert-success',
					'data' => $result_array,
				);
			}else{
				$response = array(
					'status' => 'ok',
					'message' => 'No records found',
					'message_css' => 'alert alert-danger',
					'data' => $result_array,
				);
			}
			echo json_encode($response);die();
		}else{
			die("404: Not Found");
		}
	}
	
	function render_datatable() {
		$year = $this->input->get_post('year') ? $this->input->get_post('year') : date('Y');
        $month = $this->input->get_post('month') ? $this->input->get_post('month') : date('m');
        $current_year = date('Y');
        $current_month = date('m');
        $user_id = $this->sess_user_id;
        //Total rows - Refer to model method definition
        $result_array = $this->timesheet_model->get_rows(NULL, NULL, NULL, FALSE, FALSE, TRUE, $year, $month, $user_id);
        $total_rows = $result_array['num_rows'];

        // Total filtered rows - check without limit query. Refer to model method definition
        $result_array = $this->timesheet_model->get_rows(NULL, NULL, NULL, TRUE, FALSE, TRUE, $year, $month, $user_id);
        $total_filtered = $result_array['num_rows'];

        // Data Rows - Refer to model method definition
        $result_array = $this->timesheet_model->get_rows(NULL, NULL, NULL, TRUE, TRUE, TRUE, $year, $month, $user_id);
        $data_rows = $result_array['data_rows'];
        $data = array();
        $no = $_REQUEST['start'];
        foreach ($data_rows as $result) {
            $no++;
            $row = array();
            //$row[] = $this->common_lib->display_date($result['timesheet_date']);
            //$row[] = $result['project_name'];
            //$row[] = $result['task_activity_name'];
            //$row[] = $result['timesheet_hours'];
            //$row[] = $result['timesheet_review_status'];
			
			$html = '<div class="font-weight-bold">'.$this->common_lib->display_date($result['timesheet_date']).' <span class="float-right"><i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> '.$result['timesheet_hours'].' hrs</span></div>';			
			$html.= '<div class="">'.$result['project_number'].' '.$result['project_name'].'<span class="float-right">'.$result['task_activity_name'].'</span></div>';			
			
            
                //add html for action
                $action_html = '<span class="float-right">';
                if(($year == $current_year) && ($month == $current_month)){
                $action_html.= anchor(base_url($this->router->directory.$this->router->class.'/edit/' . $result['id']), '<i class="fa fa-fw fa-pencil" aria-hidden="true"></i>', array(
                    'class' => 'btn btn-sm btn-outline-secondary',
                    'data-toggle' => 'tooltip',
                    'data-original-title' => 'Edit',
                    'title' => 'Edit',
                ));            
                $action_html.= anchor(base_url($this->router->directory.$this->router->class.'/delete/' . $result['id']), '<i class="fa fa-fw fa-trash-o" aria-hidden="true"></i>', array(
                    'class' => 'btn btn-sm btn-outline-danger btn-delete',
                    'data-confirmation'=>false,
                    'data-confirmation-message'=>'Are you sure, you want to delete this?',
                    'data-toggle' => 'tooltip',
                    'data-original-title' => 'Delete',
                    'title' => 'Delete',
                ));
                }
                $action_html.='</span>';           
            
			$html.= '<div>'.$result['timesheet_description'].' '.$action_html.'</div>';		
			//$html.=$action_html;

            //$row[] = $action_html;
			$row[] = $html;
            $data[] = $row;
        }

        /* jQuery Data Table JSON format */
        $output = array(
            'draw' => isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '',
            'recordsTotal' => $total_rows,
            'recordsFiltered' => $total_filtered,
            'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    function edit() {
        
        
        
        $year = $this->input->get_post('year') ? $this->input->get_post('year') : date('Y');
        $month = $this->input->get_post('month') ? $this->input->get_post('month') : date('m');
        $current_year = date('Y');
        $current_month = date('m');

        if ($this->input->post('form_action') == 'update') {
            if ($this->validate_form_data('edit') == true) {
                $postdata = array(                    
                    'project_id' => $this->input->post('project_id'),
                    'activity_id' => $this->input->post('activity_id'),
                    'timesheet_hours' => $this->input->post('timesheet_hours'),
                    'timesheet_description' => $this->input->post('timesheet_description')
                );
                $where_array = array('id' => $this->input->post('id'));
                $res = $this->timesheet_model->update($postdata, $where_array);

                if ($res) {
                    $this->common_lib->set_flash_message('Data Updated Successfully.', 'alert-success');
                    redirect(current_url());
                }
            }
        }
        $result_array = $this->timesheet_model->get_rows($this->id, NULL, NULL, TRUE, TRUE, TRUE, $current_year, $current_month);
        $this->data['rows'] = $result_array['data_rows'];
        if(sizeof($this->data['rows'])<=0){
            redirect($this->router->directory.$this->router->class);
        }
		$this->data['page_title'] = 'Edit Timesheet Entry for ';
        $this->data['maincontent'] = $this->load->view('site/'.$this->router->class.'/edit', $this->data, true);
        $this->load->view('site/_layouts/layout_default', $this->data);
    }


	function delete() {
		$this->id= $this->uri->segment(3);
        $where_array = array('id' => $this->id);
        $res = $this->timesheet_model->delete($where_array);
        if ($res) {
            $this->common_lib->set_flash_message('Timesheet Entry Deleted Successfully.', 'alert-success');
            redirect($this->router->directory.$this->router->class.'');
        }
    }

    function validate_days_diff(){
        $from_date = strtotime($this->common_lib->convert_to_mysql($this->input->post('from_date'))); // or your date as well
        $to_date = strtotime($this->common_lib->convert_to_mysql($this->input->post('to_date')));
        $datediff = ($to_date - $from_date);
        $no_day = round($datediff / (60 * 60 * 24));
        if($no_day >= 0 ){
            return true;
        }else{
            $this->form_validation->set_message('validate_days_diff', 'Invalid date range.');
            return false;
        }
    }
}

?>
