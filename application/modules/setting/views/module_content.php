<div class="container">

	<?= getBread() ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">Module Management</h4>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 text-right">
							<a href="<?php echo base_url().getModule().'/'.getController('').'/add' ?>"><button type="button" class="btn btn-default btn-primary"><i class="fa fa-plus"> </i> Tambah Data</button></a>
						</div>
					</div>
					<div class="row" style="margin-top:20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="datatable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Nama Modul</th>
										<th class="text-center">Order</th>
										<th class="text-center">Status</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									foreach ($data as $key => $value) {
										$status = '';

										switch($value['statusModule']){
											case "Tampil":
											$status = "<img src='".base_url('assets/backend/images/icons/y.png')."' class='tip-right' title='Tampil'>";
											break;
											case "Tidak Tampil":
											$status = "<img src='".base_url('assets/backend/images/icons/n.png')."' class='tip-right' title='Tidak Tampil'>";
											break;
										}
										?>
										<tr>
											<td style="vertical-align:middle;" class="text-center"><?= $no++ ?></td>
											<td style="vertical-align:middle;"><?= $value['nameModule'] ?></td>
											<td style="vertical-align:middle;" class="text-center"><?= $value['orderModule'] ?></td>
											<td style="vertical-align:middle;" class="text-center"><?= $status ?></td>
											<td style="vertical-align:middle;" class="text-center">
												<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/add/<?php echo $value['idModule'] ?>">
													<button class="btn btn-icon waves-effect waves-light btn-inverse btn-xs m-b-5" data-attr="<?= $value['idModule'] ?>"><i class="fa fa-pencil"></i></button>
												</a>
												<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 del-dialog" data-title="Hapus Module" data-desc="Data dan folder modul akan terhapus serta tak bisa dikembalikan" data-confirm="Module berhasil dihapus" data-module="<?= getModule() ?>" data-controller="<?= getController() ?>" data-id="<?= $value['idModule'] ?>"><i class="fa fa-trash"></i></button>
											</td>
										</tr>
										<?php
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