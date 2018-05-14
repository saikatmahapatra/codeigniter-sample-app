<?php $row = $row[0]; ?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Update Basic Info</h1>               
    </div>
</div><!--/.row-->


<div class="row"> 
    <?php
    // Show server side messages
    if (isset($alert_message)) {
        $html_alert_ui = '';
        $html_alert_ui.='<div class="alert-container">';
        $html_alert_ui.='<div class="auto-closable-alert alert ' . $alert_message_css . ' alert-dismissable">';
        $html_alert_ui.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $html_alert_ui.=$alert_message;
        $html_alert_ui.='</div>';
        $html_alert_ui.='</div>';
        echo $html_alert_ui;
    }
    ?> 
    <div class="col-md-6">
        <?php echo form_open(current_url(), array('method' => 'post', 'class' => 'ci-form',
            'name' => 'profile',
            'id' => 'profile',));
        ?>
        <?php echo form_hidden('form_action', 'update_profile'); ?>
        
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">                                
						<label for="user_firstname" class="">First Name <span class="required">*</span></label>
                        <?php
                        echo form_input(array(
                            'name' => 'user_firstname',
                            'value' => isset($row['user_firstname']) ? $row['user_firstname'] : set_value('user_firstname'),
                            'id' => 'user_firstname',
                            'class' => 'form-control',
                            'maxlength' => '30',
                        ));
                        ?>
                        <?php echo form_error('user_firstname'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">  
						<label for="user_lastname" class="">Last Name <span class="required">*</span></label>
                        <?php
                        echo form_input(array(
                            'name' => 'user_lastname',
                            'value' => isset($row['user_lastname']) ? $row['user_lastname'] : set_value('user_lastname'),
                            'id' => 'user_lastname',
                            'class' => 'form-control',
                            'maxlength' => '50',
                        ));
                        ?>
                        <?php echo form_error('user_lastname'); ?>
                    </div>
                </div>
            </div><!--/.row-->
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
						<label for="user_intro" class="">Intro</label>
						<?php
						echo form_textarea(array(
							'name' => 'user_intro',
							'value' => isset($row['user_intro']) ? $row['user_intro'] : set_value('user_intro'),
							'id' => 'user_intro',
							'class' => 'form-control',
							'rows' => '2',
							'cols' => '40',
							'placeholder' => 'Describe who you are',
							'title' => 'Short Introduction',							
							'maxlength' => '100',
						));
						?>
                        <?php echo form_error('user_intro'); ?>
                    </div>
                </div>
            </div><!--/.row-->
            <div class="row">
                <div class="col-md-12">
                    <label class="">Gender <span class="required">*</span></label>
                    <div class="radio">  
                        <label class="label-normal">
                            <?php
                            $radio_is_checked = (isset($row['user_gender']) ? $row['user_gender'] : $this->input->post('user_gender')) === 'M';
                            echo form_radio(array(
                                'name' => 'user_gender',
                                'value' => 'M',
                                'id' => 'm',
                                'checked' => $radio_is_checked,
                                'class' => '',
								), set_radio('user_gender', 'M')
                            );
                            ?>
                            <span>Male</span>
                        </label>                    
                        <label class="label-normal">
                            <?php
                            $radio_is_checked = (isset($row['user_gender']) ? $row['user_gender'] : $this->input->post('user_gender')) === 'F';
                            echo form_radio(array(
                                'name' => 'user_gender',
                                'value' => 'F',
                                'id' => 'f',
                                'checked' => $radio_is_checked,
                                'class' => ''
								), set_radio('user_gender', 'F')
                            );
                            ?>
                            <span>Female</span>
                        </label>                    
                        <?php echo form_error('user_gender'); ?>
                    </div>
                </div>
            </div><!--/.row-->
        
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
						<label for="user_mobile_phone1" class="">Mobile #1 <span class="required">*</span></label>
                        <?php
                        echo form_input(array(
                            'name' => 'user_mobile_phone1',
                            'value' => isset($row['user_mobile_phone1']) ? $row['user_mobile_phone1'] : set_value('user_mobile_phone1'),
                            'id' => 'user_mobile_phone1',
                            'class' => 'form-control',
                            'maxlength' => '10',
                            'minlength' => '10',
                        ));
                        ?>
                        <?php echo form_error('user_mobile_phone1'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
						<label for="user_mobile_phone2" class="">Mobile #2</label>
                        <?php
                        echo form_input(array(
                            'name' => 'user_mobile_phone2',
                            'value' => isset($row['user_mobile_phone2']) ? $row['user_mobile_phone2'] : set_value('user_mobile_phone2'),
                            'id' => 'user_mobile_phone2',
                            'class' => 'form-control',
                            'maxlength' => '10',
                            'minlength' => '10',
                        ));
                        ?>
                        <?php echo form_error('user_mobile_phone2'); ?>
                    </div>
                </div>
            </div><!--/.row-->
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
					<a href="<?php echo site_url('user/profile');?>" class="btn btn-secondary">Back</a>
					<?php echo form_submit(array('name' => 'submit','value' => 'Update','class' => 'btn btn-primary',));?> 
					</div>
				</div>
			</div><!--/.row-->
        <?php echo form_close(); ?>
    </div><!--/.col-md-6-->
</div>