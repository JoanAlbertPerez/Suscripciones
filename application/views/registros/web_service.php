<div class="container" id="web_service">
  <h2>Web Service</h2>
    <table id="datatable" class="display" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>stat_CODE</th>
          <th>stat_msg</th>
          <th>transaction</th>
          <th>msisdn</th>
          <th>shortcode</th>
          <th>text</th>
          <th>token</th>
          <th>tx_id</th>
          <th>ID Usuario</th>
          <th>Fecha</th>
        </tr>
      </thead>
      <?php foreach ($web_service as $web): ?>
        <tr>
          <td>
            <?php echo $web['id']; ?>
          </td>
          <td>
            <?php echo $web['tipo']; ?>
          </td>
          <td>
            <?php echo $web['stat_code']; ?>
          </td>
          <td>
            <?php echo $web['stat_msg']; ?>
          </td>
          <td>
            <?php echo $web['transaction']; ?>
          </td>
          <td>
            <?php echo $web['msisdn']; ?>
          </td>
          <td>
            <?php echo $web['shortcode']; ?>
          </td>
          <td>
            <?php echo $web['text']; ?>
          </td>
          <td>
            <?php echo $web['token']; ?>
          </td>
          <td>
            <?php echo $web['tx_id']; ?>
          </td>
          <td>
            <?php echo $web['usuario_id']; ?>
          </td>
          <td>
            <?php echo $web['fecha']; ?>
          </td>
      <?php endforeach; ?>
      <tfoot>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>stat_CODE</th>
          <th>stat_msg</th>
          <th>transaction</th>
          <th>msisdn</th>
          <th>shortcode</th>
          <th>text</th>
          <th>token</th>
          <th>tx_id</th>
          <th>ID Usuario</th>
          <th>Fecha</th>
        </tr>
      </tfoot>
    </table>
</div>
