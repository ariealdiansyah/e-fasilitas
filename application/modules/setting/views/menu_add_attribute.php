<section class="wrapper">
	<!-- page start-->

	<div class="row">
		<div class="col-sm-12">
			<section class="panel">
				<header class="panel-heading">
					Tambah/Ubah Atribut
					<span class="tools pull-right">
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-cog"></a>
						<a href="javascript:;" class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>index.php/<?php echo getModule() ?>/<?php echo getController() ?>/save">
						<input type="hidden" name="idMenuPrivilege" class="form-control" value="<?php echo ($getMenuPrivilege) ? $getMenuPrivilege[0]['idMenuPrivilege'] : '' ?>">
						<?php
						$getIdMenu = str_replace(array('-', '_', '~'), array('+', '/', '='), $this->input->get('u'));
						$id = $this->encrypt->decode($getIdMenu);
						$getAttributeMenu = $this->model->get_where('pengaturan_attribute',array('idMenu'=>$getMenu[0]['idMenu']));
						$getPrivilegeMenu = $this->model->get_where('master_menu_privilege',array('idMenu'=>$id));
						foreach ($getPrivilegeMenu as $privilege) {
							$privilegeMenu[] = $privilege['actionMenuPrivilege'];
						}

						if (count($getPrivilegeMenu)>0) {
							$getDiffMenuPrivilege = array_diff($getMenuPrivilegeID,$privilegeMenu);
						}
						else{
							$getDiffMenuPrivilege = $this->model->get_where('pengaturan_attribute_detail',array('idPAttribute'=>$getAttributeMenu[0]['idPAttribute']));
						}

						foreach ($getAttributeMenu as $key => $value) {
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo $value['namePAttribute'] ?></label>
								<div class="col-sm-6">
									<?php 
									if (count($getMenuPrivilege)>0) {
										?>
										<input type="hidden" name="oldActionMenuPrivilege" class="form-control" value="<?php echo ($getMenuPrivilege) ? $getMenuPrivilege[0]['idPAttributeDetail'] : '' ?>">
										<?php
										echo select_join('namePAttributeDetail','idPAttributeDetail,namePAttributeDetail','pengaturan_attribute_detail','idPAttributeDetail','actionMenuPrivilege[]',array('idPAttribute'=>$value['idPAttribute']),($getMenuPrivilege) ? $getMenuPrivilege[0]['idPAttributeDetail'] : '');
									}
									else {
										?>
										<select multiple class='form-control search-select' name="actionMenuPrivilege[]" id="actionMenuPrivilege">
											<?php
											foreach ($getDiffMenuPrivilege as $DiffPrivilege) {
												$getDiff = $this->model->get_where('pengaturan_attribute_detail',array('idPAttributeDetail'=>$DiffPrivilege['idPAttributeDetail']));
												?>
												<option value="<?php echo $getDiff[0]['idPAttributeDetail'] ?>"><?php echo $getDiff[0]['namePAttributeDetail'] ?></option>
												<?php
											}
											?>
										</select>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
						<input type="hidden" name="idMenu" class="form-control" value="<?php echo ($getMenu) ? $id : $id ?>">
						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
								&nbsp;
								<button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
					</form>
				</div>
			</section>
		</div>
	</div>
</section>