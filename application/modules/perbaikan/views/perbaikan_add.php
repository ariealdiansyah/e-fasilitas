<div class="container" id="app">
	<?= getBread() ?>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Form Perbaikan</h3>
				</div>

				<form class="form-horizontal" role="form" method="post" v-on:submit.prevent="validate">
					
					<div class="panel-body">

						<div class="row"> 

							<div class="col-lg-6"> 
								<div class="form-group">
									<label class="col-sm-4 control-label">Nama Barang</label>
									<div class="col-sm-8">
										<!-- masih belum tau lanjutannya <select class="form-control">
											<option value="">Pilih Barang</option>
											<option v-for="(item, index) in barangList" v-bind:value="item.idBarang">
												{{item.namaBarang}}
											</option>
										</select> -->
										<select name="barang" v-model="perbaikan_detail.namaBarang"  class="form-control" v-validate="'required'" onchange="changeKode(this)">
											<option value="">Pilih Kategori</option>
												<?php foreach($barang as $r){ ?>
											<option value="<?= $r->idBarang ?>"><?= $r->namaBarang ?></option>
												<?php } ?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-lg-6"> 
								<div class="form-group">
									<!-- <label class="col-sm-4 control-label">Kode Barang</label>
									<div class="col-sm-8" v-if="filteredList.length < 1">
										<b></b>
									</div>
									<div class="col-sm-8" v-else v-for="(item, index) in filteredList">
										<label>{{item.kodeItem}}</label>
									</div> -->
									<label class="col-sm-4 control-label">Kode Barang</label>
									<div class="col-sm-8">
										<!-- belum tau kelanjutannya <select class="form-control">
											<option value="">Pilih Kode Item</option>
											<option v-for="(item, index) in kodeList" v-bind:value="item.idItem">
												{{item.kodeItem}}
											</option>
										</select> -->
										<!-- plan B <select name="item" v-model="perbaikan_detail.kodeItem"  class="form-control" v-validate="'required'">
											<option value="">Pilih Kode Item</option>
												<?php foreach($item as $r){ ?>
											<option value="<?= $r->idItem ?>"><?= $r->kodeItem ?></option>
												<?php } ?>
										</select> -->
										<select name="idItem" id="idItem" v-model="perbaikan_detail.kodeItem"  class="form-control" v-validate="'required'">
											<option value="">Pilih Kode Item</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-lg-6">
								<div class="form-group" >
									<label class="col-sm-4 control-label">Rincian Kerusakan</label>
									<div class="col-sm-8">
										<!-- belum tau kelanjutannya <textarea name="rincianKerusakan" v-model="perbaikan.rincianKerusakan"  class="form-control" style="resize: none; height: 150px;"></textarea> -->
										<textarea type="text" class="form-control" id="rincianKerusakan" name="rincianKerusakan" placeholder="rincianKerusakan" v-model="perbaikan_detail.rincianKerusakan" v-validate="'required'"> </textarea>
											<div class="text-left">
												<span v-show="errors.has('rincianKerusakan')" class="text-danger">{{ errors.first('rincianKerusakan') }}</span>
											</div>
									</div>
								</div>
							</div>

							<!-- belum pasti dipakai <div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-4 control-label">Apakah Data Sudah Terback up ?? </label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="progress" name="progress" placeholder="progress" v-model="perbaikan_detail.progress" v-validate="'required'">
											<div class="text-left">
												<span v-show="errors.has('progress')" class="text-danger">{{ errors.first('progress') }}</span>
											</div>
										 belum tau kelanjutannya <input name="progress" v-model="perbaikan.progress" class="form-control" id="">
									</div>
									<label class="col-sm-2 control-label radio-inline"><input type="radio" name="optradio">Ya</label>
									<label class="col-sm-2 control-label radio-inline"><input type="radio" name="optradio">Tidak</label>
								</div>
							</div> -->

						</div>
					</div>

					<div class="panel-footer text-right">
						<button class="btn btn-md btn-inverse btn-block waves-effect waves-light-w-md" type="submit" name="submit" @click.prevent="submit" style="padding: 12px;font-size: 16px;">Lapor Kerusakan</button>
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