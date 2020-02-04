<div class="container">
	<?= getBread() ?>
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-border panel-primary">
				<div class="panel-heading">
					<h4 class="panel-title">User List</h4>
				</div>
				<div class="panel-body">
					<div class="row"> 
						<div class="col-lg-12"> 
							<form class="form-horizontal" role="form" method="post" action="<?= base_url(getModule().'/'.getController().'/save') ?>">
								<input type="hidden" name="idUser" class="form-control" value="<?php echo ($getMember) ? encode($getMember[0]['idUser']) : @$idUser ?>">
								<input type="hidden" name="temp_email" class="form-control" value="<?php echo ($getMember) ? $getMember[0]['emailUser'] : @$temp_email ?>">
								<?php echo input_text_group('usernameUser','Username',(@$getMember[0]['usernameUser']) ? @$getMember[0]['usernameUser'] : set_value('usernameUser'),'','required',array('onkeyup' => 'setUsername(this)')) ?>
								<?php echo input_text_group('nameUser','Nama',(@$getMember[0]['nameUser']) ? @$getMember[0]['nameUser'] : set_value('nameUser'),'','required') ?>
								<?php echo input_email_group('emailUser','Email',(@$getMember[0]['emailUser']) ? @$getMember[0]['emailUser'] : "",'','required') ?>

								<?php if(@$getMember[0]['idUser'] || @$idUser){ ?>

								<div class="form-group">
									<label class="col-lg-2 col-sm-2 control-label">Password</label>
									<div class="col-sm-6">
										<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#change-password">Change Password</button>
									</div>
								</div>

								<?php }else{ ?>

								<div class="form-group">
									<label class="col-lg-2 col-sm-2 control-label">Password</label>
									<div class="col-sm-6">
										<input type="password" name="pass_confirmation" data-validation="length" data-validation-error-msg="Field ini wajib diisi dengan nilai minimal 8 karakter" data-validation-length="min8" class="form-control" placeholder="Password Minimal 8 Karakter">
										<?= form_error('pass_confirmation') ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-lg-2 col-sm-2 control-label">Re-type Password</label>
									<div class="col-sm-6">
										<input type="password" name="Password" data-validation-error-msg="Konfirmasi Kata Sandi tidak sama" data-validation="confirmation" class="form-control" data-validation-confirm="pass_confirmation" placeholder="Ulangi Password">
										<?= form_error('Password') ?>										
									</div>
								</div>

								<?php } ?>

								<?php echo select_join_group('namaRole','idRole,namaRole','master_user_role','idRole','roleUser','Group',array('statusRole' => 'y'),($getMember) ? $getMember[0]['roleUser'] : set_value('roleUser'),'required','Pilih User Group','','onchange="changeRole(this)"') ?>


								<?php echo input_radio_group('statusUser','Status',array('y'=>'Aktif','n'=>'Tidak Aktif'),(@$getMember[0]['statusUser']) ? @$getMember[0]['statusUser'] : "y",'required') ?>


								<div class="form-group">
									<div class="col-lg-offset-2 col-lg-10">
										<button type="submit" class="btn btn-inverse"><i class="fa fa-save"></i> Simpan</button>
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

<div id="change-password" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">

			<form method="POST" action="<?= base_url(getModule().'/'.getController().'/save_password/'.encode(@$getMember[0]['idUser'])) ?>">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Change Password</h4>
				</div>

				<div class="modal-body">

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Password</label>
								<input type="password" name="pass_confirmation" data-validation="length" data-validation-error-msg="Field ini wajib diisi dengan nilai minimal 8 karakter" data-validation-length="min8" class="form-control" placeholder="Password Minimal 8 Karakter">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label">Re-type Password</label>
								<input type="password" name="Password" data-validation-error-msg="Konfirmasi Kata Sandi tidak sama" data-validation="confirmation" class="form-control" data-validation-confirm="pass_confirmation" placeholder="Ulangi Password">
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

	$(document).ready(function(){

		<?php if($this->session->userdata('success_password')){ ?>
			swal({
				title: "Good job!",
				text : "Password berhasil diubah",
				type: "success",
				confirmButtonColor: "#265F76"
			},
			function(){
			});
			<?php } ?>

		});

</script>