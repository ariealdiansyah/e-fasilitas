<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Form Pengembalian</h3>
				</div>

				<form id="form" class="form-horizontal" role="form" method="post">
					
					<div class="panel-body">

						<div class="row"> 
							<div class="col-lg-6"> 
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Peminjam</label>
									<div class="col-sm-8">
										<select class="form-control search-select" name="peminjam" onchange="changePeminjam(this)">
											<option value="">Pilih Peminjam</option>
											<?php
											foreach($peminjam as $r){
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
									<label class="col-sm-4 control-label">Kode Peminjaman</label>
									<div class="col-sm-8">
										<select id="idPeminjaman" name="idPeminjaman" class="form-control search-select" onchange="getPeminjaman(this)">
											<option value="">Pilih Kode</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Waktu Peminjaman</label>
									<div class="col-sm-8">
										<p id="waktu" class="clear" style="border-bottom: 1px solid #ddd">
											-
										</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Tujuan Peminjaman</label>
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
											<th class="text-center" colspan="2" style="vertical-align: middle;">Kondisi</th>
										</tr>
										<tr>
											<th class="text-center" width="100">Awal</th>
											<th class="text-center">Akhir</th>
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
									<label class="col-sm-4 control-label">Tanggal Pengembalian</label>
									<div class="col-sm-8">
										<input type="text" class="form-control datepicker" name="tanggalPengembalian" value="<?= date('d-m-Y') ?>">
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Catatan Pengembalian</label>
									<div class="col-sm-8">
										<textarea class="form-control" name="catatanPengembalian" style="resize: none; height: 50px;" placeholder="Tulis catatan pengembalian jika ada"></textarea>
									</div>
								</div>
							</div>
						</div>

					</div>

					<div class="panel-footer text-right">
						<button id="btn-submit" class="btn btn-md btn-inverse btn-block waves-effect waves-light-w-md" type="button" style="    padding: 12px;font-size: 16px;">Simpan Pengembalian</button>
					</div>

				</form>

			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	
	function changePeminjam(elem){
		var id = elem.value;
		$.ajax({
			type: "GET",
			url: url.base+"api/getPeminjamanByUser/"+id+"",
		}).done(function(result) {
			data = JSON.parse(result);
			$("#s2id_idPeminjaman span.select2-chosen").html('Pilih Kode Peminjaman');
			$("#idPeminjaman").empty();
			$("#idPeminjaman").append($("<option></option>"));		
			for (var i = 0, l = data.length; i < l; i++) {
				$("#idPeminjaman").append($("<option></option>").val(data[i].idPeminjaman).html(data[i].kodePeminjaman));
			}
		});
	}

	function getPeminjaman(elem){
		var id = elem.value;
		var data = new FormData();
		$("#list").html();
		$(".clear").html('-');

		data.append('idPeminjaman', id);
		axios.post(url.base+'api/getPeminjamanById', data)
		.then(function(response){
			data =  response.data.data;
			if (data.length > 0) {
				$("#waktu").html(data[0].tanggalPinjam+" <b>s/d</b> "+data[0].batasPinjam);
				$("#tujuan").html(data[0].tujuanPinjam);				
			}

			var dataList = "";
			for (var i = 0, l = data.length; i < l; i++) {
				var checkbox = "";

				checkbox += '<div class="radio radio-primary radio-inline"><input type="radio" id="kondisi_'+i+'" name="kondisiItem['+data[i].idItem+']" value="B"><label for="kondisi_'+i+'"> Baik </label></div>';
				checkbox += '<div class="radio radio-primary radio-inline"><input type="radio" id="kondisi_'+i+'" name="kondisiItem['+data[i].idItem+']" value="RR"><label for="kondisi_'+i+'"> Rusak Ringan </label></div>';
				checkbox += '<div class="radio radio-primary radio-inline"><input type="radio" id="kondisi_'+i+'" name="kondisiItem['+data[i].idItem+']" value="RB"><label for="kondisi_'+i+'"> Rusak Berat </label></div>';
				checkbox += '<div class="radio radio-primary radio-inline"><input type="radio" id="kondisi_'+i+'" name="kondisiItem['+data[i].idItem+']" value="L"><label for="kondisi_'+i+'"> Lengkap </label></div>';
				checkbox += '<div class="radio radio-primary radio-inline"><input type="radio" id="kondisi_'+i+'" name="kondisiItem['+data[i].idItem+']" value="TL"><label for="kondisi_'+i+'"> Tidak Lengkap </label></div>';

				dataList += '<tr>'
				dataList += '<td class="text-center">'+parseInt(i+1)+'</td>'
				dataList += '<td><input type="hidden" value="'+data[i].idItem+'" name="idItem[]">'+data[i].namaBarang+'</td>'
				dataList += '<td>'+data[i].kodeItem+'</td>'
				dataList += '<td class="text-center">'+data[i].kondisiItem+'</td>'
				dataList += '<td class="text-center">'+checkbox+'</td>'
				dataList += '</tr>';
			}

			$("#list").html(dataList);

		})
		.catch(function(error){
			console.log(error)
		})
	}

	$(document).on("click", "#btn-submit", function() {

		if ($("#idPeminjaman").val() == '') {
			swal('Opps!','Anda belum memilih peminjaman','error');
			return false;
		}

		var data = $("#form").serialize();

		axios.post(url.base+'peminjaman/pengembalian/save', data)
		.then(function(result){
			if (result.data.status == 'success') {
				swal({
					title: "Berhasil",
					text: result.data.message,
					type: "success",
					showConfirmButton: true,
					showCancelButton: true,								
					confirmButtonText: "Print",								
					cancelButtonText: "No"
				},
				function(isConfirm){
					if (isConfirm) {
						window.open(url.base+'report/peminjaman/'+result.data.id,'_blank');
						window.location.href = url.base+"peminjaman/pengembalian";
					}else{
						window.location.href = url.base+"peminjaman/pengembalian";
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