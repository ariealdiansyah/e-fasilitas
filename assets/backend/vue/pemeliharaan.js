Vue.use(VeeValidate);

new Vue({
	el: '#app',
	data: {
			pemeliharaan_detail: {
				namaBarang: '',
				kodeItem: '',
				rincianLapor: '',
				namaTeknisi: ''
			},
			item: []
	},
	created: function(){
		$this = this;
		/*if (idBarang){
			this.fetchBarang();
		}*/
	},
	methods: {
		/*masih belum tau datanya fetchBarang: function(){
			axios.get(url.base+"/perbaikan/load/"+idBarang)
			.then(function(response){
				var data = response.data.data;
				$this.perbaikan_detail.id = data.detail.idBarang;
				$this.perbaikan_detail.namaBarang = data.detail.namaBarang;
				$this.perbaikan_detail.kodeItem = data.detail.idItem;
				$this.perbaikan_detail.rincianKerusakan = data.detail.rincianKerusakan;
				$this.item = [];
				for(var name in data.item) {
					var value = data.item[name];
					$this.item.push(value);
				}
			})
			.catch(function(error){
				console.log(error)
			})
		},*/
		
		validate: function(){
				this.$validator.validateAll().then(() => {
					this.save();
				}).catch(() => {
					alert('Correct them errors!');
				});
		},
		submit: function(){
			if (this.pemeliharaan_detail.namaBarang.length == 0 || this.pemeliharaan_detail.kodeItem.length == 0) {
				swal('Oops','Anda belum Melapor','error');
			}else{
				var data = new FormData();
				data.append('pemeliharaan_detail', JSON.stringify(this.pemeliharaan_detail));
				/*masih belum tau datanya data.append('item', JSON.stringify(this.item));*/
				axios.post(url.base+"/pemeliharaan/save", data)
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
							window.location.href = url.base+"pemeliharaan";
						}
					});
				}else{
					swal('Terjadi Kesalahan',response.data.message,'error');						
				}
				})
				.catch(function(error){
					console.log(error)
				})
			}
		}
	}
})
/*belum tau kelanjutannya,
	created: function(){
		$item = this;
		this.fetchBarang();
		this.fetchKode();
		for(var items in $this.itemList){
			var val = $this.itemList[items];
			this.selectedItems.push(val.idItem)					
		}
	},
	methods: {
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
		fetchKode: function(){
			axios.get(url.base+'api/getKode')
			.then(function(result){
				result = result.data.data;
				$item.kodeList = result;
			})
			.catch(function(error){
				console.log(error)
			})
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
			data.append('perbaikan', JSON.stringify(this.perbaikan));
			axios.post(url.base+'perbaikan/save', data)
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
							window.location.href = url.base+"perbaikan";
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
		fetchItem: function(){
			var data = new FormData;
			axios.post(url.base+'api/getKode', data)
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
	}*/