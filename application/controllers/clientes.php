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
    $usuario_id = $this->input->post('id');
    $client = (array) $this->clientes_model->ver_cliente($usuario_id);
    $ws = (array) $this->registros_model->ultima_trans();
    $tfn = $client['telefono'];
    $tran = $ws['transaction']+1;
    $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
    <request>
    <transaction>'.$tran.'</transaction>
    </request>';
    $url = "http://52.30.94.95/token";
    $xml_rsp ='<?xml version="1.0" encoding="UTF-8"?>
    <response>
    <statusCode>CodeAndStatus</statusCode>
    <statusMessage>ChaseAndStatus</statusMessage>
    <txId>123qwerty</txId>
    <token>LoooooKooooooMia</token>
  </response> ';
    $xml = simplexml_load_string($xml_rsp);
    $code = $xml->statusCode;
    $msg = $xml->statusMessage;
    $tx_id = $xml->txId;
    $token = $xml->token;
    $sol_token = $this->registros_model->set_token($code, $msg, $tx_id, $token, $usuario_id, $trans);
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

?>
