Vue.use(VeeValidate);

Vue.component('modal-item', {
	template: '#modal-item',
	data(){
		return{
			selectedBarang: '',
			barangList: [],
			lokasiList: [],
			itemList: [],
			selectedItems: []
		}
	},
	created: function(){
		$item = this;
		this.fetchBarang();
		this.fetchItem();
		for(var items in $this.itemList){
			var val = $this.itemList[items];
			this.selectedItems.push(val.idItem)					
		}
		console.log(this.selectedItems);
	},
	methods: {
		submit: function(){
			if (this.selectedItems.length < 1) {
				alert('Tidak ada item yang dipilih')
			}else{
				var obj = this.selectedItems;				
				$this.itemList = [];
				for(var name in obj){
					var value = obj[name];
					for(var items in this.itemList){
						var val = this.itemList[items];
						if (val.idItem == value) {
							var newItem = {
								idItem: val.idItem,
								gambarItem: val.gambarItem,						
								namaBarang: val.namaBarang,
								kodeItem : val.kodeItem
							}
							$this.itemList.push(newItem);
						}						
					}
				}
				$this.showModal = false;
			}
		},
		fetchBarang: function(){
			axios.get(url.base+'api/getBarang')
			.then(function(result){
				result = result.data.data;
				$item.barangList = result;
			})
			.catch(function(error){
				console.log(error)
			})
		},
		fetchItem: function(){
			var data = new FormData;
			data.append('tgl1', $this.peminjaman.tanggalPinjam);
			data.append('tgl2', $this.peminjaman.batasPinjam);
			axios.post(url.base+'api/getItem', data)
			.then(function(result){
				result = result.data.data;
				$item.itemList = result;
				console.log(result)
			})
			.catch(function(error){
				console.log(error)
			})	
		}
	},
	computed: {
		filteredList() {
			return this.itemList.filter(item => {
				return item.idBarang == this.selectedBarang;
			})
		}
	}
})

new Vue({
	el: '#app',
	data: {
		peminjaman: {
			tujuanPinjam: '',
			tanggalPinjam: '',
			batasPinjam: ''
		},
		itemList: [],
		showModal: false,
		isDisabled: false
	},
	created: function(){
		$this = this;
	},
	mounted(){
		$("#tanggal1").datepicker({
			format: 'dd-mm-yyyy'
		}).on(
		"changeDate", () => {this.peminjaman.tanggalPinjam = $('#tanggal1').val()}
		);
		$("#tanggal2").datepicker({
			format: 'dd-mm-yyyy'
		}).on(
		"changeDate", () => {this.peminjaman.batasPinjam = $('#tanggal2').val()}
		);
	},
	methods: {
		showItems: function(){
			if (this.peminjaman.tanggalPinjam && this.peminjaman.batasPinjam) {
				this.showModal = true;
			}else{
				swal('Oops!','Pilih tanggal peminjaman terlebih dahulu','error');
			}
		},
		validate: function(){
			this.$validator.validateAll().then(() => {
				this.submit();
			}).catch(() => {
				alert('Correct them errors!');
			});
		},
		submit: function(){
			if (this.itemList.length < 1) {
				swal('Oops','Anda belum menambahkan Item','error');
				return false;
			}
			this.isDisabled = true;
			var data = new FormData();
			data.append('peminjaman', JSON.stringify(this.peminjaman));
			data.append('item', JSON.stringify(this.itemList));
			axios.post(url.base+'peminjaman/save', data)
			.then(function(response){
				// console.log(response)
				if (response.data.status == 'success') {
					swal({
						title: "Berhasil",
						text: response.data.message,
						type: "success",
						showConfirmButton: true
					},
					function(isConfirm){
						if (isConfirm) {
							window.location.href = url.base+"peminjaman";
						}
					});
				}else{
					swal('Oops',response.data.message,'error');						
				}
				$this.isDisabled = false;
			})
			.catch(function(error){
				console.log(error)
			})
		}
	}
})