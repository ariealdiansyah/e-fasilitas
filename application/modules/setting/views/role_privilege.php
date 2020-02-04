<section class="wrapper">
	<!-- page start-->

	<div class="row">
		<div class="col-sm-12">
			<section class="panel">
				<header class="panel-heading">
					Tambah/Ubah Hak Akses
					<span class="tools pull-right">
						<a href="javascript:;" class="fa fa-chevron-down"></a>
						<a href="javascript:;" class="fa fa-cog"></a>
						<a href="javascript:;" class="fa fa-times"></a>
					</span>
				</header>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>/<?php echo getModule() ?>/<?php echo getController() ?>/save_privilege">
						<input type="hidden" name="idRole" class="form-control" value="<?php echo ($getRole) ? $getRole[0]['idRole'] : "" ?>">
						<?php
						foreach ($getParentMenu as $key => $value) 
						{
							$getMenuPrivilege = $this->model->join('master_menu_privilege','*',array(array('table'=>'pengaturan_attribute_detail','parameter'=>'master_menu_privilege.actionMenuPrivilege=pengaturan_attribute_detail.idPAttributeDetail')),array('idMenu'=>$value['idMenu']));
							?>
							<div class="form-group">
								<label class="col-sm-3 control-label col-lg-3" for="inputSuccess"><?php echo $value['namaMenu'] ?></label>
								<div class="col-lg-6">
									<?php 												
									foreach ($getMenuPrivilege as $subkey => $subvalue) {
										$getPrivilegeUser = $this->model->get_where('privilege_user',array('menuPrivilege'=>$subvalue['idMenu'],'actionPrivilege'=>$subvalue['actionMenuPrivilege'],'idRole'=>$getRole[0]['idRole']));
										?>
										<label class="checkbox-inline">
											<input type="hidden" name="idPrivilege[]" value="<?php echo (@$getPrivilegeUser[0]['idPrivilege']) ? @$getPrivilegeUser[0]['idPrivilege'] : '' ?>">
											<input type="checkbox" name="actionPrivilege[<?php echo $subvalue['idMenu'] ?>][]" id="" value="<?php echo $subvalue['idPAttributeDetail'] ?>" <?php echo ($subvalue['actionMenuPrivilege']==@$getPrivilegeUser[0]['actionPrivilege']) ? 'checked' : '' ?> > <?php echo $subvalue['namePAttributeDetail'] ?>
										</label>
										<?php 

									}
									?>
								</div>
							</div>
							<?php
						} 
						?>
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