<?php //echo isset($breadcrumbs) ? $breadcrumbs : ''; ?>
<h1 class="page-title"><?php echo isset($page_title) ? $page_title : 'Page Heading'; ?></h1>

<div class="row my-2">
	<div class="col-lg-12">
	<?php echo isset($alert_message) ? $alert_message : ''; ?>
	</div>	
</div>

<div class="row my-3">
	<div class="col-lg-12">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Request No</th>
						<th scope="col">Leave Type</th>
						<th scope="col">From Date</th>
						<th scope="col">To Date</th>
						<th scope="col">Days</th>
						<th scope="col">Leave Status</th>
						<!-- <th scope="col">Reason</th>-->
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
				<?php 
				if(sizeof($data_rows)>0){
					foreach($data_rows as $row){
						?>
						<tr>
							<td><a href="<?php echo base_url($this->router->directory.$this->router->class.'/details/'.$row['id'].'/'.$row['leave_req_id'].'/history');?>"><?php echo $row['leave_req_id'];?></a></td>
							<td><?php echo $leave_type_arr[$row['leave_type']];?></td>
							<td><?php echo $this->common_lib->display_date($row['leave_from_date']);?></td>
							<td><?php echo $this->common_lib->display_date($row['leave_to_date']);?></td>
							<td><?php echo $row['applied_for_days_count'].' day(s)';?></td>
							<td>
								<!-- <span class="small"><i class="fa fa-fw fa-bookmark-o <?php echo $leave_status_arr[$row['leave_status']]['css'];?>" aria-hidden="true"></i></span>  -->
								<span class="<?php echo $leave_status_arr[$row['leave_status']]['css'];?>"> <?php echo $leave_status_arr[$row['leave_status']]['text'];?></span>
							</td>
							<!-- <td><?php echo isset($row['leave_reason']) ? word_limiter($row['leave_reason'], 5) : '';?></td> -->
							<td>
							<a href="<?php echo base_url($this->router->directory.$this->router->class.'/details/'.$row['id'].'/'.$row['leave_req_id'].'/history');?>" class="btn btn-outline-info btn-sm">Details</a>
							<!-- <a href="<?php echo base_url($this->router->directory.$this->router->class.'/details/'.$row['id'].'/'.$row['leave_req_id'].'/history');?>" class="btn btn-outline-danger btn-sm">Cancel Request</a> -->
							</td>
						</tr>
						<?php
					}
				}
				else{
					?>
					<tr>
						<td colspan="7"> No leave records found</td>
					</tr>
					<?php
				}
				?>
				</tbody>
			</table>
			<div class="float-right"><?php echo $pagination_link; ?></div>			
		</div><!--/.table-responsive-->
	</div>
</div>