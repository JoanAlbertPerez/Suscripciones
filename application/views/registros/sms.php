<div class="container" id="sms">
  <h2>SMS</h2>
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
      <?php foreach ($sms as $sm): ?>
        <tr>
          <td>
            <?php echo $sm['id']; ?>
          </td>
          <td>
            <?php echo $sm['tipo']; ?>
          </td>
          <td>
            <?php echo $sm['mensaje']; ?>
          </td>
          <td>
            <?php echo $sm['usuario_id']; ?>
          </td>
          <td>
            <?php echo $sm['telefono']; ?>
          </td>
          <td>
            <?php echo $sm['fecha']; ?>
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
