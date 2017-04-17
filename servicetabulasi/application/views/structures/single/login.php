<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title><?php echo $this->config->config['app_company']; ?> | <?php echo $this->config->config['app_name']; ?> - Login</title>

    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/londinium-theme.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/charts/sparkline.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/uniform.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/select2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/inputmask.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/autosize.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/inputlimit.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/listbox.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/multiselect.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/tags.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/switch.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/uploader/plupload.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/uploader/plupload.queue.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/wysihtml5/wysihtml5.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/forms/wysihtml5/toolbar.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/daterangepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/moment.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/jgrowl.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/interface/timepicker.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validation_login.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
    <style type="text/css">
       img.bg {
          /* Set rules to fill background */
          min-height: 100%;
          min-width: 1024px;

          /* Set up proportionate scaling */
          width: 100%;
          height: auto;

          /* Set up positioning */
          position: fixed;
          top: 0;
          left: 0;
      }

      @media screen and (max-width: 1024px) { /* Specific to this particular image */
          img.bg {
            left: 50%;
            margin-left: -512px;   /* 50% */
        }
    }
    .well{
        background:none !important;
        border:none;
    }
    .popup-header{
        background:none !important;
    }
    .footer{
     background:none !important;   
     border:none;
     color: white;
 }
 .login-wrapper{
    margin-top:-230px
}
.form-control{
    background-color: transparent;
    color: white;
}
.form-control-feedback{
    color: white !important;
}
</style>
<script type='text/javascript'>
    var baseurl = '<?php echo base_url(); ?>';
</script>
</head>

<body class="full-width page-condensed">

    <img src="<?php echo base_url(); ?>assets/images/bg.png" class="bg">
    <div class="login-wrapper">
        <form class="need_validation" action="<?php echo base_url(); ?>home/auth/checklogin" role="form" method="post" enctype="multipart/form-data">
            <div class="popup-header">
                <img src="<?php echo base_url(); ?>assets/images/logo_lama.png" style="height:80px;clear:both;">
                <span class="text-semibold">SISTEM INFORMASI<br />TABULASI PEMILIHAN UMUM</span>
            </div>
            <div class="well">
                <?php if($message!=""){?>
                <div class="alert alert-danger" style="background-color: transparent;color:white;border-color:#ddd;border-radius:0px;">
                    <span style="color:red">Terdapat kesalahan.</span><br><?php echo $message;?>.
                </div>
                <?php } ?>
                <fieldset>
                    <div class="form-group has-feedback">
                        <label style="color:white">Username</label>
                        <input type="text" class="form-control wajib" placeholder="Username" name="username" id="username">
                        <i class="icon-users form-control-feedback"></i>
                    </div>

                    <div class="form-group has-feedback">
                        <label style="color:white">Password</label>
                        <input type="password" class="form-control wajib" placeholder="Password" name="password" id="password">
                        <i class="icon-lock form-control-feedback"></i>
                    </div>
                    
                    <div class="row form-actions">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info pull-right col-xs-12" style="background-color:#19476E;border-color:#ddd;">SIGN IN</button>
                        </div>
                    </div>
                </fieldset>

                
            </div>
        </form>
    </div>
    <div class="footer clearfix">
        <div class="pull-center">
            Hak Cipta &copy; 2016 Mediatama Kreasi Informatika. All Right Reserved.
        </div>
    </div>
</body>
</html>