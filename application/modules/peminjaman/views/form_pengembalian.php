<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Form Pengembalian</h3>
				</div>

				<form class="form-horizontal" role="form" method="post">
					
					<div class="panel-body">

						<div class="row"> 

							<div class="col-lg-6"> 

								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Peminjaman</label>
									<div class="col-sm-8">
										<select name="nameUser" class="form-control" id="">
										</select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label">Kode Peminjaman</label>
									<div class="col-sm-8">
										<select name="kodePeminjaman" class="form-control" id="">
										</select>
									</div>
								</div>

							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal Peminjaman</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-4 control-label">Tujuan Peminjaman</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="">
									</div>
								</div>
							</div>

						</div>

						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-12">
								<div class="form-group">
									<div class="col-sm-12">
										<table class="table table-striped table-bordered">
											<thead>
												<tr>
													<th class="text-center" width="70">No</th>
													<th class="text-center">Kode Item</th>
													<th class="text-center">Jumlah</th>
													<th class="text-center">Kondisi</th>
												</tr>
											</thead>
											<tbody>	
												
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>


						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal Kembali</label>
									<div class="col-sm-8">
										<input type="date" class="form-control" id="">
									</div>
								</div>
							</div>
						</div>


					</div>

					<div class="panel-footer text-right">
						<button class="btn btn-md btn-inverse btn-block waves-effect waves-light-w-md" type="submit" style="    padding: 12px;font-size: 16px;">Simpan Pengembalian</button>
					</div>

				</form>

			</div>
		</div>
	</div>

</div>