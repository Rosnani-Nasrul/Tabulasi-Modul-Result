<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    
<!-- Mirrored from byrushan.com/projects/ma/1-5-1/jquery/lockscreen.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2015 08:15:12 GMT -->
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->config->config['app_company']; ?> | <?php echo $this->config->config['app_name']; ?> - Login</title>
        
        <!-- Vendor CSS -->
        <link href="<?php echo base_url(); ?>assets/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
            
        <!-- CSS -->
        <link href="<?php echo base_url(); ?>assets/css/app.min.1.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/app.min.2.css" rel="stylesheet">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png" type="img/x-icon" />

        <script type='text/javascript'>
            var baseurl = '<?php echo base_url(); ?>';
            var loginurl = baseurl+"home/auth/checklogin";
        </script>
    </head>
    
    <body class="login-content" style="padding-top:0px;">
        <div class="lc-block lcb-alt toggled" id="l-lockscreen"> 
            
            <img class="lcb-user" src="<?php echo base_url(); ?>assets/img/lock.png" alt="">

            <div style="padding:0 20px 20px 20px;display:none;" id="elem-error">
                <div id="elem-error-display" style="border:2px dashed #AB2700;color:#AB2700;padding:8px;">Username tidak Terdaftar</div>
            </div>
            
            <b><?php echo $this->session->userdata('user_fullname'); ?></b><br/><br/>
            <div class="fg-line">
                <input type="hidden" id="username" value="<?php echo $this->session->userdata('user_username'); ?>">
                <input type="password" id="password" class="form-control text-center" placeholder="Password">
            </div>
            <div style="align:left;padding-top:15px;"><a href="<?php echo base_url(); ?>home/auth/login/1">Masuk sebagai Pengguna lain</a>
            <div class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-sign-in"></i></div>
        </div>
        
        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>   
        <![endif]-->
        
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url(); ?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="<?php echo base_url(); ?>assets/vendors/bower_components/Waves/dist/waves.min.js"></script>
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="<?php echo base_url(); ?>assets/js/functions.js"></script>

        <script type="text/javascript">
            localStorage.setItem('ma-layout-status', 1);
            $(function() {
                $('#password').focus();
                $('.btn-login').click(function() {
                    doLogin();
                });
                $('#password').keypress(function(e) {
                    if(e.which == 13) {
                        doLogin();
                    }
                });
            });
            function doLogin() {
                $('#elem-error').slideUp(100);

                var uname = $("input#username").val();
                var passwd = $("input#password").val();
                if(passwd=='') {
                    $('#elem-error-display').html('<b>Gagal</b>: Password harus diisi');
                    $('#elem-error').slideDown(200);
                } else {
                    $.ajax({
                        url: loginurl,
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            username: uname,
                            password: passwd
                        },
                        error: function()
                        {
                            alert("Sistem sedang gangguan!");
                        },
                        success: function(response)
                        {
                            var login_status = response.status;
                            var login_message = response.message;
                            if(login_status==0) {
                                $('#elem-error-display').html('<b>Gagal</b>: '+login_message);
                                $('#elem-error').slideDown(200);
                                $('#password').select();
                            } else {
                                /*var redirect_url = baseurl;
                                        
                                if(response.redirect_url && response.redirect_url.length)
                                {
                                    redirect_url = response.redirect_url;
                                }
                                
                                window.location.href = baseurl+redirect_url;*/
                                window.location.href = response.redirect_url;
                            }
                        }
                    });
                }
            }
        </script>
        
    </body>
</html>