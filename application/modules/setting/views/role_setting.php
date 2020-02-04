<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-primary panel-border">
				<div class="panel-heading">
					<h3 class="panel-title">User Akses</h3>
				</div>
				<div class="panel-body">

					<ul class="nav nav-tabs custom" role="tablist">
						<?php
						foreach ($getModule as $key_module => $value_module) {
							?>
							<li role="presentation" class="">
								<a href="#tab<?= $value_module['idModule'] ?>" aria-controls="tab<?= $value_module['idModule'] ?>" role="tab" data-toggle="tab" aria-expanded="true">
									<?= $value_module['nameModule'] ?>
								</a>
							</li>
							<?php
						}
						?>
						<!-- <li role="presentation" class="active">
							<a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab" aria-expanded="true">
								Dashboard
							</a>
						</li>
						<li role="presentation">
							<a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab" aria-expanded="true">
								Catalog
							</a>
						</li>
						<li role="presentation">
							<a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab" aria-expanded="true">
								Setting
							</a>
						</li> -->
					</ul>

					<form role="form" method="post" action="<?php echo base_url() ?>/<?php echo getModule() ?>/<?php echo getController() ?>/save_privilege">
						<input type="hidden" name="idRole" class="form-control" value="<?php echo ($idRole) ? $idRole : "" ?>">

						<div class="tab-content custom">

							<?php
							foreach ($getModule as $key_module_panel => $value_module_panel) {
								?>
								<div role="tabpanel" class="tab-pane custom active" id="tab<?= $value_module_panel['idModule'] ?>">	
									
									<table class="table no-border" style="width: 80%">
										<?php 
										$getParentMenu = $this->model->get_where('master_menu',array('idModule'=>$value_module_panel['idModule'],'kodeInduk'=>0,'statusMenu'=>'y'),'orderMenu,idMenu','asc');
										foreach ($getParentMenu as $key_parent_menu => $value_parent_menu) {
											$getMenuPrivilege = $this->model->join('master_menu_privilege','*',array(array('table'=>'pengaturan_attribute_detail','parameter'=>'master_menu_privilege.actionMenuPrivilege=pengaturan_attribute_detail.idPAttributeDetail')),array('idMenu'=>$value_parent_menu['idMenu']));
											?>
											<tbody>

												<tr>
													<td class="<?= ($value_parent_menu['kodeInduk']==0) ? 'menu' : 'submenu' ?>"><?= $value_parent_menu['namaMenu'] ?></td>
													
													<?php
													foreach ($getMenuPrivilege as $key_menu_privilege => $value_menu_privilege) {
														$getPrivilegeUser = $this->model->get_where('privilege_user',array('menuPrivilege'=>$value_menu_privilege['idMenu'],'actionPrivilege'=>$value_menu_privilege['actionMenuPrivilege'],'idRole'=>$idRole));
														if (@$getPrivilegeUser[0]['idPrivilege']) {
															?>

															<input type="hidden" name="singleIDActionPrivilege[]" value="<?= @$getPrivilegeUser[0]['idPrivilege'] ?>">
															<input type="hidden" name="singleMenuActionPrivilege[]" value="<?= @$getPrivilegeUser[0]['actionPrivilege'] ?>">
															<?php
														}
														?>
														<td width="100">
															<div class="checkbox checkbox-primary no-margin">
																<input type="checkbox" class="child_<?= $value_module_panel['idModule'] ?>_<?= $value_menu_privilege['valuePAttributeDetail'] ?>" data-check="child_<?= $value_module_panel['idModule'] ?>_<?= $value_menu_privilege['valuePAttributeDetail'] ?>" name="actionPrivilege[<?php echo $value_menu_privilege['idMenu'] ?>][]" id="" value="<?php echo $value_menu_privilege['idPAttributeDetail'] ?>" <?php echo ($value_menu_privilege['actionMenuPrivilege']==@$getPrivilegeUser[0]['actionPrivilege']) ? 'checked' : '' ?>>
																<label><?php echo $value_menu_privilege['namePAttributeDetail'] ?></label>
															</div>
														</td>
														<?php
													}
													?>
												</tr>
												<?php
												$getSubMenu = $this->model->get_where('master_menu',array('idModule'=>$value_module_panel['idModule'],'kodeInduk'=>$value_parent_menu['idMenu'],'statusMenu'=>'y'),'orderMenu,idMenu','asc');
												foreach ($getSubMenu as $key_sub_menu => $value_sub_menu) {
													$getSubMenuPrivilege = $this->model->join('master_menu_privilege','*',array(array('table'=>'pengaturan_attribute_detail','parameter'=>'master_menu_privilege.actionMenuPrivilege=pengaturan_attribute_detail.idPAttributeDetail')),array('idMenu'=>$value_sub_menu['idMenu']));
													?>
													<tr>
														<td class="submenu"><?= $value_sub_menu['namaMenu'] ?></td>
														<?php
														foreach ($getSubMenuPrivilege as $key_submenu_privilege => $value_submenu_privilege) {
															$getSubPrivilegeUser = $this->model->get_where('privilege_user',array('menuPrivilege'=>$value_submenu_privilege['idMenu'],'actionPrivilege'=>$value_submenu_privilege['actionMenuPrivilege'],'idRole'=>$idRole));
															if (@$getSubPrivilegeUser[0]['idPrivilege']) {
																?>

																<input type="hidden" name="singleIDActionPrivilege[]" value="<?= @$getPrivilegeUser[0]['idPrivilege'] ?>">
																<input type="hidden" name="singleMenuActionPrivilege[]" value="<?= @$getPrivilegeUser[0]['actionPrivilege'] ?>">
																<?php
															}
															?>
															<td width="100">
																<div class="checkbox checkbox-primary no-margin">
																	<input type="checkbox" class="child_<?= $value_module_panel['idModule'] ?>_<?= $value_submenu_privilege['valuePAttributeDetail'] ?>" data-check="child_<?= $value_module_panel['idModule'] ?>_<?= $value_submenu_privilege['valuePAttributeDetail'] ?>" name="actionPrivilege[<?php echo $value_submenu_privilege['idMenu'] ?>][]" id="" value="<?php echo $value_submenu_privilege['idPAttributeDetail'] ?>" <?php echo ($value_submenu_privilege['actionMenuPrivilege']==@$getSubPrivilegeUser[0]['actionPrivilege']) ? 'checked' : '' ?>>
																	<label><?php echo $value_submenu_privilege['namePAttributeDetail'] ?></label>
																</div>
															</td>

															<?php
														}
														?>
													</tr>
													<?php
												}
												?>

											</tbody>
											<?php
										}
										?>
									</table>
								</div>
								<?php
							}
							?>

						</div>

						<br clear="all">

						<button type="submit" class="btn waves-effect waves-light btn-primary btn-md m-b-5">
							<i class="fa fa-save"></i> Simpan
						</button>

					</form>


				</div>
			</div>
		</div>
	</div>
</div>