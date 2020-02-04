<div class="container" id="app">
	<?= getBread() ?>

	<modal-item v-if="showModal"  @close="showModal = false"></modal-item>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">

				<form class="form-horizontal" v-on:submit.prevent="validate">

					<div class="panel-body">

						<div class="row" style="margin: -15px -20px 0 -20px">
							<ul class="nav nav-tabs tabs">
								<li class="active tab">
									<a href="#detail" data-toggle="tab" aria-expanded="false" class="active">
										<span class="visible-xs"><i class="fa fa-info-circle"></i></span> 
										<span class="hidden-xs">Detail</span>
									</a>
								</li>
								<li class="tab">
									<a href="#item" data-toggle="tab" aria-expanded="false">
										<span class="visible-xs"><i class="fa fa-paragraph"></i></span> 
										<span class="hidden-xs">Item Barang</span>
									</a>
								</li>
								<li class="tab">
									<a href="#jadwal" data-toggle="tab" aria-expanded="false" class="#">
										<span class="visible-xs"><i class="fa fa-location-arrow"></i></span> 
										<span class="hidden-xs">Penjadwalan</span>
									</a>
								</li>
								<div class="indicator"></div>
							</ul>
						</div>

						<div class="col-lg-12">
							<div class="tab-content profile-tab-content" style="margin-bottom: 35px;">

								<div class="tab-pane active" id="detail">
									<div class="form-group" :class="{'has-error': errors.has('kategori') }">
										<label for="kategori" class="col-sm-3 control-label">Kategori Barang</label>
										<div class="col-sm-9">
											<select name="kategori" v-model="barang.kategori" class="form-control" v-validate="'required'">
												<option value="">Pilih Kategori</option>
												<?php foreach($kategori as $r){ ?>
												<option value="<?= $r->idKategori ?>"><?= $r->namaKategori ?></option>
												<?php } ?>
											</select>	
											<div class="text-left">
												<span v-show="errors.has('kategori')" class="text-danger">{{ errors.first('kategori') }}</span>
											</div>		
										</div>
									</div>
									<div class="form-group" :class="{'has-error': errors.has('namaBarang') }">
										<label for="namaBarang" class="col-sm-3 control-label">Nama Barang</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="namaBarang" name="namaBarang" placeholder="Nama Barang" v-model="barang.nama" v-validate="'required'">
											<div class="text-left">
												<span v-show="errors.has('namaBarang')" class="text-danger">{{ errors.first('namaBarang') }}</span>
											</div>
										</div>
									</div>
									<div class="form-group" :class="{'has-error': errors.has('spesifikasi') }">
										<label for="spesifikasi" class="col-sm-3 control-label">Spesifikasi Barang</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="spesifikasi" name="spesifikasi" v-model="barang.spesifikasi" v-validate="'required'" placeholder="Spesifikasi Barang" style="height: 150px; resize: none;"></textarea>
											<div class="text-left">
												<span v-show="errors.has('spesifikasi')" class="text-danger">{{ errors.first('spesifikasi') }}</span>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="item">
									<div class="pull-right">
										<a href="#item" class="btn btn-sm btn-default waves-effect waves-light" @click.prevent="showModal = true"><i class="fa fa-plus"></i> Tambah</a>
									</div>
									<div class="clearfix"></div>
									<table class="table table-hover m-t-10">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th class="text-center">Gambar</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Tahun Beli</th>
												<th class="text-center">Kondisi</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<tr v-if="item.length < 1">
												<td class="text-center" colspan="6">Tidak ada item</td>
											</tr>
											<tr v-else v-for="(item, index) in item">
												<td class="text-center">{{index+1}}</td>
												<td class="text-center">
													<img :src="item.gambarItem" style="width: 50px;">
												</td>
												<td class="text-center">{{item.kodeItem}}</td>
												<td class="text-center">{{item.tahunBeli}}</td>
												<td class="text-center">{{item.kondisiItem}}</td>
												<td class="text-center">
													<button type="button" @click.prevent="editItem(index)" class="btn btn-icon waves-effect waves-light btn-inverse btn-xs m-b-5">
														<i class="fa fa-pencil"></i>
													</button>
													<button type="button" @click.prevent="deleteItem(index)" class="btn btn-icon waves-effect waves-light btn-danger btn-xs m-b-5">
														<i class="fa fa-trash"></i>
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="tab-pane" id="jadwal">
									<table class="table table-hover m-t-10">
										<thead>
											<tr>
												<th class="text-center" width="50">#</th>
												<th class="text-center" width="200">Item</th>
												<th class="text-center" width="100">Tanggal</th>
												<th class="text-center" width="100">Bulan</th>
												<th class="text-center" width="100">Jangka Waktu (bulan)</th>
											</tr>
										</thead>
										<tbody>
											<tr v-if="item.length < 1">
												<td class="text-center" colspan="5">Tidak ada item yang perlu dijadwal</td>
											</tr>
											<tr v-else v-for="(item, index) in item">
												<td class="text-center" style="vertical-align: middle;">{{index+1}}</td>
												<td class="text-center" style="vertical-align: middle;">{{item.kodeItem}}</td>
												<td>
													<select v-model="item.tglPemeliharaan" class="form-control">
														<option value="">Pilih tanggal</option>
														<?php
														for ($i=1; $i <= 31; $i++) { 
															echo "<option value='".$i."'>".$i."</option>";
														}
														?>
													</select>
												</td>
												<td>
													<select v-model="item.bulanPemeliharaan" class="form-control">
														<option value="">Pilih bulan</option>
														<?php
														for ($i=1; $i <= 12; $i++) { 
															echo "<option value='".$i."'>".$i."</option>";
														}
														?>
													</select>
												</td>
												<td>
													<select v-model="item.jangkaPemeliharaan" class="form-control">
														<option value="">Pilih bulan</option>
														<?php
														for ($i=1; $i <= 12; $i++) { 
															echo "<option value='".$i."'>".$i."</option>";
														}
														?>
													</select>
												</td>												
											</tr>
										</tbody>
									</table>
								</div>

							</div>
						</div>

					</div>

					<div class="panel-footer">
						<div class="col-sm-12">
							<div class="pull-right">
								<button class="btn btn-inverse waves-effect waves-light w-md" type="submit" name="submit" value="submit">Simpan</button>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>

				</form>

			</div>
		</div>
	</div>

</div>

<script type="text/x-template" id="modal-item">
	<transition name="modal">
		<div class="modal-mask">
			<div class="modal-wrapper">
				<div class="modal-container">

					<div class="modal-header">
						<button type="button" @click="$emit('close')" class="close" id="close-modal"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title">{{modalTitle}}</h4>
					</div>

					<form class="form-horizontal" v-on:submit.prevent="validate" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="col-md-12">
								<div class="form-group" :class="{'has-error': errors.has('kodeItem') }">
									<label for="kodeItem" class="col-sm-3 control-label">Kode Item</label>
									<div class="col-sm-9">
										<input type="text" name="kodeItem" v-model="temp.kodeItem" class="form-control" id="kodeItem" maxlength="15 " placeholder="Kode Item" v-validate="'required'">
										<div class="text-left">
											<span v-show="errors.has('kodeItem')" class="text-danger">{{ errors.first('kodeItem') }}</span>
										</div>
									</div>
								</div>
								<div class="form-group" :class="{'has-error': errors.has('lokasiItem') }">
									<label for="lokasiItem" class="col-sm-3 control-label">Lokasi</label>
									<div class="col-sm-9">
										<select name="lokasiItem" v-model="temp.lokasiItem" class="form-control" v-validate="'required'">
											<option value="">Pilih Lokasi</option>
											<?php foreach($lokasi as $r){ ?>
											<option value="<?= $r->idLokasi ?>"><?= $r->kodeLokasi ?></option>
											<?php } ?>
										</select>
										<div class="text-left">
											<span v-show="errors.has('lokasiItem')" class="text-danger">{{ errors.first('lokasiItem') }}</span>
										</div>
									</div>
								</div>
								<div class="form-group" :class="{'has-error': errors.has('tahunBeli') }">
									<label for="tahunBeli" class="col-sm-3 control-label">Tahun Beli</label>
									<div class="col-sm-9">
										<input type="text" v-model="temp.tahunBeli" class="form-control" id="tahunBeli" name="tahunBeli" placeholder="Tahun Beli" v-validate="'required|min:4'" maxlength="4" onkeyup="number(this)">
										<div class="text-left">
											<span v-show="errors.has('tahunBeli')" class="text-danger">{{ errors.first('tahunBeli') }}</span>
										</div>
									</div>
								</div>
								<div class="form-group" :class="{'has-error': errors.has('kondisiItem') }">
									<label for="kondisiItem" class="col-sm-3 control-label">Kondisi</label>
									<div class="col-sm-9">
										<div class="radio radio-primary radio-inline">
											<input type="radio" v-model="temp.kondisiItem" id="kondisi_b" name="kondisiItem" value="B" v-validate="'required|in:B,RR,RB,L,TL'">
											<label for="kondisi_b"> B </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" v-model="temp.kondisiItem" id="kondisi_rr" name="kondisiItem" value="RR">
											<label for="kondisi_rr"> RR </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" v-model="temp.kondisiItem" id="kondisi_rb" name="kondisiItem" value="RB">
											<label for="kondisi_rb"> RB </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" v-model="temp.kondisiItem" id="kondisi_l" name="kondisiItem" value="L">
											<label for="kondisi_l"> L </label>
										</div>
										<div class="radio radio-primary radio-inline">
											<input type="radio" v-model="temp.kondisiItem" id="kondisi_tl" name="kondisiItem" value="TL">
											<label for="kondisi_tl"> TL </label>
										</div>
										<div class="text-left">
											<span v-show="errors.has('kondisiItem')" class="text-danger">{{ errors.first('kondisiItem') }}</span>
										</div>
									</div>
								</div>
								<div class="form-group" :class="{'has-error': errors.has('gambarItem') }">
									<label for="gambarItem" class="col-sm-3 control-label">Gambar Item</label>
									<div class="col-sm-9">
										<div v-if="!temp.gambarItem">
											<input type="file" @change="onFileChange" class="form-control" id="gambarItem" name="gambarItem" v-validate="'mimes:image/jpeg,image/png'" accept="image/*">
											<div class="text-left">
												<span v-show="errors.has('gambarItem')" class="text-danger">{{ errors.first('gambarItem') }}</span>
											</div>
										</div>
										<div v-else>
											<img :src="temp.gambarItem" style="width: 50px; float: left; margin-right: 10px;">
											<button class="btn btn-xs btn-danger waves-effect waves-light" @click.prevent="temp.gambarItem = ''" style="float: left;">
												<span class="fa fa-close"></span> Hapus
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<button class="btn btn-inverse waves-effect waves-light w-md" type="submit" name="submit" value="submit">Simpan</button>
						</div>
					</form>					
				</div>				
			</div>
		</div>
	</transition>
</script>