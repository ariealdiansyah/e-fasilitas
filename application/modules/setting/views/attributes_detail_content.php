<div class="container">

	<?= getBread() ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Detail Atribut</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12 text-right">
							<a href="<?php echo base_url().getModule().'/'.getController('').'/add/'.$idPAttribute ?>?u=0"><button type="button" class="btn btn-default btn-primary"><i class="fa fa-plus"> </i> Tambah Data</button></a>
						</div>
					</div>
					<div class="row" style="margin-top:20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Nama Atribut</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									foreach ($data as $key => $value) {
										?>
										<tr>
											<td style="vertical-align:middle;" class="text-center"><?= $no++ ?></td>
											<td style="vertical-align:middle;" class="text-center"><?= $value['namePAttributeDetail'] ?></td>
											<td style="vertical-align:middle;" class="text-center">
												<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/add/<?php echo $value['idPAttributeDetail'] ?>">
													<button class="btn btn-icon waves-effect waves-light btn-primary btn-xs m-b-5" data-attr="<?= $value['idPAttributeDetail'] ?>"><i class="fa fa-pencil"></i></button>
												</a>
												<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 sa-params" data-id="<?= $value['idPAttributeDetail'] ?>"><i class="fa fa-trash"></i></button>
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