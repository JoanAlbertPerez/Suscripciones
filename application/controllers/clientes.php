<?php
/**
 *
 */
class Clientes extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url_helper');
    $this->load->model('clientes_model');
    $this->load->model('registros_model');
  }
  public function datatable()
  {
      $data['cliente'] = $this->clientes_model->listar();

      if (empty($data['cliente'])) {
        show_404();
      }

      $this->load->view('templates/header');
      $this->load->view('general/inicio', $data);
      $this->load->view('templates/footer');
  }

  public function sol_alta()
  {
    $id = $this->input->post('id');
    $client = (array) $this->clientes_model->ver_cliente($id);
    $ws = (array) $this->registros_model->ultima_trans();
    $tfn = $client['telefono'];
    $tran = $ws['transaction']+1;
    $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
    <request>
      <transaction>'.$tran.'</transaction>
    </request>';
    $xml_rsp = '<?xml version="1.0" encoding="UTF-8"?>
    <response>
      <statusCode>Code&Status</statusCode>
      <statusMessage>Chase&Status</statusMessage>
      <txId>123qwerty</txId>
      <token>LoooooKooooooMia</token>
    </response>';
    foreach ($xml_rsp->response as $key) {
      $code = $key['statusCode'];
      $msg = $key['statusMessage'];
      $tx_id = $key['txId'];
      $token = $key['token'];
    }

    /*$xml = echo '<?xml version="1.0" encoding="UTF-8"?>
    <request>
      <shortcode>'..'</shortcode>
      <text>'..'</text>
      <msisdn>'.$tfn.'</msisdn>
      <transaction>'..'</transaction>
    </request>';
*/
  }
}

 ?>
