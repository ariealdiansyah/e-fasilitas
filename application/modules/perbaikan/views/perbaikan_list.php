<div class="container">
	<?= getBread() ?>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">

				<div class="panel-heading">
					<h4 class="panel-title">
						Data Perbaikan
					</h4>
				</div>

				<div class="panel-body">
					
					<div class="row" style="margin-top: 20px;">

						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="datatables" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" width="50">No</th>
										<th class="text-center" width="100">Kode Perbaikan</th>
										<th class="text-center" width="100">Pelapor</th>
										<th class="text-center" width="100">Nama Barang</th>
										<th class="text-center" width="100">Kode Item</th>
										<th class="text-center" width="100">Tanggal Lapor</th>
										<th class="text-center" width="100">Rincian Laporan</th>
										<th class="text-center" width="75">Status</th>
										<th class="text-center" width="50">Action</th>
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

	$(document).on('ready',function(){

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
			{"mData": "kodePerbaikan", "bSortable": false, "sClass": "center"},
			{"mData": "nameUser", "bSortable": false, "sClass": "center"},
			{"mData": "namaBarang", "bSortable": false, "sClass": "center"},
			{"mData": "kodeItem", "bSortable": false, "sClass": "center"},
			{"mData": "tanggalLapor", "bSortable": false, "sClass": "center"},
			{"mData": "rincianLaporan", "bSortable": false, "sClass": "center"},
			{"mData": "statusPerbaikan", "bSortable": false, "sClass": "center"},
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

		$("div.col-sm-6:nth-child(1)", $("#datatables_wrapper .row:nth-child(1)")).removeClass('col-sm-6').addClass('col-sm-2');
		var $baseContainer = $("div.col-sm-6:nth-child(2)", $("#datatables_wrapper .row:nth-child(1)"));
		var baseContent = $baseContainer.html();

		$baseContainer.removeClass('col-sm-6').addClass('col-sm-10');
		$baseContainer.empty();
		$baseContainer.append("<div class=\"row\">" + baseContent + "</div>");

		var $filterContainer = $("div#datatables_filter", $("div.row", $("div.col-sm-10", $("#datatables_wrapper .row:nth-child(1)"))));
		var filterContent = $filterContainer.html();
		$filterContainer.empty();

		$filterContainer.append("<div class=\"col-sm-2 text-left\" style=\"z-index: 1000\">" + filterContent + "</div>");

		tmpl = "";
		tmpl += "<div class=\"col-sm-10\">";
		tmpl += "	<label>";
		tmpl += "		Filter: <?php echo select_join("statusPerbaikan", "statusPerbaikan, statusPerbaikan", "perbaikan", "statusPerbaikan", "statusPerbaikan") ?>";
		tmpl += "	</label>";
		tmpl += "</div>";

		$filterContainer.append(tmpl);		

		$(".search-select").select2({
			placeholder : 'Pilih Data...',
			minimumResultsForSearch: 10,
			allowClear: true,
		});

		$(".select2-container.form-control").css({
			'display': 'inline-block',
			'width': '200px'
		});

		$("input[type='search']").keyup(function(){
			table.fnFilter(this.value);
		})

		$("#statusPerbaikan").on('change', function(){
			table.fnReloadAjax("<?= base_url(getModule().'/'.getController().'/'.getFunction().'/load?status=') ?>" + $("#statusPerbaikan").val() + "");
		});
 
	});


</script>
