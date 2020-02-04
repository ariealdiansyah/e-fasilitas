<div class="container">
	<?= getBread() ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">User Group</h4>
				</div>
				<div class="panel-body">
					<div class="row"> 
						<form class="form-horizontal" role="form" method="post" action="<?= base_url(getModule().'/'.getController().'/save') ?>">
							
							<input type="hidden" name="idRole" class="form-control" value="<?php echo (@$getRole[0]['idRole']) ? $getRole[0]['idRole'] : "" ?>">
							<?php echo input_text_group('namaRole','Nama',(@$getRole[0]['namaRole']) ? @$getRole[0]['namaRole'] : set_value('namaRole'),'Nama Group','required') ?>								
							<?php echo input_textarea_group('descRole','Keterangan',(@$getRole[0]['descRole']) ? @$getRole[0]['descRole'] : set_value('descRole'),'Keterangan Group','') ?>	

							<div class="form-group">

								<label class="col-lg-2 col-sm-2 control-label">Akses Modul</label>

								<div class="col-sm-6 column-count-three">

									<?php
									foreach($getModule as $module){
										$roleModule = $this->model->get_where('role_module',array('idRole' => @$getRole[0]['idRole'],'idModule' => $module['idModule']));
										$checked = $module['idModule'] == @$roleModule[0]['idModule'] ? "checked" : "";
										?>

										<div class="checkbox checkbox-primary">
											<input type="checkbox" name="idModule[]" value="<?= $module['idModule'] ?>" <?= $checked ?>>
											<label><?= $module['nameModule'] ?></label>
										</div>

										<?php } ?>

									</div>

								</div>

								<?php echo input_radio_group('statusRole','Status',array('y'=>'Aktif','n'=>'Tidak Aktif'),(@$getRole[0]['statusRole']) ? @$getRole[0]['statusRole'] : "y",'') ?>


								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<button type="submit" class="btn btn-inverse"><i class="fa fa-save"></i> Simpan</button>
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