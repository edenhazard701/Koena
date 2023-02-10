<!DOCTYPE html>
<html lang="en">

<head>
    <title>Forgot Email</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/modules/bootstrap/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/modules/fontawesome/css/all.min.css')?>">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?php echo base_url('assets/modules/bootstrap-social/bootstrap-social.css')?>">

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/components.css')?>">
  <!-- Start GA -->
  <script>var BASE_URL = '<?php echo base_url()?>'</script>

</head>

<body class="dark-edition off-canvas-sidebar">

  <div class="wrapper wrapper-full-page">
    <div class="page-header forgotPassword-page">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <div class="imgLogo card-login card-hidden text-center">
              <img src="<?php echo base_url('assets/img/logo.png')?>" style="width: 100%;margin-bottom:50px;" />
            </div>
            
            <form method="POST" id="ForgotPasswordForm" class="needs-validation" novalidate="">
              <div class="text-center forgotpassword">
                <h3 class="card-title py-2">Forgot Password</h3>
              </div>
              <div class="form-group has-default md-form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="far fa-envelope"></i>
                    </span>
                  </div>
                  <input id="email" type="email" class="form-control" name="email" tabindex="1" placeholder="Email" required autofocus>
                  <div class="invalid-feedback">
                    Please fill in your email
                  </div>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                  submit
                </button>
                <p>
                  Already Register Please 
                  <a href="<?php echo base_url('login')?>">Login</a>
                </p>
              </div>
            </form>
            <div id="reset-password">
              <?php if(isset($_GET['key']) && !empty($_GET['key'])){?>
                <form id="resetPasswordForm" role="form">
                  <div class="text-center forgotpassword">
                    <h3 class="card-title py-2">Reset Password</h3>
                  </div>
                  <div class="form-group has-default md-form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                              <i class="fas fa-lock"></i>
                          </span>
                        </div>
                        <input class="form-control input-box-330" type="password" name="password" id="password" placeholder="Password">
                        <a href="javascript:void(0);" id="see_password">
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="javascript:void(0);" id="hide_password" style="display:none;">
                            <i class="far fa-eye"></i>
                        </a>
                    </div>
                    <p class="required error" id="signup-password-info"></p>
                  </div>
                  <div class="form-group has-default md-form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input class="form-control input-box-330" type="password" name="confirm-password" id="confirm-password" placeholder="Confirm Password">
                        <input type="hidden" name="resetkey" value="<?php echo $_GET['key'];?>">
                    </div>
                    <p class="required error" id="confirm-password-info"></p>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      submit
                    </button>
                    <p>
                      Already Register Please 
                      <a href="<?php echo base_url('login')?>">Login</a>
                    </p>
                  </div>
                </form>
              <?php }else{?>
                <div class="card-header card-header-warning text-center">
                  <h3 class="card-title py-2">Invalid Link</h3>
                </div>
              <?php } ?>
            </div>
          </div>
      </div>
    </div>
  </div>

  <script src="<?php echo base_url('assets/modules/jquery.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/popper.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/tooltip.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/bootstrap/js/bootstrap.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/nicescroll/jquery.nicescroll.min.js')?>"></script>
  <script src="<?php echo base_url('assets/modules/moment.min.js')?>"></script>
  <script src="<?php echo base_url('assets/js/stisla.js')?>"></script>
  <script src="<?php echo base_url('assets/js/notifyme.js')?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/notify.js')?>"></script>
  <script src="<?php echo base_url("assets/js/page/register.js")?>"></script>
  <script src="<?php echo base_url("assets/js/page/forgot-password.js")?>"></script>

</body>

</html>