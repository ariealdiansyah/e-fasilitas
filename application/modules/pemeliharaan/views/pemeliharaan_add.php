<div class="container" id="app">
	<?= getBread() ?>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Form Pemeliharaan</h3>
				</div>

				<form class="form-horizontal" role="form" method="post" v-on:submit.prevent="validate">
					
					<div class="panel-body">

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Teknisi</label>
									<div class="col-sm-8">
											<input type="text" name="namaTeknisi" v-model="pemeliharaan_detail.namaTeknisi" v-validate="'required'" class="form-control" id="namaTeknisi" placeholder="Nama Teknisi">
										
										<div class="text-left">
											<span v-show="errors.has('namaTeknisi') || errors.has('namaTeknisi')" class="text-danger">{{ errors.first('namaTeknisi')+" "+errors.first('namaTeknisi') }}</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="row"> 

							<div class="col-lg-6"> 
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Barang</label>
									<div class="col-sm-8">
										<select name="barang" v-model="pemeliharaan_detail.namaBarang" v-validate="'required'" class="form-control" onchange="changeKode(this)">
											<option value="">Pilih Kategori</option>
												<?php foreach ($barang as $r){?>
											<option value="<?= $r->idBarang ?>">
												<?= $r->namaBarang ?> 
											</option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-lg-6"> 
								<div class="form-group">
									<label class="col-sm-4 control-label">Kode Barang</label>
									<div class="col-sm-8">
										<!-- <input name="" class="form-control" id=""> -->
										<!-- plain B <select name="item" v-model="pemeliharaan_detail.kodeItem" class="form-control" v-validate="'required'">
											<option value="">Pilih Kode Item</option>
												<?php foreach ($item as $r){?>
											<option value="<?= $r->idItem ?>">
												<?=$r->kodeItem?>
											</option>
											<?php } ?>
										</select> -->
										<select name="idItem" id="idItem" v-model="pemeliharaan_detail.kodeItem"  class="form-control" v-validate="'required'">
											<option value="">Pilih Kode Item</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Rincian Pemeliharaan</label>
									<div class="col-sm-8">
										<textarea type= "text" class="form-control" id="rincianLapor" name="rincianLapor" placeholder="rincian Lapor" v-model="pemeliharaan_detail.rincianLapor" v-validate="'required'" style="resize: none; height: 150px;"></textarea>
											<div class="text-left">
												<span v-show="errors.has('rincianLapor')" class="text-danger">
											{{errors.first('rincianLapor')}}</span>
											</div>
									</div>
								</div>
							</div>

							<!-- <div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-6 control-label">Apakah Data Sudah Terback up ?? </label>
									<label class="col-sm-2 control-label radio-inline"><input type="radio" name="optradio">Ya</label>
									<label class="col-sm-2 control-label radio-inline"><input type="radio" name="optradio">Tidak</label>
								</div>
							</div> -->

						</div>
					</div>

					<div class="panel-footer text-right">
						<button class="btn btn-md btn-inverse btn-block waves-effect waves-light-w-md"  type="submit" @click.prevent="submit" style="    padding: 12px;font-size: 16px;">Lapor Pemeliharaan</button>
					</div>

				</form>

			</div>
		</div>
	</div>

</div>

<script type="text/javascript">
	function changeKode(elem){
		var id = elem.value;
		$.ajax({
			type: "GET",
			url: url.base+"api/getPerbaikanByBarang/"+id+"",
		}).done(function(result) {
			data = JSON.parse(result);
			$("#s2id_idItem span.select2-chosen").html('Pilih Kode');
			$("#idItem").empty();
			$("#idItem").append($("<option></option>"));		
			for (var i = 0, l = data.length; i < l; i++) {
				$("#idItem").append($("<option></option>").val(data[i].idItem).html(data[i].kodeItem));
			}
		});
	}
</script>