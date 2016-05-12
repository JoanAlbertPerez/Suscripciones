<div class="container" id="altas_bajas">
  <h2>Altas/Bajas</h2>
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
      <?php foreach ($altas_bajas as $alt): ?>
        <tr>
          <td>
            <?php echo $alt['id']; ?>
          </td>
          <td>
            <?php echo $alt['tipo']; ?>
          </td>
          <td>
            <?php echo $alt['mensaje']; ?>
          </td>
          <td>
            <?php echo $alt['usuario_id']; ?>
          </td>
          <td>
            <?php echo $alt['telefono']; ?>
          </td>
          <td>
            <?php echo $alt['fecha']; ?>
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
