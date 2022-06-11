<section class="content-header">
	<div class="content-header-left">
		<h1>User FAQ</h1>
	</div>
	<div class="content-header-right">
		<a href="<?php echo base_url(); ?>backend/admin/user" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if ($this->session->flashdata('error')) : ?>
				<div class="callout callout-danger">
					<p><?php echo $this->session->flashdata('error'); ?></p>
				</div>
			<?php endif; ?>
			<?php if ($this->session->flashdata('success')) : ?>
				<div class="callout callout-success">
					<p><?php echo $this->session->flashdata('success'); ?></p>
				</div>
			<?php endif; ?>

			<?php echo form_open(base_url() . 'backend/admin/user/update/' . $user->id, array('class' => 'form-horizontal')); ?>
			<div class="box box-info">
				<div class="box-body">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Username <span>*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="username" value="<?php echo $user->username; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Email <span>*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="email" value="<?php echo $user->username; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Status<span>*</span></label>
						<div class="col-sm-2">
							<select name="show_on_home" class="form-control select2">
								<option value="Active" <?php if ($user->status == 'Active') {
															echo 'selected';
														} ?>>Active</option>
								<option value="Passive" <?php if ($user->status == 'Passive') {
															echo 'selected';
														} ?>>Passive</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Role</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" name="row" value="<?php echo $user->role; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</section>