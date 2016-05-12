<div class="container" id="form-login">
  <form class="center-block form-horizontal" role="form" action=" <?php echo site_url('Usuarios/iniciar_sesion_post'); ?>" method="post">
    <div class="form-group ">
      <div class="col-sm-9 col-sm-offset-1">
        <input class="form-control input-lg" placeholder="Usuario" type="text" name="usuario" value="" >
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-9 col-sm-offset-1">
        <input class="form-control input-lg" id="pass" placeholder="Contraseña" type="password" name="password" value="" >
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-9 col-sm-offset-1">
        <button type="submit" class="btn btn-lg btn-primary btn-block" name="enviar">Entrar</button>
      </div>
    </div>
  </form>
</div>
