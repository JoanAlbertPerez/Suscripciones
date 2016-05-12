<div class="container" id="cobros">
  <h2>Cobros</h2>
    <table id="datatable" class="display" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Mensaje</th>
          <th>ID Usuario</th>
          <th>Telefono</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <?php foreach ($cobros as $cob): ?>
        <tr>
          <td>
            <?php echo $cob['id']; ?>
          </td>
          <td>
            <?php echo $cob['tipo']; ?>
          </td>
          <td>
            <?php echo $cob['mensaje']; ?>
          </td>
          <td>
            <?php echo $cob['usuario_id']; ?>
          </td>
          <td>
            <?php echo $cob['telefono']; ?>
          </td>
          <td>
            <?php echo $cob['fecha']; ?>
          </td>
      <?php endforeach; ?>
      <tfoot>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Mensaje</th>
          <th>Telefono</th>
          <th>ID Usuario</th>
          <th>Fecha</th>
        </tr>
      </tfoot>
    </table>
</div>
