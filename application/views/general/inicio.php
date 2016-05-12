<div class="container" id="principal">
    <table id="datatable" class="display" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Estado</th>
          <th>Telefono</th>
          <th>Ultimo Cobro</th>
          <th>Dar de alta</th>
          <th>Dar de baja</th>
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
          <td>
            <form class="element-entry" action="<?php echo site_url('Clientes/sol_alta'); ?>" method="post">
              <input type="hidden" id="id" name="id" value="<?php echo $cli['id'] ?>">
              <input type="submit" name="alta" value="alta">
            </form>
          </td>
          <td>
            <form class="element-entry" action="<?php echo site_url('Clientes/sol_baja'); ?>" method="post">
              <input type="hidden" name="id" value="<?php echo $cli['id'] ?>">
              <input type="submit" name="baja" value="baja">
            </form>
          </td>
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
          <th>Dar de alta</th>
          <th>Dar de baja</th>
        </tr>
      </tfoot>
    </table>
</div>
