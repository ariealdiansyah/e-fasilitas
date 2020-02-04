<div class="container">

	<?= getBread() ?>


	<?php

	$panel = "

	<div class=\"row\">
		<div class=\"col-md-6 text-left\">
			<a href=\"?mode=list\">
				<button class=\"btn btn-md btn-default waves-effect waves-light tip-right\" title=\"List Mode\" style=\"font-size:20px;padding-top:5px;padding-bottom:0px;\"><i class=\"md-view-list\"></i>
				</button>
			</a>
		</div>

		<div class=\"col-md-6 text-right\">
			<button class=\"btn btn-md btn-primary waves-effect waves-light\" data-toggle=\"modal\" data-target=\"#master-modal\"><i class=\"fa fa-plus\"></i> New Master</button>
		</div>
	</div>


	<div class=\"row text-center\" style=\"padding-top:20px;\">";

		foreach ($category as $row) {

			switch($row['statusCategory']){
				case "y":
				$link = base_url(getModule().'/'.getController().'/'.getFunction().'/'.$row['kodeCategory']);
				break;
				case "n":
				$link = "#";
				break;
			}

			$panel.="

			<div class=\"col-md-6 col-sm-6 col-lg-3\">
				<div class=\"panel panel-border panel-inverse widget-s-1\">
					<div class=\"panel-heading\"></div>
					<div class=\"panel-body\">
						<div class=\"h2 text-purple\"><a href=$link class=\"text-inverse\">".count_all('master_data',array('statusData'=>'y','kodeCategory'=>$row['kodeCategory']))."</a></div>
						<span class=\"text-muted\"><a href=$link class=\"text-inverse\">".$row['namaCategory']."</a></span>
						<div class=\"text-right\">
							<i class=\"fa ".getField('master_category','iconCategory',array('idCategory'=>$row['idCategory']))." fa-2x text-purple\"></i>
						</div>
					</div>
				</div>
			</div>";

		}

		$panel.="

	</div>

	";

	?>


	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">Master Data</h4>
				</div>
				<div class="panel-body">			

					<?php

					if (!empty($_GET['mode'])) {
						switch ($_GET['mode']) {

							case "list":
							?>

							<div class="row">
								<div class="col-md-6 text-left">
									<a href="?mode=panel">
										<button class="btn btn-md btn-default waves-effect waves-light tip-right" title="Panel Mode" style="font-size:20px;padding-top:5px;padding-bottom:0px;"><i class="md-view-module"></i>
										</button>
									</a>
								</div>

								<div class="col-md-6 text-right">
									<button class="btn btn-md btn-primary waves-effect waves-light" data-toggle="modal" data-target="#master-modal"><i class="fa fa-plus"></i> New Master</button>
								</div>
							</div>

							<div class="row" style="margin-top:20px;">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<table id="datatable" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Kategori</th>
												<th class="text-center">Order</th>
												<th class="text-center">Status</th>
												<th class="text-center">Kontrol</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 1;
											foreach ($category as $row) {

												$status = '';
												$link = '';

												switch($row['statusCategory']){
													case "y":
													$target =  base_url(getModule().'/'.getController().'/'.getFunction().'/'.$row['kodeCategory']);
													$link = "<a href='".$target."' class='text-primary'>$row[namaCategory]</a>";
													$status = "<img src='".base_url('assets/backend/images/icons/y.png')."' class='tip-right' title='Active'>";
													break;
													case "n":
													$link = "$row[namaCategory]";
													$status = "<img src='".base_url('assets/backend/images/icons/n.png')."' class='tip-right' title='Not Active'>";
													break;
												}

												?>
												<tr>
													<td style="vertical-align:middle;" class="text-center"><?= $no++ ?></td>
													<td style="vertical-align:middle;"><?= $row['kodeCategory'] ?></td>
													<td style="vertical-align:middle;"><?= $link ?></td>
													<td style="vertical-align:middle;" class="text-center"><?= $row['orderCategory'] ?></td>
													<td style="vertical-align:middle;" class="text-center"><?= $status ?></td>
													<td style="vertical-align:middle;" class="text-center">

														<!-- data-remote="<?= base_url().getModule()."/".getController()."/form/".$row['kodeCategory'] ?>" -->
														<button class="btn btn-icon waves-effect wanves-light btn-primary btn-xs m-b-5" data-toggle="modal" data-target="#modal-data_<?= $row['idCategory'] ?>"><i class="fa fa-pencil"></i></button>
														<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 del-dialog" data-title="Hapus Master" data-desc="Apakah anda ingin menghapus master data ini ?" data-confirm="Master Data berhasil dihapus" data-route="<?= base_url(getModule().'/'.getController().'/delete/category/'.encode($row['idCategory'])) ?>"><i class="fa fa-trash"></i></button>
													</td>
												</tr>

												<?php
											}
											?>
										</tbody>
									</table>
								</div>
							</div>

							<?php

							break;

							case "panel":

							echo $panel;

							break;

							default:
							echo $panel;
							break;						

						}
					}else{
						echo $panel;
					}

					?>			



				</div>
			</div>
		</div>
	</div>


	<div id="master-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
		<div class="modal-dialog">
			<div class="modal-content">
				<form method="POST" action="<?= base_url().getModule()."/".getController()."/save/category" ?>">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">New Master</h4>
					</div>

					<div class="modal-body">		

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Kode</label>
									<?= input_text('kodeCategory','','','required',array('maxlength' => '4')) ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Nama</label>
									<?= input_text('namaCategory','','','required') ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Parent</label>
									<?php echo select_join('namaCategory','kodeCategory,namaCategory','master_category','kodeCategory','kodeInduk',array('statusCategory'=>'y'),'','','Pilih Parent') ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Icon</label>
									<input type="text" name="iconCategory" class="form-control icp icp-auto iconPicker">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">Deskripsi</label>
									<textarea name="ketCategory" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Order</label>
									<?= input_text('orderCategory',$orderCategory,'','required',array('onkeyup' => 'number(this)')) ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-2" class="control-label">Status</label>
									<br>
									<div class="radio radio-inline radio-primary">
										<input value="y" name="statusCategory" type="radio" checked>
										<label>Active</label>
									</div>
									<div class="radio radio-inline radio-danger">
										<input value="n" name="statusCategory" type="radio">
										<label>Not Active</label>
									</div>
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

	<?php
	if(isset($category)){
		foreach ($category as $row) {
			$y = $row['statusCategory'] == 'y' ? "checked" : "";
			$n = $row['statusCategory'] == 'n' ? "checked" : "";
			?>

			<div id="modal-data_<?= $row['idCategory']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
				<div class="modal-dialog">
					<div class="modal-content">

						<form method="POST" action="<?= base_url().getModule()."/".getController()."/save/category/".$row['idCategory'] ?>">

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title">Edit Master</h4>
							</div>

							<div class="modal-body">

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Kode</label>
											<?= input_text('kodeCategory',@$row['kodeCategory'],'','required',array('maxlength' => '4','disabled'=>'disabled')) ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Nama</label>
											<?= input_text('namaCategory',@$row['namaCategory'],'','required') ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Parent</label>
											<?php echo select_join('namaCategory','kodeCategory,namaCategory','master_category','kodeCategory','kodeInduk',array('statusCategory'=>'y','kodeCategory !=' => $row['kodeCategory']),($row['kodeInduk']) ? $row['kodeInduk'] : "",'','Pilih Parent') ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">									
											<label class="control-label">Icon</label>
											<!-- <input type="hidden" name="iconCategory" class="iconPicker" value="<?= getField('master_category','iconCategory',array('idCategory'=>$row['idCategory'])) ?>"> -->
											<input type="text" name="iconCategory" class="form-control icp icp-auto" value="<?= getField('master_category','iconCategory',array('idCategory'=>$row['idCategory'])) ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="control-label">Deskripsi</label>
											<textarea name="ketCategory" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px"><?= $row['ketCategory'] ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">Order</label>
											<?= input_text('orderCategory',@$row['orderCategory'],'','required',array('onkeyup' => 'number(this)')) ?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="field-2" class="control-label">Status</label>
											<br>
											<div class="radio radio-inline radio-primary">
												<input value="y" name="statusCategory" type="radio" <?= $y ?>>
												<label>Active</label>
											</div>
											<div class="radio radio-inline radio-danger">
												<input value="n" name="statusCategory" type="radio" <?= $n ?>>
												<label>Not Active</label>
											</div>
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

			<div id="delete-data_<?= $row['idCategory']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
				<div class="modal-dialog">
					<div class="modal-content">

						<form method="POST" action="<?= base_url().getModule()."/".getController()."/delete/category/".$row['idCategory'] ?>">

							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title">Hapus Master</h4>
							</div>

							<div class="modal-body">
								<div class="alert alert-danger">							
									Apakah anda ingin menghapus <b><?= $row['namaCategory'] ?></b> ?
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

			<?php
		}
	}
	?>
</div>