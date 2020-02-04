<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 class="modal-title">View Perbaikan</h4>
</div>

<div class="modal-body">

	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label>Kode Perbaikan</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->kodePerbaikan ?>
				</p>
			</div>
			<div class="form-group">
				<label>Tanggal Lapor</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->tanggalLapor ?>
				</p>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Pelapor</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->nameUser ?>
				</p>
			</div>
			<div class="form-group">
				<label>Rincian Lapor</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->rincianLaporan ?>
				</p>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label>Status Perbaikan</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->statusPerbaikan ?>
				</p>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Nama Teknisi</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->namaTeknisi ?>
				</p>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Rincian Tindakan</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->rincianTindakan ?>
				</p>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label>Tanggal Tindakan</label>
				<p style="border-bottom: 1px solid #ddd">
					<?= $data[0]->tglTindakan ?>
				</p>
			</div>
		</div>
	</div>

	

</div>