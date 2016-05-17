<html>
<head>
  <link rel="shortcut icon" href="http://www.kitmaker.com/wp-content/uploads/2015/09/favicon_1.png">
  <title>Kitmaker Suscripciones</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/script.js" type="text/javascript"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <!-- Latest compiled and minified JavaScript -->
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
  <!-- My CSS-->
  <!-- My JS -->
  <script src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#datatable').DataTable( {
    } );
  } );
  </script>
</head>
<body>
  <div id="body">
    <nav class="navbar navbar-inverse navbar-fixed-top" id="barra-navegacion">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <?php  if ($this->session->userdata('logueado')) { ?>
            <a class="navbar-brand" href="<?php echo site_url(""); ?>"><img style="height: 30px;" src="http://www.kitmaker.com/wp-content/uploads/2015/07/kitmaker_logo1.png" alt="KITMAKER" /></a>
            <?php }else{ ?>
              <a class="navbar-brand" href="<?php echo site_url('usuarios/iniciar_sesion'); ?>"><img style="height: 30px;" src="http://www.kitmaker.com/wp-content/uploads/2015/07/kitmaker_logo1.png" alt="KITMAKER" /></a>
              <?php } ?>
            </div>
            <?php  if ($this->session->userdata('logueado')) { ?>
              <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                  <li><a href="<?php echo site_url("news"); ?>">Inicio</a></li>
                  <li><a href="<?php echo site_url("news/create"); ?>">Añadir entrada</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="<?php echo site_url('usuarios/logueado'); ?>"span class="glyphicon glyphicon-user"> Administración</a></li>
                  <li><a href="<?php echo site_url('usuarios/cerrar_sesion');?>" <span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
                </ul>
              </div>
              <?php } ?>
            </div>
          </nav>
