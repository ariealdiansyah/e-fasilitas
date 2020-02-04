<div class="container">
	<?= getBread() ?>	

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Tambah Atribut Detail</h3>
				</div>
				<div class="panel-body">
					<div class="row"> 
						<div class="col-lg-12"> 
							<form class="form-horizontal" role="form" method="post" action="<?php echo base_url() ?>index.php/<?php echo getModule() ?>/<?php echo getController() ?>/save_detail">
								<input type="hidden" name="idPAttributeDetail" class="form-control" value="<?php echo (@$getAttributesDetail[0]['idPAttributeDetail']) ? $getAttributesDetail[0]['idPAttributeDetail'] : "" ?>">
								<input type="hidden" name="idPAttribute" class="form-control" value="<?php echo (@$getAttributesDetail[0]['idPAttribute']) ? $getAttributesDetail[0]['idPAttribute'] : $idPAttribute ?>">
								<?php echo input_text_group('namePAttributeDetail','Nama',(@$getAttributesDetail[0]['namePAttributeDetail']) ? @$getAttributesDetail[0]['namePAttributeDetail'] : set_value('namePAttributeDetail'),'Nama Atribut','required') ?>
								<?php echo input_text_group('valuePAttributeDetail','Value',(@$getAttributesDetail[0]['valuePAttributeDetail']) ? @$getAttributesDetail[0]['valuePAttributeDetail'] : set_value('valuePAttributeDetail'),'Value Atribut','','','Value merupakan deskripsi dari nama') ?>
							</div>
							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
									&nbsp;
									<button type="reset" class="btn btn-danger"><i class="fa fa-times"></i> Batal</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>