Vue.use(VeeValidate);

let $selectedItem = [];
let $newItem = true;

let EventBus = new Vue({
	created: function(){
		this.$on('getItem', (event) => {
			this.getItem(event)
			$this.showModal = true;
		})
	},
	methods: {
		getItem: function(index){
			$selectedItem = $this.item[index];
			$newItem = false;
		}
	}
})

Vue.component('modal-item', {
	template: '#modal-item',
	data(){
		return{
			modalTitle: "Tambah Item",
			temp: {
				idLokasi: '',
				kodeItem: '',
				gambarItem: '',
				tahunBeli: '',
				kondisiItem: ''
			},
		}
	},
	created: function(){
		$item = this;
		if ($newItem === false) {
			this.temp = $selectedItem;
			this.modalTitle = "Edit Item";
		}
	},
	methods: {
		validate: function(){
			this.$validator.validateAll().then(() => {
				this.submit();
			}).catch(() => {
				alert('Correct them errors!');
			});
		},
		onFileChange(e) {
			var files = e.target.files || e.dataTransfer.files;
			if (!files.length)
				return;
			this.createImage(files[0]);
		},
		createImage(file) {
			var image = new Image();
			var reader = new FileReader();
			var vm = this;
			reader.onload = (e) => {
				vm.temp.gambarItem = e.target.result;
			};
			reader.readAsDataURL(file);
		},
		submit: function(){
			if ($newItem) {
				this.temp.tglPemeliharaan = '';
				this.temp.bulanPemeliharaan = '';
				this.temp.jangkaPemeliharaan = '';
				$this.item.push(this.temp);								
			}else{
				$selectedItem = this.temp;
			}
			$this.showModal = false;
			this.temp = [];
			$selectedItem = [];
			$newItem = true;
		}
	}
})

new Vue({
	el: '#app',
	data:{
		showModal: false,
		barang: {
			kategori: '',
			nama: '',
			spesifikasi: ''
		},
		item: []
	},
	created: function(){
		$this = this;
		if (idBarang) {
			this.fetchBarang();
		}
	},
	methods: {
		fetchBarang: function(){
			axios.get(url.base+"/barang/load/"+idBarang)
			.then(function(response){
				var data = response.data.data;
				$this.barang.id = data.detail.idBarang;
				$this.barang.kategori = data.detail.idKategori;
				$this.barang.nama = data.detail.namaBarang;
				$this.barang.spesifikasi = data.detail.spesifikasiBarang;
				$this.item = [];
				for(var name in data.item) {
					var value = data.item[name];
					if (value.gambarItem != '') {
						value.gambarItem = url.base+"assets/uploads/item/"+value.gambarItem;
					}
					$this.item.push(value);
				}
			})
			.catch(function(error){
				console.log(error)
			})
		},
			validate: function(){
			this.$validator.validateAll().then(() => {
				this.save();
			}).catch(() => {
				alert('Correct them errors!');
			});
		},
		save: function(){
			if (this.item.length == 0) {
				swal('Oops','Anda belum menambahkan Item','error');
			}else{
				var data = new FormData();
				data.append('barang', JSON.stringify(this.barang));
				data.append('item', JSON.stringify(this.item));
				axios.post(url.base+"/barang/barang/save", data)
				.then(function(response){
					if (response.data.status == 'success') {
						swal({
							title: "Berhasil",
							text: response.data.message,
							type: "success",
							showConfirmButton: true
						},
						function(isConfirm){
							if (isConfirm) {
								if (idBarang == '') {
									window.location.href = url.base+"/barang";
								}
							}
						});
					}else{
						swal('Oops',response.data.message,'error');						
					}
				})
				.catch(function(error){
					console.log(error)
				})
			}
		},
		editItem: function(index){			
			EventBus.$emit('getItem', index);
		},
		deleteItem: function(index){
			var array = this.item;
			if (array[index].idItem != undefined) {
				swal({
					title: "Apakah anda yakin?",
					text: "Item ini akan dihapus dari barang anda",
					type: "warning",
					showCancelButton: true,
					cancelButtonText: "Batal",
					confirmButtonText: "Ya",
					closeOnConfirm: false
				},
				function(){
					axios.post(url.base+'/barang/delete/item/'+array[index].idItem)
					.then(function (result) {
						if (result.data.status == 'success') {
							swal({
								title: "Berhasil",
								text: result.data.message,
								timer: 2000,
								type: "success",
								showConfirmButton: false
							});
						}else{
							swal("Oops...", result.data.message, "error");						
						}
						$this.fetchBarang();
					})
					.catch(function (error) {
						console.log(error);
					});
				});
			}else{
				if ( index === -1 ) {
					return array.shift();
				} else {
					return array.splice( index, 1 );
				}				
			}
			// array.splice(array[index], 1);
		}
	}
})