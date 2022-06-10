<section class="content-header">
	<div class="content-header-left">
		<h1>View Service</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/service/add" class="btn btn-primary btn-sm">Add New</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">

			<?php
	        if($this->session->flashdata('error')) {
	            ?>
				<div class="callout callout-danger">
					<p><?php echo $this->session->flashdata('error'); ?></p>
				</div>
	            <?php
	        }
	        if($this->session->flashdata('success')) {
	            ?>
				<div class="callout callout-success">
					<p><?php echo $this->session->flashdata('success'); ?></p>
				</div>
	            <?php
	        }
	        ?>
	        
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>SL</th>
								<th>Name</th>
								<th>Photo</th>
								<th width="140">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($service as $row) {
								?>
								<tr>
									<td><?php echo $row['row']; ?></td>
                                    <td><a href="<?php echo base_url();?>backend/admin/service/edit/<?php echo $row['id'];?>"><?php echo $row['name']; ?></a></td>
									<td style="width:200px;"><img src="<?php echo base_url(); ?>public/uploads/service_photos/<?php echo $row['photo']; ?>" alt="<?php echo $row['name']; ?>" style="width:200px;"></td>
									<td>
										<a href="<?php echo base_url(); ?>backend/admin/service/edit/<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
										<a href="<?php echo base_url(); ?>backend/admin/service/delete/<?php echo $row['id']; ?>" class="btn btn-danger btn-xs" onClick="return confirm('Are you sure?');">Delete</a>
									</td>
								</tr>
								<?php
							}
							?>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>