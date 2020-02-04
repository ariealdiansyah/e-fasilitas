<?php
$fotoUser = getMember('fotoUser');
$dir_fotoUser = "assets/backend/images/users/small/";

if (!empty($fotoUser) AND is_file($dir_fotoUser.$fotoUser)) {
	$fotoUser = $dir_fotoUser.$fotoUser;
}else{
	$fotoUser = "assets/backend/images/users/avatar.png";
}
?>
<div class="topbar">

	<div class="topbar-left">
		<div class="text-center">
			<a href="<?= base_url() ?>" class="logo">
			<!--<span><img src="<?= base_url('assets/img/logo/favicon.png') ?>"></span>-->
				<span style="font-size: 16px;">E-Fasilitas | LAPAN</span>
			</a>
		</div>
	</div>

	<div class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="">
				<div class="pull-left">
					<button class="button-menu-mobile open-left"><i class="fa fa-bars"></i></button>
					<span class="clearfix"></span>
				</div>

				<ul class="nav navbar-nav navbar-right pull-right">

					<?php if($this->session->userdata('roleUser') != '6'){ ?>

					<?php
					$pending = $this->db->get_where('peminjaman',array('statusPeminjaman' => 1));
					?>

					<li class="dropdown hidden-xs">
						<a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false">
							<i class="md md-notifications"></i> 
							<div class="notifCount">
								<?php if($pending->num_rows() > 0){ ?>
								<span class="badge badge-xs badge-danger">1</span>
								<?php } ?>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-lg">
							<li class="text-center notifi-title">Notification</li>
							<li class="list-group">
								<!-- list item-->
								<div class="notifMsg">
									<?php if($pending->num_rows() > 0){ ?>
									<a href="<?= base_url('peminjaman/approval') ?>" class="list-group-item">
										<div class="media">
											<div class="media-left">
												<em class="fa fa-bell-o fa-2x text-danger"></em>
											</div>
											<div class="media-body clearfix">
												<div class="media-heading">Ada permintaan peminjaman baru</div>
												<p class="m-0">
													<small>Ada <?= $pending->num_rows() ?> permintaan yang belum disetujui</small>
												</p>
											</div>
										</div>
									</a>
									<?php }else{ ?>
									<a href="javascript:void(0)" class="list-group-item">
										<div class="media">
											<div class="media-body clearfix">
												<div class="media-heading">Ada tidak memiliki pemberitahuan</div>
											</div>
										</div>
									</a>
									<?php } ?>
								</div>
								<!-- last list item -->
<!-- 								<a href="javascript:void(0);" class="list-group-item">
									<small>See all notifications</small>
								</a> -->
							</li>
						</ul>
					</li>

					<?php } ?>

					<li class="hidden-xs">
						<a href="#" id="btn-fullscreen" class="waves-effect waves-light">
							<i class="md md-crop-free"></i>
						</a>
					</li>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
							<img src="<?= base_url($fotoUser) ?>" alt="user-img" class="img-circle">
						</a>
						<ul class="dropdown-menu">
							<li>
								<a href="<?= base_url('app/profile') ?>"><i class="md md-face-unlock"></i> Profile</a>
							</li>
							<li>
								<a href="<?= base_url('app/logout') ?>"><i class="md md-settings-power"></i> Logout</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>


		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		ajaxNotif();
		setInterval(function() {
			ajaxNotif();
		}, 1000 * 10); 
	});
	function ajaxNotif(){
		$.ajax({    
			type: "POST",
			url: "<?php echo base_url('api/getNotif') ?>",             
			dataType: "html",             
			success: function(response){  
				var jsonRes = $.parseJSON(response);
				$(".notifCount").html(jsonRes['count']);
				$(".notifMsg").html(jsonRes['msg']);
			}
		});
	}
</script>