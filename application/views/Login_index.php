<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lokate Student | Login</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url()."/public/";?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url()."/public/";?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url()."/public/";?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
<!--    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">-->

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url()."/public/";?>build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
            
        <div class="animate form login_form">
          <section class="login_content">
              <form method="post" action="<?php echo base_url();?>Login/LoginCheck">
              <h1>Login</h1>
              <?php if ($this->session->flashdata('msg'))  { ?>
                   <div role="alert" class="alert">
                    <strong><?php echo $this->session->flashdata('msg'); ?></strong> 
                  </div>
                   <?php } ?>
              <div>
                  <input name="Username" type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                  <input name="Password" type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                  <input type="submit" value="Login" class="btn btn-default submit" />
<!--                <a class="btn btn-default submit" href="">Log in</a>-->
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
<!--                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>-->

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Lokate Student</h1>
                  <p>©2016 All Rights Reserved. Dunamis</p>
                </div>
              </div>
            </form>
          </section>
        </div>


      </div>
    </div>
  </body>
</html>
