<?php
$row = $rows[0];
?>
<?php //echo isset($breadcrumbs) ? $breadcrumbs : ''; ?>
<div class="row heading-container">
    <div class="col-12">
        <h1 class="page-header"><?php echo isset($page_heading)? $page_heading:'Page Heading'; ?></h1>
    </div>
</div><!--/.heading-container-->

<div class="row">
	<div class="col-md-9">
		<?php
		// Show server side flash messages
		if (isset($alert_message)) {
			$html_alert_ui = '';                
			$html_alert_ui.='<div class="auto-closable-alert alert ' . $alert_message_css . ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.$alert_message.'</div>';
			echo $html_alert_ui;
		}
		?>
		<?php echo form_open(current_url(), array('method' => 'post', 'class'=>'ci-form','name' => 'myform','id' => 'myform','role' =>'form')); ?>
		<?php echo form_hidden('form_action', 'update'); ?>
		<?php echo form_hidden('id', $row['id']); ?>
		
		<div class="form-row">		
			<div class="form-group col-md-12">
				
			</div>
		</div>
		
		<div class="form-row">
			<div class="form-group col-md-4">
				<label for="pagecontent_type" class="">Content Type <span class="required">*</span></label>
				<?php echo form_dropdown('pagecontent_type', $arr_content_type, (isset($_POST['pagecontent_type']) ? set_value('pagecontent_type') : $row['pagecontent_type']), array('class' => 'form-control',));?>
				<?php echo form_error('pagecontent_type'); ?>
			</div>		
			<div class="form-group col-md-8">
				<label for="pagecontent_title" class="">Content Title <span class="required">*</span></label>
				<?php echo form_input(array('name' => 'pagecontent_title', 'value' => (isset($_POST['pagecontent_title']) ? set_value('pagecontent_title') : $row['pagecontent_title']), 'id' => 'pagecontent_title', 'class' => 'form-control', 'placeholder' => ''));?>
				<?php echo form_error('pagecontent_title'); ?>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label for="pagecontent_text" class="">Content(HTML) <span class="required">*</span></label>
			<?php echo form_textarea(array('name' => 'pagecontent_text','value' => (isset($_POST['pagecontent_text']) ? set_value('pagecontent_text') : $row['pagecontent_text']),'class' => 'form-control textarea','id' => 'pagecontent_text','rows' => '2','cols' => '50','placeholder' => '')); ?>
			<?php echo form_error('pagecontent_text'); ?>
		</div>
		
		<?php /* ?>
		<div class="form-row">			
			<div class="form-group col-md-4 d-none">
				<label for="pagecontent_display_start_date" class="">Display from date</label>
				<?php echo form_input(array('name' => 'pagecontent_display_start_date','value' => (isset($_POST['pagecontent_display_start_date']) ? set_value('pagecontent_display_start_date') : $row['pagecontent_display_start_date']),'id' => 'pagecontent_display_start_date','class' => 'form-control cms-datepicker', 'placeholder' => 'dd-mm-yyyy','readonly'=>true));?>
				<?php echo form_error('pagecontent_display_start_date'); ?>
			</div>		
			<div class="form-group col-md-4 d-none">
				<label for="pagecontent_display_end_date" class="">Display to Date</label>
				<?php echo form_input(array('name' => 'pagecontent_display_end_date','value' => (isset($_POST['pagecontent_display_end_date']) ? set_value('pagecontent_display_end_date') : $row['pagecontent_display_end_date']),'class' => 'form-control cms-datepicker','id' => 'pagecontent_display_end_date','placeholder' => 'dd-mm-yyyy','readonly'=>true));?>
				<?php echo form_error('pagecontent_display_end_date'); ?>
			</div>			
		</div>
		<?php */ ?>
		
		<?php /* ?>
		<div class="form-row">		
			<div class="form-group col-md-4">
				<label for="pagecontent_meta_keywords" class="">Meta Keywords</label>
				<?php echo form_input(array('name' => 'pagecontent_meta_keywords','value' => (isset($_POST['pagecontent_meta_keywords']) ? set_value('pagecontent_meta_keywords') : $row['pagecontent_meta_keywords']),'id' => 'pagecontent_meta_keywords','class' => 'form-control', 'placeholder' => '')); ?>
				<?php echo form_error('pagecontent_meta_keywords'); ?>
			</div>
		
			<div class="form-group col-md-4">
				<label for="pagecontent_meta_description" class="">Meta Description</label>
				<?php echo form_input(array('name' => 'pagecontent_meta_description','value' => (isset($_POST['pagecontent_meta_description']) ? set_value('pagecontent_meta_description') : $row['pagecontent_meta_description']),'id' => 'pagecontent_meta_description','class' => 'form-control', 'placeholder' => ''));?>
				<?php echo form_error('pagecontent_meta_description'); ?>
			</div>
		
			<div class="form-group col-md-4">
				<label for="pagecontent_meta_author" class="">Meta Author</label>
				<?php echo form_input(array('name' => 'pagecontent_meta_author','value' => (isset($_POST['pagecontent_meta_author']) ? set_value('pagecontent_meta_author') : $row['pagecontent_meta_author']),'class' => 'form-control','id' => 'pagecontent_meta_author','placeholder' => ''));?>
				<?php echo form_error('pagecontent_meta_author'); ?>
			</div>		
		</div>
		<?php */ ?>
		<?php /* ?>
		<div class="form-row">		
			<div class="form-group col-md-3">									
				<label for="pagecontent_status" class="">Publish</label>
				<?php echo form_dropdown('pagecontent_status', array('Y'=>'Yes','N'=>'No'), (isset($_POST['pagecontent_status']) ? set_value('pagecontent_status') : $row['pagecontent_status']), array('class' => 'form-control')); ?>
				<?php echo form_error('pagecontent_status'); ?>
			</div>	
			
			<div class="form-group col-md-3">									
				<label for="pagecontent_archived" class="">Archived</label>
				<?php echo form_dropdown('pagecontent_archived', array('Y'=>'Yes','N'=>'No'), (isset($_POST['pagecontent_archived']) ? set_value('pagecontent_archived') : $row['pagecontent_archived']), array('class' => 'form-control'));?>
				<?php echo form_error('pagecontent_archived'); ?>
			</div>	
			
		</div>
		<?php */ ?>

		<div class="form-row">
		<div class="form-group col-md-12">									
			<label for="pagecontent_status" class="">Display Status <span class="required">*</span></label>
				<?php //echo form_dropdown('pagecontent_status', array('Y'=>'Yes','N'=>'No'), (isset($_POST['pagecontent_status']) ? set_value('pagecontent_status') : $row['pagecontent_status']), array('class' => 'form-control')); ?>
				  	<!--<div class="">-->
						<div class="custom-control custom-radio custom-control-inline">
							<?php
								$radio_is_checked = isset($_POST['pagecontent_status']) ? $_POST['pagecontent_status'] == 'Y' : ($row['pagecontent_status'] == 'Y');

								echo form_radio(array('name' => 'pagecontent_status','value' => 'Y','id' => 'Y','checked' => $radio_is_checked,'class' => 'custom-control-input'), set_radio('pagecontent_status', 'Y'));
							?>
							<label class="custom-control-label" for="Y">Publish</span></label>
						</div>
						
						<div class="custom-control custom-radio custom-control-inline">
							<?php
								$radio_is_checked = isset($_POST['pagecontent_status']) ? $_POST['pagecontent_status'] == 'N' : ($row['pagecontent_status'] == 'N');

								echo form_radio(array('name' => 'pagecontent_status', 'value' => 'N', 'id' => 'N', 'checked' => $radio_is_checked, 'class' => 'custom-control-input'), set_radio('pagecontent_status', 'N'));
							?>
							<label class="custom-control-label" for="N">Unpublish</span></label>
						</div>								
					<!--</div>-->
					<small id="emailHelp" class="form-text text-muted">If you unpublish this, it will not displayed for public user(employees)</small>
					<?php echo form_error('pagecontent_status'); ?>


			</div>

		</div>

		<?php echo form_button(array('name' => 'submit_btn','type' => 'submit','content' => '<i class="fa fa-fw fa-check-circle"></i> Submit','class' => 'btn btn-primary'));?>
		
		<a href="<?php echo base_url($this->router->directory.$this->router->class);?>" class="ml-2 btn btn-secondary"><i class="fa fa-fw fa-times-circle"></i> Cancel</a>                             
		<?php echo form_close(); ?>
	</div>
</div>