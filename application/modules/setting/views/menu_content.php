<div class="container">

	<?= getBread() ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">Menu Management</h4>
				</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-6 text-left">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-default waves-effect waves-light">Pilih module</button>
								<button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="<?php echo base_url()?><?php echo getModule() ?>/<?php echo getController() ?>"><i class="fa fa-list"></i> Semua</a></li>
									<?php
									foreach ($getModule as $key => $value) {
										?>
										<li><a href="<?php echo current_url() ?>?module=<?php echo $value['nameModule'] ?>&key=<?php echo $value['idModule'] ?>"><i class="fa <?php echo $value['iconModule'] ?>"></i> <?php echo $value['nameModule'] ?></a></li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>
						<div class="col-md-6 text-right">
							<a href="<?php echo ($this->input->get('module')) ? base_url().getModule().'/'.getController('').'/add?module='.$this->input->get('module').'&key='.$this->input->get('key').'' : 'javascript:void(0)' ?>"><button type="button" class="btn btn-default btn-primary" onclick="checkModule()"><i class="fa fa-plus"> </i> Tambah Data</button></a>
						</div>

					</div>

					<div class="row" style="margin-top:20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="datatable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Nama Menu</th>
										<th class="text-center">Order</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									foreach ($data as $row => $value) {

										$status = '';

										switch($value['statusMenu']){
											case "y":
											$status = "<img src='".base_url('assets/backend/images/icons/y.png')."' class='tip-right' title='Active'>";
											break;
											case "n":
											$status = "<img src='".base_url('assets/backend/images/icons/n.png')."' class='tip-right' title='Not Active'>";
											break;
										}

										?>
										<tr>
											<td style="vertical-align:middle;" class="text-center"><?= $no++ ?></td>
											<td style="vertical-align:middle;"><?= $value['namaMenu'] ?></td>
											<td style="vertical-align:middle;" class="text-center"><?= $value['orderMenu'] ?></td>
											<td style="vertical-align:middle;" class="text-center"><?= $status ?></td>
											<td style="vertical-align:middle;" class="text-center">
												<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/add/<?php echo $value['idMenu'] ?>">
													<button class="btn btn-icon waves-effect waves-light btn-inverse btn-xs m-b-5"><i class="fa fa-pencil"></i></button>
												</a>
												<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 del-dialog" data-title="Hapus Menu" data-desc="Apakah anda ingin menghapus menu ini ?" data-confirm="Menu berhasil dihapus" data-module="<?= getModule() ?>" data-controller="<?= getController() ?>" data-id="<?= $value['idMenu'] ?>">
													<i class="fa fa-trash"></i>
												</button>
											</td>
										</tr>
										<?php 
										$subMenu = $this->model->get_where('master_menu',array('kodeInduk'=>$value['idMenu']));
										foreach ($subMenu as $subkey => $subvalue) {
											$status = '';

											switch($subvalue['statusMenu']){
												case "y":
												$status = "<img src='".base_url('assets/backend/images/icons/y.png')."' class='tip-right' title='Active'>";
												break;
												case "n":
												$status = "<img src='".base_url('assets/backend/images/icons/n.png')."' class='tip-right' title='Not Active'>";
												break;
											}
											?>
											<tr>
												<td style="vertical-align:middle;" class="text-center"><?= $no++ ?></td>
												<td style="vertical-align:middle;padding-left:30px;"><?= $subvalue['namaMenu'] ?></td>
												<td style="vertical-align:middle;" class="text-danger text-center"><?= $subvalue['orderMenu'] ?></td>
												<td style="vertical-align:middle;" class="text-center"><?= $status ?></td>
												<td style="vertical-align:middle;" class="text-center">
													<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/add/<?php echo $subvalue['idMenu'] ?>">
														<button class="btn btn-icon waves-effect waves-light btn-inverse btn-xs m-b-5"><i class="fa fa-pencil"></i></button>
													</a>
													<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 del-dialog" data-title="Hapus Sub Menu" data-desc="Apakah anda ingin menghapus Sub Menu ini ?" data-confirm="Sub Menu berhasil dihapus" data-module="<?= getModule() ?>" data-controller="<?= getController() ?>" data-id="<?= $subvalue['idMenu'] ?>">
														<i class="fa fa-trash"></i>
													</button>
												</td>
											</tr>
											<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="new-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="<?= base_url().getModule()."/".getController()."/save"?>">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><?= 'New Menu' ?></h4>
				</div>

				<div class="modal-body">
					<div class="row"> 
						<div class="col-lg-12"> 
							<ul class="nav nav-tabs navtab-bg"> 
								<li class=""> 
									<a href="#home" data-toggle="tab" aria-expanded="false"> 
										<span class="visible-xs"><i class="fa fa-home"></i></span> 
										<span class="hidden-xs">Home</span> 
									</a> 
								</li> 
								<li class="active"> 
									<a href="#profile" data-toggle="tab" aria-expanded="true"> 
										<span class="visible-xs"><i class="fa fa-user"></i></span> 
										<span class="hidden-xs">Profile</span> 
									</a> 
								</li> 
								<li class=""> 
									<a href="#messages" data-toggle="tab" aria-expanded="false"> 
										<span class="visible-xs"><i class="fa fa-envelope-o"></i></span> 
										<span class="hidden-xs">Messages</span> 
									</a> 
								</li> 
							</ul> 
							<div class="tab-content"> 
								<div class="tab-pane" id="home"> 
									<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p> 
									<p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p> 
								</div> 
								<div class="tab-pane active" id="profile"> 
									<p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p> 
									<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p> 
								</div> 
								<div class="tab-pane" id="messages"> 
									<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.</p> 
									<p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p> 
								</div> 
							</div> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Menu Induk</label>
								<select class='form-control search-select' name="kodeInduk" id="kodeInduk">
									<option></option>
									<?php
									foreach ($getParentMenu as $key => $value) {
										?>
										<option value="<?php echo $value['idMenu'] ?>" <?php echo (@$getMenu[0]['kodeInduk']==$value['idMenu'] ? 'selected' : '' ) ?>><?php echo $value['namaMenu'] ?></option>
										<?php
										$subMenu = $this->model->get_where('master_menu',array('kodeInduk'=>$value['idMenu']),'orderMenu','asc');
										foreach ($subMenu as $subkey => $subvalue) {
											?>
											<option value="<?php echo $subvalue['idMenu'] ?>" <?php echo (@$getMenu[0]['kodeInduk']==$subvalue['idMenu'] ? 'selected' : '' ) ?>><?php echo "-".$subvalue['namaMenu'] ?></option>
											<?php 
											$subMenu = $this->model->get_where('master_menu',array('kodeInduk'=>$subvalue['idMenu']),'orderMenu','asc');
											foreach ($subMenu as $subkey => $subvalue) {
												?>
												<option value="<?php echo $subvalue['idMenu'] ?>" <?php echo (@$getMenu[0]['kodeInduk']==$subvalue['idMenu'] ? 'selected' : '' ) ?>><?php echo "--".$subvalue['namaMenu'] ?></option>
												<?php
											}
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group no-margin">
								<label class="control-label">Nama Menu</label>
								<input type="text" name="namaMenu" class="form-control" placeholder="Nama Menu" value="<?php echo ($getMenu) ? $getMenu[0]['namaMenu'] : "" ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group no-margin">
								<label class="control-label">Icon Menu</label>
								<input type="text" class="form-control icp icp-auto" id="iconModule" name="iconMenu" placeholder="Klik disini..." value="<?php echo ($getMenu) ? $getMenu[0]['iconMenu'] : "" ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Order</label>
								<input type="text" id="orderData" name="orderData" class="form-control" onkeyup="number(this)" value="" required placeholder="0">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-2" class="control-label">Status</label>
								<br>
								<div class="radio radio-inline radio-primary">
									<input value="y" name="statusData" type="radio" checked>
									<label>Active</label>
								</div>
								<div class="radio radio-inline radio-danger">
									<input value="n" name="statusData" type="radio">
									<label>Not Active</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group no-margin">
								<label class="control-label">Target Menu</label>
								<input type="text" class="form-control" id="targetMenu" name="targetMenu" placeholder="module/controller/function" value="<?php echo ($getMenu) ? $getMenu[0]['targetMenu'] : "" ?>">
							</div>
						</div>
					</div>

				</div>	

				<div class="modal-footer">				
					<button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
				</div>

			</form>
		</div>
	</div>
</div>