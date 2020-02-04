<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Form Update Pemeliharaan</h3>
				</div>

				<form id="form" class="form-horizontal" role="form" method="post">
					
					<div class="panel-body">

						<div class="row"> 
							<div class="col-lg-6"> 
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Pelapor</label>
									<div class="col-sm-8">
										<select class="form-control search-select" name="pemeliharaan" onchange="changePemeliharaan(this)">
											<option value="">Pilih Pelapor</option>
											<?php
											foreach($pemeliharaan as $r){
												?>
												<option value="<?= $r->id ?>"><?= $r->name ?></option>
												<?php
											}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Kode Pemeliharaan</label>
									<div class="col-sm-8">
										<select id="idPemeliharaan" name="idPemeliharaan" class="form-control search-select" onchange="getPemeliharaan(this)">
											<option value="">Pilih Kode</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Waktu Lapor</label>
									<div class="col-sm-8">
										<p id="waktu" class="clear" style="border-bottom: 1px solid #ddd">
											-
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Rincian Lapor</label>
									<div class="col-sm-8">
										<p id="tujuan" class="clear" style="border-bottom: 1px solid #ddd">
											-
										</p>
									</div>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-12">

								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th width="70" class="text-center" rowspan="2" style="vertical-align: middle;">No</th>
											<th class="text-center" rowspan="2" style="vertical-align: middle;" width="300">Nama Barang</th>
											<th width="200" class="text-center" rowspan="2" style="vertical-align: middle;">Kode Item</th>
										</tr>
									</thead>
									<tbody id="list">
										<tr>
											<td colspan="5" class="text-center">
												Tidak ada barang yang dapat ditampilkan
											</td>
										</tr>
									</tbody>
								</table>

							</div>
						</div>

						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Teknisi</label>
									<div class="col-sm-8">
										<p id="namaTeknisi" class="clear" style="border-bottom: 1px solid #ddd">
											-
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Tanggal Tindakan</label>
									<div class="col-sm-8">
										<input type="text" class="form-control datepicker" name="tanggalUpdate" value="<?= date('d-m-Y') ?>">
									</div>
								</div>
							</div>
						</div>

						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-6"> 
								<div class="form-group">
									<label class="col-sm-4 control-label">Status Pemeliharaan</label>
									<div class="col-sm-8">
										<select class="form-control search-select" id="statusPemeliharaan" name="statusPemeliharaan">
											<option value="">Pilih Status</option>
											<option value="proses">Proses</option>
											<option value="selesai">Selesai</option>
										</select>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="panel-footer text-right">
						<button id="btn-submit" class="btn btn-md btn-inverse btn-block waves-effect waves-light-w-md" type="button" style="    padding: 12px;font-size: 16px;">Update Pemeliharaan</button>
					</div>

				</form>

			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	
	function changePemeliharaan(elem){
		var id = elem.value;
		$.ajax({
			type: "GET",
			url: url.base+"api/getPemeliharaanByUser/"+id+"",
		}).done(function(result) {
			data = JSON.parse(result);
			$("#s2id_idPemeliharaan span.select2-chosen").html('Pilih Kode Pemeliharaan');
			$("#idPemeliharaan").empty();
			$("#idPemeliharaan").append($("<option></option>"));		
			for (var i = 0, l = data.length; i < l; i++) {
				$("#idPemeliharaan").append($("<option></option>").val(data[i].idPemeliharaan).html(data[i].kodePemeliharaan));
			}
		});
	}

	function getPemeliharaan(elem){
		var id = elem.value;
		var data = new FormData();
		$("#list").html();
		$(".clear").html('-');

		data.append('idPemeliharaan', id);
		axios.post(url.base+'api/getPemeliharaanById', data)
		.then(function(response){
			data =  response.data.data;
			if (data.length > 0) {
				$("#waktu").html(data[0].tanggalLapor);
				$("#tujuan").html(data[0].rincianLapor);	
				$("#namaTeknisi").html(data[0].namaTeknisi);			
			}

			var dataList = "";
			for (var i = 0, l = data.length; i < l; i++) {

				dataList += '<tr>'
				dataList += '<td class="text-center">'+parseInt(i+1)+'</td>'
				dataList += '<td><input type="hidden" value="'+data[i].idItem+'" name="idItem[]">'+data[i].namaBarang+'</td>'
				dataList += '<td>'+data[i].kodeItem+'</td>'
				dataList += '</tr>';
			}

			$("#list").html(dataList);

		})
		.catch(function(error){
			console.log(error)
		})
	}

	$(document).on("click", "#btn-submit", function() {

		if ($("#idPemeliharaan").val() == '' || $("#statusPemeliharaan").val() == '') {
			swal('Opps!','Isi Semua Form Dahulu','error');
			return false;
		}

		var data = $("#form").serialize();

		axios.post(url.base+'pemeliharaan/pemeliharaan/saveupdate', data)
		.then(function(result){
			if (result.data.status == 'success') {
				swal({
					title: "Berhasil",
					text: result.data.message,
					type: "success",
					showConfirmButton: true
				},
				function(isConfirm){
					if (isConfirm) {
						/*window.open(url.base+'report/peminjaman/'+result.data.id,'_blank');*/
						window.location.href = url.base+"pemeliharaan";
					}else{
						window.location.href = url.base+"pemeliharaan/pemeliharaan/update";
					}
				});
			}else{
				swal('Oops!', result.data.message, 'error');					
			}
		})
		.catch(function(error){
			console.log(error)
		})

	});

</script>