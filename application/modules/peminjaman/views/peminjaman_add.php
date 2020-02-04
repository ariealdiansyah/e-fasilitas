<div class="container" id="app">
	<?= getBread() ?>

	<modal-item v-if="showModal"  @close="showModal = false"></modal-item>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Form Peminjaman</h3>
				</div>

				<form class="form-horizontal" role="form" method="post" v-on:submit.prevent="validate">
					
					<div class="panel-body">
						<div class="row"> 
							<div class="col-lg-12"> 

								<div class="form-group" :class="{'has-error': errors.has('tujuanPinjam') }">
									<label class="col-sm-3 control-label">Tujuan Peminjaman</label>
									<div class="col-sm-9">
										<textarea name="tujuanPinjam" v-model="peminjaman.tujuanPinjam" v-validate="'required'" class="form-control" placeholder="Tujuan Peminjaman" style="height: 150px; resize:none;"></textarea>
										<div class="text-left">
											<span v-show="errors.has('tujuanPinjam')" class="text-danger">{{ errors.first('tujuanPinjam') }}</span>
										</div>		
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">Tanggal Pinjam</label>
									<div class="col-sm-9">
										<div class="form-inline">
											<input type="text" name="tanggalPinjam" v-model="peminjaman.tanggalPinjam" v-validate="'required'" class="form-control" id="tanggal1" placeholder="Tanggal Mulai">
											&nbsp; s/d &nbsp;
											<input type="text" name="batasPinjam" v-model="peminjaman.batasPinjam" v-validate="'required'" class="form-control" id="tanggal2" placeholder="Tanggal Selesai">
										</div>
										<div class="text-left">
											<span v-show="errors.has('tanggalPinjam') || errors.has('batasPinjam')" class="text-danger">{{ errors.first('tanggalPinjam')+" "+errors.first('batasPinjam') }}</span>
										</div>
									</div>
								</div>

								<br clear="all">

								<div class="form-group">
									<div class="col-sm-9 col-sm-offset-3">
										<button class="btn btn-md btn-primary" type="button" @click.prevent="showItems">
											<span class="fa fa-plus"></span> Tambah Item
										</button>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-3"></div>
									<div class="col-sm-9">
										<table class="table table-striped table-bordered">
											<thead>
												<tr>
													<th class="text-center" width="70">No</th>
													<th class="text-center" width="150">Gambar</th>
													<th class="text-center">Nama Barang</th>
													<th class="text-center" width="200">Kode Item</th>
												</tr>
											</thead>
											<tbody>
												<tr v-if="itemList.length < 1">
													<td class="text-center" colspan="4">Tidak ada item yang dipilih</td>
												</tr>
												<tr else v-for="(item, index) in itemList">
													<td class="text-center">{{index+1}}</td>
													<td class="text-center">
														<div v-if="item.gambarItem">
															<img :src="url.base+'/assets/uploads/item/'+item.gambarItem" style="height: 50px;">
														</div>
													</td>
													<td>{{item.namaBarang}}</td>
													<td class="text-center">{{item.kodeItem}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="panel-footer text-right">
						<button class="btn btn-md btn-inverse btn-block waves-effect waves-light-w-md" type="submit" style="    padding: 12px;font-size: 16px;" :disabled="isDisabled ? true : false">Ajukan Peminjaman</button>
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
						<h4 class="modal-title">Daftar Item</h4>
					</div>

					<div class="modal-body modal-scroll">

						<div class="row">
							<div class="col-md-12">
								<div class="form-inline">
									<select class="form-control" v-model="selectedBarang">
										<option value="">Pilih Barang</option>
										<option v-for="(item, index) in barangList" v-bind:value="item.idBarang">
											{{item.namaBarang}}
										</option>
									</select>
								</div>
							</div>
						</div>

						<br clear="all">

						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">Kode Item</th>
									<th class="text-center">Tahun Beli</th>
									<th class="text-center">Gambar</th>
									<th class="text-center">Pilih</th>
								</tr>
							</thead>
							<tbody>
								<tr v-if="filteredList.length < 1">
									<td colspan="4" class="text-center">
										<b>Item Dalam Kerusakan / Peminjaaman Harap Ubah Range Tanggal</b>
									</td>
								</tr>
								<tr v-else v-for="(item, index) in filteredList">
									<td>{{item.kodeItem}}</td>
									<td class="text-center">{{item.tahunBeli}}</td>
									<td class="text-center">
										<div v-if="item.gambarItem">
											<img :src="url.base+'/assets/uploads/item/'+item.gambarItem" style="height: 50px;">
										</div>
									</td>
									<td class="text-center">
										<input type="checkbox" v-bind:value="item.idItem" v-model="selectedItems">
									</td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="clearfix"></div>
					<div class="modal-footer">
						<button class="btn btn-inverse waves-effect waves-light w-md btn-block" type="button" name="submit" @click.prevent="submit">Selesai</button>
					</div>

				</div>
			</div>
		</div>
	</transition>
</script>