<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title><?php echo $this->config->config['app_company']; ?> | <?php echo $this->config->config['app_name']; ?></title>

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
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/application.js"></script>
    <script type='text/javascript'>
        var baseurl = '<?php echo base_url(); ?>';
    </script>
</head>

<body class="navbar-fixed">

    <!-- Navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">SITPU</a>
            <a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
                <span class="sr-only">Toggle navbar</span>
                <i class="icon-grid3"></i>
            </button>
            <button type="button" class="navbar-toggle offcanvas">
                <span class="sr-only">Toggle navigation</span>
                <i class="icon-paragraph-justify2"></i>
            </button>
        </div>

        <ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">

            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="icon-notification"></i>
                    <span class="label label-default">6</span>
                </a>
                <div class="popup dropdown-menu dropdown-menu-right">
                    <div class="popup-header">
                        <a href="#" class="pull-left"><i class="icon-bubble-notification"></i></a>
                        <span>Notifikasi</span>
                        <a href="#" class="pull-right"><i class="icon-new-tab"></i></a>
                    </div>
                    <ul class="popup-messages">
                        <li class="unread">
                            <a href="#">
                                <img src='<?php echo base_url();?>assets/images/user/<?php echo $photo;?>' alt="" class="user-face">
                                <strong><?php echo $this->session->userdata('user_fullname');?> <i class="icon-attachment2"></i></strong>
                                <span>Terdapat Perusahaan update data laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src='<?php echo base_url();?>assets/images/user/antho.png' alt="" class="user-face">
                                <strong>Ghany Cahyadi<i class="icon-attachment2"></i></strong>
                                <span>Terdapat Perusahaan update data laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src='<?php echo base_url();?>assets/images/user/antho.png' alt="" class="user-face">
                                <strong>Ade Sugiandi</strong>
                                <span>Terdapat Perusahaan update data laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src='<?php echo base_url();?>assets/images/user/antho.png' alt="" class="user-face">
                                <strong>Deni Rudiansah</strong>
                                <span>Aliquam interdum convallis massa...</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src='<?php echo base_url();?>assets/images/user/antho.png' alt="" class="user-face">
                                <strong>Ibnu Ibrahim</strong>
                                <span>Terdapat Perusahaan update data laporan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            

            <li class="user dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src='<?php echo base_url();?>assets/images/user/<?php echo $photo;?>'>
                    <span><?php echo $this->session->userdata('user_fullname');?></span>
                    <i class="caret"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-right icons-right">
                    <li><a href='<?php echo base_url();?>home/auth/profil'><i class="icon-user"></i>Profile</a></li>
                    <li><a href='<?php echo base_url();?>home/auth/logout'><i class="icon-exit"></i>Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /navbar -->


    <!-- Page container -->
    <div class="page-container">


        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">

                <!-- User dropdown -->
                <div class="user-menu dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src='<?php echo base_url();?>assets/images/user/<?php echo $photo;?>'>
                        <div class="user-info">
                            <?php echo $this->session->userdata('user_fullname');?> <span><?php echo $this->session->userdata('user_access_name');?></span>
                        </div>
                    </a>
                    <div class="popup dropdown-menu dropdown-menu-right">
                        <div class="thumbnail">
                            <div class="thumb">
                                <img src='<?php echo base_url();?>assets/images/user/<?php echo $photo;?>'>
                                <div class="thumb-options">
                                    <span>
                                        <a href="#" class="btn btn-icon btn-success"><i class="icon-pencil"></i></a>
                                        <a href="#" class="btn btn-icon btn-success"><i class="icon-remove"></i></a>
                                    </span>
                                </div>
                            </div>

                            <div class="caption text-center">
                                <h6><?php echo $this->session->userdata('user_fullname');?> <small><?php echo $this->session->userdata('user_access_name');?></small></h6>
                            </div>
                        </div>

                        <ul class="list-group">
                            <li class="list-group-item">Last Ip Address <span class="label label-danger"><?php echo $this->session->userdata('user_ip_address');?></span></li>
                            <li class="list-group-item">Last Login <span class="label label-danger"><?php echo $this->session->userdata('user_last_login');?></span></li>
                            <li class="list-group-item icons-right"><a href='<?php echo base_url();?>home/auth/profil'><i class="icon-user"></i>Profile</a></li>
                            <li class="list-group-item icons-right"><a href='<?php echo base_url();?>home/auth/logout'><i class="icon-exit"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /user dropdown -->


                <!-- Main navigation -->
                <?php echo $menu;?>

                <!-- /main navigation -->

            </div>
        </div>
        <!-- /sidebar -->


        <!-- Page content -->
        <div class="page-content">
          <?php echo $_content; ?>
          <!-- Small modal -->
          <div id="konfirmasipenyimpanan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header btn-info">
                        <h4 class="modal-title"><i class="icon-warning"></i> Konfirmasi</h4>
                    </div>

                    <div class="modal-body with-padding">
                        <p id="text_alert">Anda yakin menyimpan data ini ?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-xs btn-primary" id="setujukonfirmasibutton"> Yakin</button><button type="button" class="btn btn-xs btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="footer clearfix">
            <div class="pull-center">Hak Cipta &copy; 2016 Mediatama Kreasi Informatika. All Right Reserved.</div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /page content -->
    <?php 
    $notify = $this->session->flashdata('notify');
    ?>

</div>
<!-- /page container -->
<script type="text/javascript">

    function show_notif(){
        var wew = "<?php echo $this->session->flashdata('message_name');?>";
        var title = "<?php echo $notify['title'];?>";
        var message = "<?php echo $notify['message'];?>";
        var status = "<?php echo $notify['status'];?>";
        var theme = "";
        var header = "";
        if(status == "error"){
            theme = 'growl-error';
            header = title;
            $.jGrowl(message, {
              theme: theme,
              header: header
          });
        }else if(status=="success"){
            header = title;
            $.jGrowl(message, {
              theme: theme,
              header: header
          });
        }

    }
    function set_default_datatable() {
        $('.tooltips,.tip').tooltip();
        $(".dataTables_length select").select2({
            minimumResultsForSearch: "-1"
        });
    }

    $(document).ready(function() {
        show_notif();
    });
</script>

</body>
</html>