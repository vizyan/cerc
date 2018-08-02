<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>CERC - Pengajuan Proyek</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="viewport" content="width=device-width" />

  <!-- Bootstrap core CSS     -->
  <link href="<?= base_url('assets'); ?>/css/bootstrap_pure.min.css" rel="stylesheet" />
  <!--  Material Dashboard CSS    -->
  <link href="<?= base_url('assets'); ?>/vendor/material/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
  <!-- Datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/bootstrap/css/bootstrap-datepicker.min.css">
  <!--     Fonts and icons     -->
  <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

  <!--   Core JS Files   -->
  <script src="<?= base_url('assets');?>/vendor/jquery/jquery.min.js" type="text/javascript"></script>
  <script src="<?= base_url('assets');?>/vendor/bootstrap/js/bootstrap_pure.min.js" type="text/javascript"></script>
  <!-- Bootstrap Date picker -->
  <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap-datepicker.min.js"></script>
  <script src="<?= base_url('assets');?>/vendor/material/js/material.min.js" type="text/javascript"></script>
</head>
<body>
  <div class="wrapper">
    <div class="sidebar" data-color="orange">
      <div class="logo">
        <a href="<?= site_url(); ?>" class="simple-text">CERC</a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="<?= site_url('pengajuan'); ?>">
              <i class="material-icons">create</i><p>Pengajuan</p>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="material-icons">check_circle_outline</i><p>Cek Proyek <small class="text-danger">Alpha ver.</small></p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="<?= site_url('u'); ?>"> CERC </a> -->
          </div>
        </div>
      </nav>
        
      <div class="content">
        <div class="container-fluid">
          <?php $this->load->view('pengajuan/'. $view_name); ?>
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid">
          <nav class="pull-left">
            <ul>
              <li><a href="<?= site_url(); ?>">Home</a></li>
              <li><a href="<?= site_url('project'); ?>">Project</a></li>
              <li><a href="<?= site_url('event'); ?>">Event</a></li>
              <li><a href="<?= site_url('club'); ?>">Club</a></li>
            </ul>
          </nav>
          <p class="copyright pull-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>
            <a href="http://www.creative-tim.com">Computer Engineering Research Club</a>, made with <i class="material-icons">favorite_border</i>
          </p>
        </div>
      </footer>
    </div>
  </div>
</body>

<script>
$(document).ready(function(){
  var msg = '<?= $this->session->flashdata('msg'); ?>';
  var type = '<?= $this->session->flashdata('type'); ?>';
  type = type.length == 0 ? 'success' : type;

  if(msg.length !== 0){
    $.notify({
      icon: "notifications",
      message: msg
    }, {
      type: type,
      timer: 3000,
      placement: {
        from: 'top',
        align: 'center'
      }
    });
  }
});

$(function () {
  $('#datepicker').datepicker({
    autoclose: true,
    format: "yyyy-mm-dd"
  });
});
</script>

<!--  Dynamic Elements plugin -->
<script src="<?= base_url('assets');?>/vendor/material/js/arrive.min.js"></script>
<!--  Sharrre Plugin -->
<!-- <script src="<?= base_url('assets');?>/vendor/material/js/jquery.sharrre.js"></script> -->
<!--  PerfectScrollbar Library -->
<script src="<?= base_url('assets');?>/vendor/material/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="<?= base_url('assets');?>/vendor/material/js/bootstrap-notify.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?= base_url('assets');?>/vendor/material/js/material-dashboard.js?v=1.2.0"></script>
</html>