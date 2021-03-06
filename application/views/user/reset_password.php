<h1 class="page-title"><?php echo isset($page_title) ? $page_title : 'Page Heading'; ?></h1>
<div class="row">
	<div class="col-lg-4">	
		<?php echo form_open(current_url(), array('method' => 'post', 'class'=>'')) ?>
		<?php echo isset($alert_message) ? $alert_message : ''; ?>
		<?php echo form_hidden('form_action', 'reset_password'); ?>
		<?php echo form_hidden('password_reset_key', $password_reset_key); ?>
		
			<div class="form-group">                    
				<label for="user_email" class="required">Registered Email</label>
				<?php
				echo form_input(array(
					'name' => 'user_email',
					'value' => set_value('user_email'),
					'id' => 'name',
					'class' => 'form-control',
					'placeholder' => '',
					'maxlength' => '255',
					'autofocus' => '',
				));
				?>         
				<?php echo form_error('user_email'); ?>
			</div>


			<div class="form-group">            
				<label for="user_new_password" class="required">New Password</label>
				<?php
				echo form_password(array(
					'name' => 'user_new_password',
					'value' => set_value('user_new_password'),
					'id' => 'user_new_password',
					'placeholder' => '',
					'class' => 'form-control',
					'maxlength' => '16',
				));
				?>        
				<?php echo form_error('user_new_password'); ?>
			</div>

			<div class="form-group">            
				<label for="confirm_user_new_password" class="required">Confirm New Password</label>
				<?php
				echo form_password(array(
					'name' => 'confirm_user_new_password',
					'value' => set_value('confirm_user_new_password'),
					'id' => 'confirm_user_new_password',
					'placeholder' => '',
					'class' => 'form-control',
					'maxlength' => '16',
				));
				?>        
				<?php echo form_error('confirm_user_new_password'); ?>
			</div>
			<?php echo form_button(array('name' => 'submit_btn','type' => 'submit','content' => 'Submit','class' => 'btn btn-primary'));?>	
			<?php form_close(); ?>
				
			<div class="mt-3">
				<a class="d-block" href="<?php echo base_url($this->router->directory.$this->router->class.'/login');?>">Back to login</a>
				<a class="d-block" href="<?php echo base_url($this->router->directory.$this->router->class.'/forgot_password');?>" class="">Resend password reset link</a>
			</div>
		</div>
	</div>