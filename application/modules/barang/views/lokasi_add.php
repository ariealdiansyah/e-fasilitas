<div class="container">
	<?= getBread() ?>	

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Tambah Lokasi</h3>
				</div>
				<div class="panel-body">
					<div class="row"> 
						<div class="col-lg-12"> 
							<form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>index.php/<?php echo getModule() ?>/<?php echo getController() ?>/save">
								<input type="hidden" name="idLokasi" class="form-control" value="<?php echo ($getLokasi) ? $getLokasi[0]['idLokasi'] : "" ?>">
								<?php echo input_text_group('kodeLokasi','Kode Lokasi',(@$getLokasi[0]['kodeLokasi']) ? @$getLokasi[0]['kodeLokasi'] : set_value('kodeLokasi'),'Kode Lokasi','required') ?>
								<?php echo input_text_group('deskripsiLokasi','Deskripsi Lokasi',(@$getLokasi[0]['deskripsiLokasi']) ? @$getLokasi[0]['deskripsiLokasi'] : set_value('deskripsiLokasi'),'Deskripsi Lokasi','required') ?>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
									&nbsp;
									<button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Batal</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>