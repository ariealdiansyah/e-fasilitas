<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title">View Peminjaman</h4>
</div>

<div class="modal-body">

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label>Peminjam</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->nameUser ?>
				</p>
			</div>
			<div class="form-group">
				<label>No. Dokumen</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->noDokPeminjaman ?>
				</p>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Waktu Pinjam</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= date('d/m/Y', strtotime($data[0]->tanggalPinjam)) ?> <b>s/d</b> <?= date('d/m/Y', strtotime($data[0]->batasPinjam)) ?>
				</p>
			</div>
			<div class="form-group">
				<label>Status</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->statusPeminjaman ?>
				</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label>Tujuan</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->tujuanPinjam ?>
				</p>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Catatan</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= ($data[0]->catatanPinjam) ? $data[0]->catatanPinjam : '-' ?>
				</p>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 20px;">
		<div class="col-sm-12">
			<h5>
				<strong>Barang yang dipinjam</strong>
			</h5>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>Nama Barang</th>
						<th class="text-center">Kode Item</th>
						<th class="text-center">Jumlah</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($data as $row){
						?>
						<tr>
							<td><?= $row->namaBarang ?></td>
							<td class="text-center"><?= $row->kodeItem ?></td>
							<td class="text-center"><?= $row->jumlah ?></td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

</div>