<section class="content-header">
	<div class="content-header-left">
		<h1>Kunden Liste</h1>
	</div>
	<div class="content-header-right">
		<!-- Button trigger modal -->
		<span class="btn btn-primary new_customer">
			Neue Kunde hinzufügen
		</span>
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


			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="customer_list" class="content-table dataTable no-footer">
						<thead>
							<tr>
								<th width="10">id</th>
								<th>Vorname / Nachname</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($liste as $row) : ?>
								<tr class="get_data_customer" data-id="<?php echo $row['id']; ?>">
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $row['customer_name']; ?></td>
									<td><?php echo $row['customer_email']; ?></td>
									<td><?php echo $row['customer_phone']; ?></td>
									<td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="new_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="label bg-green modal_title">Neue Kunde hinzufügen</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4">
						<label>Vorname / nachname</label>
						<input type="text" name="customer_name" class="form-control customer_name">
					</div>
					<div class="col-md-5">
						<label>Email</label>
						<input type="text" name="customer_email" class="form-control customer_email">
					</div>
					<div class="col-md-3">
						<label>Telefon</label>
						<input name="customer_phone" class="form-control customer_phone">
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<label>Beschreibung</label>
						<textarea name="description" id="editor1" class="form-control description"></textarea>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<button type="button" class="btn btn-success btn-block add_customer">Hinzufügen</button>
						<button type="button" class="btn btn-primary btn-block edit_customer hidden" data-id="0">Bearbeiten</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>