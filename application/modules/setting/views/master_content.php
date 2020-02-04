
<?php

$title = getField('master_category','namaCategory',array('kodeCategory' => end($this->uri->segments)));
$parent = getField('master_category','namaCategory',array('kodeCategory' => $kodeInduk));

?>

<div class="container">

	<div class="row">
		<div class="col-sm-12">
			<h4 class="pull-left page-title"><?= ucfirst(getModule()) ?></h4>
			<ol class="breadcrumb pull-right">
				<li><?= ucfirst(getModule()) ?></li>
				<li><a href="<?= base_url(getModule()."/".getController()."/".getFunction()) ?>"><?= ucfirst(getController()) ?></a></li>
				<li class="active"><?= $title ?></li>
			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">Master Data <?= $title ?></h4>
				</div>
				<div class="panel-body">

					<div class="row">
						<div class="col-md-6 text-left">					
							<a href="<?= base_url(getModule()."/".getController()."/".getFunction()) ?>" class="btn btn-md btn-default waves-effect waves-light"><i class="fa fa-chevron-left"></i> Back</a>
						</div>
						<div class="col-md-6 text-right">					
							<button class="btn btn-md btn-primary waves-effect waves-light" data-toggle="modal" data-target="#new-data"><i class="fa fa-plus"></i> Tambah Data</button>
						</div>
					</div>

					<div class="row" style="margin-top:20px;">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<table id="myTable" class="table table-striped table-bordered datatable">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Nama Data</th>
										<th class="text-center">Keterangan</th>
										<th class="text-center">Order</th>
										<th class="text-center">Status</th>
										<th class="text-center">Kontrol</th>
									</tr>
								</thead>


							</table>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</div>

<div id="new-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="<?= base_url().getModule()."/".getController()."/add/data/".end($this->uri->segments) ?>">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><?= $title ?></h4>
				</div>

				<div class="modal-body">

					<?php if (!empty($kodeInduk)) { ?>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label"><?= $parent ?></label>
								<?php echo select_join('namaData','idData,namaData','master_data','idData','kodeInduk',array('statusData'=>'y','kodeCategory' => $kodeInduk),'','','Pilih '.$parent) ?>
							</div>
						</div>
					</div>

					<?php } ?>


					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Nama</label>
								<?= input_text('namaData','','','required') ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Kode</label>
								<?= input_text('kodeData') ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Deskripsi</label>
								<textarea name="keteranganData" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: none; height: 104px"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="control-label">Order</label>
								<?= input_text('orderData',$orderData,'','required',array('onkeyup' => 'number(this)')) ?>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="field-2" class="control-label">Status</label>
								<br>
								<div class="radio radio-inline radio-primary">
									<input value="y" name="statusData" type="radio" checked>
									<label>Active</label>
								</div>
								<div class="radio radio-inline radio-danger">
									<input value="n" name="statusData" type="radio">
									<label>Not Active</label>
								</div>
							</div>
						</div>
					</div>

				</div>	

				<div class="modal-footer">				
					<button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
				</div>

			</form>
		</div>
	</div>
</div>

<script type="text/javascript">

	var table;

	$(document).on('click', '.edit-data', function() {

		var id = $(this).data("id");

		$.ajax({
			type: "POST",
			"url": "<?= base_url(getModule()."/".getController()."/loadModal/masterEdit/".end($this->uri->segments)); ?>",
			data: {
				idData : id
			},
			success: function(response){

				$('#loadContent').html(response);
				$("#modalSize").addClass('modal-md');							
				$("#myModal").modal('show');

			},
			dataType: "html"
		});

	});


	$(document).ready(function() {

		table = $('#myTable').DataTable({ 

			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": "<?= base_url(getModule()."/".getController()."/loadData/".end($this->uri->segments)); ?>",
				"type": "POST"
			},

			"columnDefs": [
			{ 
				"targets": [ 0 ],
				"orderable": false,
			},
			],

			"aoColumns": [ 
			{"sClass": "center"},
			{"sClass": "left"},
			{"sClass": "left"},
			{"sClass": "center"},
			{"sClass": "center"},
			{"sClass": "center"},
			],

		});

	});


</script>