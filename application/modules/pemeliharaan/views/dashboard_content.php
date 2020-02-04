
<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						Pemeliharaan
					</h4>
				</div>

				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 text-right">
							<a href="<?php echo base_url().getModule().'/'.getController('').'/add' ?>" button type="button" class="btn btn-default btn-primary"><i class="fa fa-plus"> </i> Tambah Data</button>
							</a>
						</div>
					</div>

					<div class="row" style="margin-top: 20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="datatable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" width="50"> No </th>
										<th class="text-center" width="150"> Nama Barang</th>
										<th class="text-center" width="150"> Kode Barang </th>
										<th class="text-center"> Tanggal Pemeliharaan </th>
										<th class="text-center"> Teknisi	 </th>
										<th class="text-center" width="100"> Status </th>
									</tr>
								</thead>

								<tbody>
									<?php $no = 1;
									foreach ($data as $key => $value) {
										?>

										<tr>
											<td style="vertical-align: middle;" class="text-center"><?= $no++?></td>

											<td style="vertical-align: middle;"><?= $value['kodeItem']?></td>
											<td style="vertical-align: middle;"><?= $value['tanggalPemeliharaan']?></td>
											<td style="vertical-align: middle;"><?= $value['teknisi']?></td>
											<td style="vertical-align: middle;" class="text-center">
												<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/add/<?php echo $value['idPeminjaman'] ?>">
													<button class="btn btn-icon waves-effect waves-light btn-inverse btn-xs m-b-5"><i class="fa fa-thumbs-o-up"></i></button>
												</a>
												<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 del-dialog" data-module="<?= getModule() ?>" data-controller="<?= getController() ?>" data-id="<?= $value['idPeminjaman'] ?>"><i class="fa fa-thumbs-o-down"></i></button>
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