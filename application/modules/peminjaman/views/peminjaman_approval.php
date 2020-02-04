<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">
						Approval Peminjaman
					</h4>
				</div>

				<div class="panel-body">

					<div class="row" style="margin-top: 20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="datatables" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" width="50"> No </th>
										<th class="text-center" width="150"> Kode Peminjaman </th>
										<th class="text-center"> Peminjam </th>
										<th class="text-center"> Tanggal Pinjam </th>
										<th class="text-center"> Tujuan	 </th>
										<th class="text-center" width="100"> Action </th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	var table;

	$(document).on('ready', function(){

		table = $('#datatables').dataTable({
			"sScrollY": "100%",
			"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"bSort": false,
			"bFilter": true,
			"iDisplayStart": 0,
			"serverside": true,			
			// "sPaginationType": "full_numbers",
			"sAjaxSource": "<?= base_url(getModule().'/'.getController().'/'.getFunction().'/load') ?>",
			"aoColumns": [
			{"mData": null, "sWidth": "20px", "bSortable": false, "sClass": "center"},			
			{"mData": "kodePeminjaman", "bSortable": false},
			{"mData": "nameUser", "bSortable": false},
			{"mData": "tanggalPinjam", "bSortable": false, "sClass": "center"},
			{"mData": "tujuanPinjam", "bSortable": false},
			{"mData": "detail", "bSortable": false, "sClass": "center"}
			],
			"aaSorting": [[1, "asc"]],
			"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				$("td:first", nRow).html((iDisplayIndexFull + 1) + ".");
				return nRow;
			},
			"bProcessing": true,
			"oLanguage": {
			}
		});
		$("input[type='search']").keyup(function(){
			table.fnFilter(this.value);
		})
	});

	function action(par, id)
	{
		if (par == 'setujui') {
			var text = "Peminjaman ini akan disetujui";
		}else{
			var text = "Peminjaman ini akan ditolak";
		}

		swal({
			title: "Apakah anda yakin?",
			text: text,
			type: "input",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Ya",
			closeOnConfirm: false,
			inputPlaceholder: "Tulis Catatan.."
		},
		function(catatan){
			if (catatan === false) return false;
			if (catatan === "") {
				swal.showInputError("Anda harus mengisi catatan!");
				return false;
			}
			var data = new FormData();
			data.append('id', id);
			data.append('catatan', catatan);
			axios.post(url.base+'peminjaman/approval/action/'+par,data)
			.then(function (result) {
				if (result.data.status == 'success') {
					if (par == 'setujui') {
						swal({
							title: "Berhasil",
							text: result.data.message,
							type: "success",
							showConfirmButton: true,
							showCancelButton: true,								
							confirmButtonText: "Print",								
							cancelButtonText: "Close",
							closeOnCancel: true
						},
						function(isConfirm){
							if (isConfirm) {
								window.open(url.base+'report/peminjaman/'+result.data.id,'_blank');
							}
						});
					}else{
						swal('Berhasil', result.data.message, 'success');
					}
				}else{
					console.log(result.data);
				}
				table.fnReloadAjax();
			})
			.catch(function (error) {
				console.log(error);
			});
		});
	}

</script>