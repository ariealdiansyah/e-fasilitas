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
						<div class="col-md-12 text-right">
							<a href="<?php echo base_url().getModule().'/'.getController().'/add' ?>"><button type="button" class="btn btn-default btn-primary"><i class="fa fa-plus"> </i> Tambah Data</button></a>
						</div>
					</div>

					<div class="row" style="margin-top:20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Group</th>
										<th class="text-center">Keterangan</th>
										<th class="text-center">Status</th>										
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									foreach ($data as $key => $value) 
									{
										$status = '';

										switch($value['statusRole']){
											case "y":
											$status = "<img src='".base_url('assets/backend/images/icons/y.png')."' class='tip-right' title='Active'>";
											break;
											case "n":
											$status = "<img src='".base_url('assets/backend/images/icons/n.png')."' class='tip-right' title='Not Active'>";
											break;
										}
										?>
										<tr class="gradeU">
											<td style="vertical-align:middle;" class="text-center"><?php echo $no++ ?></td>
											<td style="vertical-align:middle;"><?php echo $value['namaRole'] ?></td>
											<td style="vertical-align:middle;"><?php echo $value['descRole'] ?></td>
											<td style="vertical-align:middle;" class="text-center"><?php echo $status ?></td>
											<td style="vertical-align:middle;" class="text-center">
												<a href="<?php echo base_url().getModule() ?>/<?php echo getController() ?>/add/<?php echo $value['idRole'] ?>">
													<button class="btn btn-icon waves-effect waves-light btn-inverse btn-xs m-b-5"><i class="fa fa-pencil"></i></button>
												</a>
												<button class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5 del-dialog" data-module="<?= getModule() ?>" data-controller="<?= getController() ?>" data-id="<?= $value['idRole'] ?>"><i class="fa fa-trash"></i></button>
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