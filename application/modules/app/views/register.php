<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="E-Fasilitas | Lapan">

  <title>E-FASILITAS | LAPAN</title>

  <link rel="shortcut icon" href="<?= base_url('assets/img/logo/favicon.png') ?>">

  <?php
  
  $multiple_css = array(
    'backend/css/bootstrap.min.css',
    'backend/css/core.css',
    'backend/css/icons.css',
    'backend/css/components.css',
    'backend/css/pages.css',
    'backend/css/menu.css',
    'backend/css/responsive.css',
    'backend/font-awesome/css/font-awesome.css',
    );

  echo load_css($multiple_css);

  ?>

</head>

<body>

  <div class="wrapper-page" style="margin: 3.5% auto !important;">
    <div class="panel panel-color panel-primary panel-pages">
      <div class="panel-heading text-center" style="padding: 20px; background: #FFF;">
        <img src="<?= base_url('assets/img/logo/logo-horizontal-white.png') ?>" height="70px;">
      </div>
      <form class="form-horizontal" action="<?= base_url('app/register/submit') ?>" method="POST" style="border-top: 1px solid #ddd;">

        <div class="panel-body">

          <div class="form-group">
           <div class="col-xs-12">
             <input class="form-control input-lg" name="email" type="email" required="" placeholder="Email" value="<?= set_value('email') ?>">
             <?= form_error('email') ?>
           </div>
         </div>

         <div class="form-group">
           <div class="col-xs-12">
           <input class="form-control input-lg" name="username" type="text" required="" placeholder="Username" value="<?= set_value('username') ?>">
             <?= form_error('username') ?>
           </div>
         </div>

         <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control input-lg" type="text" name="fullname" required="" placeholder="Nama Lengkap" value="<?= set_value('fullname') ?>">
            <?= form_error('fullname') ?>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control input-lg" type="password" name="password" required="" placeholder="Password">
            <?= form_error('password') ?>
          </div>
        </div>

        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control input-lg" type="password" name="confirm_password" placeholder="Konfirmasi Password">
            <?= form_error('confirm_password') ?> 
          </div>
        </div>


        <div class="form-group text-center m-t-40">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-block btn-lg w-lg waves-effect waves-light" type="submit">
              SIGN UP
            </button>
          </div>
        </div>

      </form>

    </div>


  </div>
</div>


</body>

<?php

$multiple_js = array(
  'backend/js/jquery.min.js',
  'backend/js/bootstrap.min.js',
  );

echo load_js($multiple_js);

?>

</html>