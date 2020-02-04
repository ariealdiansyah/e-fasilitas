<?php
$save_info = $this->session->userdata('save_info');
$this->session->userdata('wrong') ? $display = "display:block;" : $display = "display:none;";

$fotoUser = getMember('fotoUser');
$dir_fotoUser = "assets/backend/images/users/";

if (!empty($fotoUser) AND is_file($dir_fotoUser.$fotoUser)) {
	$fotoUser = $dir_fotoUser.$fotoUser;
}else{
	$fotoUser = "assets/backend/images/users/avatar.png";
}

?>

<div class="wraper container-fluid">

	<div class="row">
		<div class="col-sm-12">

			<div class="bg-picture text-center" style="background-image:url('<?= base_url('assets/backend/images/big/bg.jpg') ?>')">

				<div class="bg-picture-overlay"></div>
				<div class="profile-info-name">

					<div class="demo-box demo-box3" style="display:inline-block">
						<div id="demo3" class="ho-box demo3">
							<img src="<?= base_url($fotoUser) ?>" class="demo3-img" title="" style="width:100%;height:100%;">
						</div>
					</div>

					<h3 class="text-white">
						<?= getMember('nameUser') ?>
						<br>
						<small class="text-white">
							<?= getField('master_user_role','namaRole',array('idRole'=>$this->session->userdata('roleUser'))) ?>
						</small>
					</h3>

				</div>

			</div>

		</div>
	</div>

	<div class="row user-tabs">
		<div class="col-lg-12">

			<ul class="nav nav-tabs tabs">
				<li class="active tab">
					<a href="#setting" data-toggle="tab" aria-expanded="false" class="active">
						<span class="visible-xs"><i class="fa fa-cog"></i></span> 
						<span class="hidden-xs">Settings</span>
					</a>
				</li>
				<div class="indicator"></div>
			</ul>

		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			
			<div class="tab-content profile-tab-content">

				<div class="tab-pane active" id="setting">

					<div class="panel panel-default panel-fill">

						<div class="panel-heading">
							<h3 class="panel-title">Edit Profile</h3>
						</div>

						<div class="panel-body">
							
							<?php if($save_info){ ?>
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<?= $save_info ?>
							</div>
							<?php } ?>

							<form class="form" method="POST" action="<?= base_url(getModule().'/'.getController().'/save') ?>">

								<input type="hidden" name="temp_email" class="form-control" value="<?php echo (getMember('emailUser')) ? getMember('emailUser') : @$temp_email ?>">

								<div class="form-group">
									<label>Username</label>
									<?= input_text('usernameUser',getMember('usernameUser'),'','required',array('disabled' => 'disabled')) ?>
								</div>

								<div class="form-group">
									<label>Nama Lengkap</label>
									<?= input_text('nameUser',getMember('nameUser'),'','required') ?>
								</div>

								<div class="form-group">
									<label>Email</label>
									<?= input_email('emailUser',getMember('emailUser'),'','required') ?>
								</div>

								<div class="form-group">
									<button class="btn btn-danger waves-effect waves-light btn-xs" type="button" id="changePass">Change Password</button>
								</div>

								<?php if($this->session->userdata('changePass')){ ?>
								<div class="form-group">
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										Password anda berhasil diubah..
									</div>
								</div>
								<?php } ?>

								<div class="hide_show" style="<?= $display ?>">

									<div class="form-group">
										<label>Old Password</label>
										<input type="password" name="old_pass" class="form-control">
										<?php echo form_error('old_pass') ?>
									</div>

									<div class="form-group">
										<label>New Password</label>
										<input type="password" name="new_pass" class="form-control">
										<?= form_error('new_pass') ?>
									</div>

									<div class="form-group">
										<label for="RePassword">Re-type Password</label>
										<input type="password" name="new_pass_conf" data-validation-error-msg="Konfirmasi Kata Sandi tidak sama" data-validation="confirmation" class="form-control" data-validation-confirm="new_pass" placeholder="Ulangi Password">
										<?= form_error('new_pass_conf') ?>	
									</div>

								</div>

								<button class="btn btn-primary waves-effect waves-light w-md" type="submit">Simpan</button>

							</form>

						</div>

					</div>

				</div>

			</div>

		</div>
	</div>

</div>

<div id="changePhoto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" action="<?= base_url(getModule().'/'.getController().'/save_foto') ?>" enctype="multipart/form-data">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Change Photo</h4>
				</div>

				<div class="modal-body">
					<input type="hidden" name="fotoUser" value="<?= getMember('fotoUser') ?>">
					<?= input_file_image('fotoUser','','required') ?>                                        
					<i><small class="text-danger">* Upload Max Size 1MB</small></i>
				</div>  

				<div class="modal-footer">                              
					<button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> 
				</div>

			</form>
		</div>
	</div>
</div>

<?= load_js('backend/js/jquery.hoverOver.min.js') ?>

<script type="text/javascript">
	$("#changePass").click(function(){
		$(".hide_show").toggle();
	});
	$('#demo3').hoverOver({
		contentData: '<p class="hover-content-block"><a href="#" data-toggle="modal" data-target="#changePhoto" style="color:#fff;"><i class="fa fa-camera fa-2x"></i></a></p>',
		aniTypeIn: 'fade',
		aniTypeOut: 'fade',
		aniDurationIn: 400,
		aniDurationOut: 300
	});
</script>