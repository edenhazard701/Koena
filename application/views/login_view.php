<!DOCTYPE html>
<html lang="en">

<head>
    <title>Funding Traders Africa Software</title>

    <!-- Required meta tags -->
    <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/bootstrap/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/fontawesome/css/all.min.css')?>">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?php echo base_url('assets/modules/bootstrap-social/bootstrap-social.css')?>">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/components.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css')?>">
  <!-- Start GA -->
  <script>var BASE_URL = '<?php echo base_url()?>'</script>
  <!-- /END GA -->
    
</head>

<body class="dark-edition off-canvas-sidebar">
    <div style="margin-top: 200px;">
        <div class="page-header login-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 ml-auto mr-auto">
                        <div class="card card-signup">
                          <div class="card-header card-header-warning text-center">
                              <h3 class="card-title py-2">Login</h3>
                          </div>
                            <div class="card-body register-form-wrap">
                                <div class="row">
                                    <div class="col-md-5 ml-auto">
                                        <div class="info info-horizontal">
                                            <div class="description">
                                                <img 
                                                  src="<?php echo base_url('assets/img/logo.png')?>" 
                                                  style="width: 100%;margin-bottom:10px;margin-top:30px;" />
                                            </div>
                                        </div>
                                        <div class="info info-horizontal">
                                            <div class="description">
                                                <p style="text-align:center;">
                                                    <a href="<?php echo base_url('forgot_password')?>">Forgot Password?</a>
                                                </p>
                                            </div>
                                        </div>
                                        <br />
                                       
                                    </div>
                                    <div class="col-md-5 mr-auto">
                                      <form method="POST" id="loginForm" class="needs-validation" novalidate="">
                                        <div class="form-group has-default md-form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group has-default md-form-group">
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                  <i class="far fa-envelope"></i>
                                              </span>
                                            </div>
                                            <input id="username" type="email" class="form-control" name="email" tabindex="1" placeholder="Email" required autofocus>
                                            <div class="invalid-feedback">
                                              Please fill in your email
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group has-default md-form-group">
                                          <div class="input-group">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text">
                                                  <i class="fas fa-lock"></i>
                                              </span>
                                            </div>
                                            <input class="form-control input-box-330" type="password" name="password" id="password" placeholder="Password">
                                          </div>
                                        </div>
                                        <div class="text-center">
                                          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                          </button>
                                           <a href="<?php echo base_url('register')?>" class="btn btn-primary btn-lg btn-block" >Register</a>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <!--<script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="assets/js/plugins/material-dashboard.min.js"></script>
    <script src="assets/js/plugins/bootstrap-notify.js"></script>
    <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script src="assets/js/app/notifyme.js"></script>-->

    <script src="<?php echo base_url('assets/modules/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('assets/modules/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/modules/tooltip.js')?>"></script>
    <script src="<?php echo base_url('assets/modules/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/modules/nicescroll/jquery.nicescroll.min.js')?>"></script>
    <script src="<?php echo base_url('assets/modules/moment.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/stisla.js')?>"></script>
    <script src="<?php echo base_url('assets/js/notifyme.js')?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/notify.js')?>"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
  <script src="<?php echo base_url('assets/js/custom.js')?>"></script>

  <script src="<?php echo base_url('assets/js/page/login.js')?>"></script>
<style>
.filter-option-inner-inner{color: #000000 !important;}
.register-country, .register-timezone{width:280px !important;}
</style>
</body>

</html>