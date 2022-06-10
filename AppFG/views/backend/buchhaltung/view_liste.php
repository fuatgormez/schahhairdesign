<section class="content-header">
	<div class="content-header-left">
		<h1>Gelir Gider Listesi</h1>
	</div>
	<div class="content-header-right">
		<input id="datepicker2" class="btn btn-warning select_day" value="<?php echo $date;?>">
		<select class="btn btn-danger btn-sm select_month">
			<option>Ay Secin</option>
			<option value="1" <?php echo $month == 1 ? 'selected' : '';?>>Ocak</option>
			<option value="2" <?php echo $month == 2 ? 'selected' : '';?>>Subat</option>
			<option value="3" <?php echo $month == 3 ? 'selected' : '';?>>Mart</option>
			<option value="4" <?php echo $month == 4 ? 'selected' : '';?>>Nisan</option>
			<option value="5" <?php echo $month == 5 ? 'selected' : '';?>>Mayis</option>
			<option value="6" <?php echo $month == 6 ? 'selected' : '';?>>Haziran</option>
			<option value="7" <?php echo $month == 7 ? 'selected' : '';?>>Temmuz</option>
			<option value="8" <?php echo $month == 8 ? 'selected' : '';?>>Agustos</option>
			<option value="9" <?php echo $month == 9 ? 'selected' : '';?>>Eylül</option>
			<option value="10" <?php echo $month == 10 ? 'selected' : '';?>>Ekim</option>
			<option value="11" <?php echo $month == 11 ? 'selected' : '';?>>Kasim</option>
			<option value="12" <?php echo $month == 12 ? 'selected' : '';?>>Aralik</option>
		</select>
		<!-- Button trigger modal -->
		<span class="btn btn-primary buchhaltungModal">
			Gelir - Gider Ekle
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
					<table id="example1" class="content-table dataTable no-footer">
						<thead>
							<tr>
								<th width="10">id</th>
								<th>Açıklama</th>
								<th>Gelir</th>
								<th>Gider</th>
								<th>Toplam</th>
								<th>Tarih</th>
							</tr>
						</thead>
						<tbody>
							<?php $total = 0;
							foreach ($liste as $row) : ?>
								<tr class="get_data_buchhaltung" data-id="<?php echo $row['id']; ?>">
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $row['comment']; ?></td>
									<td><?php echo $row['income']; ?> €</td>
									<td><?php echo $row['expense']; ?> €</td>
									<td><?php echo $row['total']; ?> €</td>
									<td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
								</tr>
							<?php $total += $row['total'];
							endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<!-- small box -->
			<div class="small-box bg-aqua">
				<div class="inner">
					<p>&nbsp;</p>
					<h3 class="text-maroon text-center">Total: <?php echo number_format($total,2); ?> €</h3>
					<p>&nbsp;</p>
				</div>
				<div class="icon">
					<i class="fa fa-coins"></i>
				</div>
			</div>
		</div>
		<!-- ./col -->
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="buchhaltungModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="label bg-orange modal_date"><?php echo date('d M Y'); ?></span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<label>Gelir</label>
						<input type="text" name="income" class="form-control income">
					</div>
					<div class="col-md-6">
						<label>Gider</label>
						<input type="text" name="expense" class="form-control expense">
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<input name="comment" class="comment form-control" placeholder="Açıklama">
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<button type="button" class="btn btn-success btn-block add_buchhaltung">Hinzufügen</button>
						<button type="button" class="btn btn-primary btn-block edit_buchhaltung">Bearbeiten</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>