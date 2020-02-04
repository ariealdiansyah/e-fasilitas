
<div class="container">
	<?= getBread() ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Role User</h3>
				</div>
				<div class="panel-body">
					<div class="row"> 
						<form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>index.php/<?php echo getModule() ?>/<?php echo getController() ?>/save">
							<input type="hidden" name="idRole" class="form-control" value="<?php echo (@$getRole[0]['idRole']) ? $getRole[0]['idRole'] : "" ?>">
							<?php echo input_text_group('namaRole','Nama',(@$getRole[0]['namaRole']) ? @$getRole[0]['namaRole'] : set_value('namaRole'),'Nama Role','required') ?>								
							<?php echo input_textarea_group('descRole','Keterangan',(@$getRole[0]['descRole']) ? @$getRole[0]['descRole'] : set_value('descRole'),'Keterangan Role','') ?>								
							<div class="form-group">
								<div class="col-sm-2"></div>
								<div class="col-sm-6">
									<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/privilege/<?php echo @$getRole[0]['idRole'] ?>"><button type="button" class="btn btn-info"><i class="fa fa-users"></i> Ubah Hak Akses</button></a>
								</div>
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