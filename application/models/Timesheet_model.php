<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Timesheet_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function insert($postdata, $table = NULL) {
        if ($table == NULL) {
            $this->db->insert('timesheet', $postdata);
        } else {
            $this->db->insert($table, $postdata);
        }
        //echo $this->db->last_query(); die();
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
	
	function insert_batch($postdata, $table = NULL) {
        if ($table == NULL) {
            $this->db->insert_batch('timesheet', $postdata);
        } else {
            $this->db->insert_batch($table, $postdata);
        }
        //echo $this->db->last_query(); die();
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($postdata, $where_array = NULL, $table = NULL) {
        $this->db->where($where_array);
        if ($table == NULL) {
            $result = $this->db->update('timesheet', $postdata);
        } else {
            $result = $this->db->update($table, $postdata);
        }
        //echo $this->db->last_query(); die();
        return $result;
    }

    function delete($where_array = NULL, $table = NULL) {
        $this->db->where($where_array);
        if ($table == NULL) {
            $result = $this->db->delete('timesheet');
        } else {
            $result = $this->db->delete($table);
        }
        //echo $this->db->last_query(); die();
        return $result;
    }

    function get_rows($id = NULL, $limit = NULL, $offset = NULL, $dataTable = FALSE, $checkPaging = TRUE) {
        $result = array();
        $this->db->select('
		t1.*
		');        
        if ($id) {
            $this->db->where('t1.id', $id);
        }
		
        ####################################################################
        ##################### Display using Data Table #####################
        ####################################################################
        if ($dataTable == TRUE) {
            //set column field database for datatable orderable
            $column_order = array(
                't1.timesheet_date',
                't1.project_id',
                't1.activity_id',
                't1.timesheet_hours',
                NULL,
            );            
            //set column field database(table column name) for datatable searchable
            $column_search = array(
                't1.timesheet_date',
                't1.project_id',
                't1.activity_id',
                't1.timesheet_hours'
                );
             // default order
            $order = array(
                't1.timesheet_date' => 'desc'
                );
            $i = 0;
            foreach ($column_search as $item) { // loop column
                if (isset($_REQUEST['search']['value'])) { // if datatable send POST for search
                    if ($i === 0) { // first loop
                        $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->db->like($item, $_REQUEST['search']['value']);
                    } else {
                        $this->db->or_like($item, $_REQUEST['search']['value']);
                    }
                    if (count($column_search) - 1 == $i) { //last loop
                        $this->db->group_end(); //close bracket
                    }
                }
                $i++;
            }
            if (isset($_REQUEST['order'])) { // here order processing
                $this->db->order_by($column_order[$_REQUEST['order']['0']['column']], $_REQUEST['order']['0']['dir']);
            } else if (isset($order)) {
                $this->db->order_by(key($order), $order[key($order)]);
            }
            //Paging, checkPaging flag added for counting filtered rows without limit offset
            if (($checkPaging == TRUE) && (isset($_REQUEST['length']) && $_REQUEST['length'] != -1)) {
                $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
            }//End of paging
        }//if $dataTable
        ####################################################################
        ##################### Display using Data Table Ends ################
        ####################################################################
        else {
            if ($limit) {
                $this->db->limit($limit, $offset);
            }
        }
        $query = $this->db->get('timesheet as t1');
        //print_r($this->db->last_query());
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        return array('num_rows' => $num_rows, 'data_rows' => $result);
    }

    	
	function get_timesheet_stats($year,$month){		
		$this->db->select('
		t1.id, 
		t1.timesheet_date, 
		DATE_FORMAT(t1.`timesheet_date`,"%Y") as timesheet_year,
		DATE_FORMAT(t1.`timesheet_date`,"%m") as timesheet_month,
		DATE_FORMAT(t1.`timesheet_date`,"%d") as timesheet_day,
		t1.timesheet_hours,
		t1.timesheet_review_status		
		');        
        $this->db->where(
			array(
			'YEAR(`timesheet_date`)' => $year,
			'MONTH(`timesheet_date`)' => $month,
			)
		);
		
        $query = $this->db->get('timesheet as t1');
		//echo $this->db->last_query(); //die();
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        return array('num_rows' => $num_rows, 'data_rows' => $result);
        return $result;
	}

}
