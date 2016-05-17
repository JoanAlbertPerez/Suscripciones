  <div class="container" id="principal">
    <div class="jumbotron center-block">
      <?php if ($this->session->userdata('alert')) { ?>
        <div class="container center-block">
          <p>
            <?php echo $this->session->userdata('alert'); ?>
          </p>
        </div>
      <?php } ?>
    <table id="datatable" class="display" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Estado</th>
          <th>Telefono</th>
          <th>Ultimo Cobro</th>
          <th>Dar de alta/baja</th>
        </tr>
      </thead>
      <?php foreach ($cliente as $cli): ?>
        <tr>
          <td>
            <?php echo $cli['id']; ?>
          </td>
          <td>
            <?php echo $cli['nombre']; ?>
          </td>
          <td>
            <?php echo $cli['apellidos']; ?>
          </td>
          <td>
            <?php echo $cli['estado']; ?>
          </td>
          <td>
            <?php echo $cli['telefono']; ?>
          </td>
          <td>
            <?php echo $cli['ultimo_cobro']; ?>
          </td>
          <?php if ($cli['estado'] == 'baja') {?>
          <td>
            <form class="element-entry" action="<?php echo site_url('Clientes/sol_alta'); ?>" method="post">
              <input type="hidden" id="id" name="id" value="<?php echo $cli['id'] ?>">
              <input type="submit" name="alta" value="alta">
            </form>
          </td>
          <?php }else{ ?>
            <td>
              <form class="element-entry" action="<?php echo site_url('Clientes/sol_alta'); ?>" method="post">
                <input type="hidden" id="id" name="id" value="<?php echo $cli['id'] ?>">
                <input type="submit" name="alta" value="baja">
              </form>
            </td>
            <?php } ?>
        </tr>
      <?php endforeach; ?>
      <tfoot>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Estado</th>
          <th>Telefono</th>
          <th>Ultimo Cobro</th>
          <th>Dar de alta/baja</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
