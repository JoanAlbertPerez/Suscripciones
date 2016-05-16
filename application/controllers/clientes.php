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
    if ($client['estado'] == 'baja') {
      $tipo_token = 'pet_token';
      $ws = (array) $this->registros_model->ultima_trans();
      $tran_token = $ws['transaction']+1;
      $xml_rq_token = '<?xml version="1.0" encoding="UTF-8"?>
      <request>
      <transaction>99999999999g</transaction>
      </request>';
      $url_token = "http://52.30.94.95/token";
      $xml_rsp_token = $this->registros_model->api_conn($url_token, $xml_rq_token);
      $xml = simplexml_load_string($xml_rsp_token);
      $code_token = $xml->statusCode;
      $msg_token = $xml->statusMessage;
      $tx_id_token = $xml->txId;
      $token_token = $xml->token;
      $msisdn = null;
      $amount = null;
      $text = null;
      $shortcode = null;
      //$reg_sw = $this->registros_model->set_ws($tipo, $code_token, $msg_token, $tx_id_token, $token_token, $usuario_id, $trans_token, $msisdn, $amount, $text, $shortcode);

      print_r($xml);
      $tipo_cobro = 'pet_cobro';
      $msisdn = $client['telefono'];
      $amount = '1';
      $ws = (array) $this->registros_model->ultima_trans();
      $tran_cobro = $ws['transaction']+1;
      $xml_rq_cobro = '<?xml version="1.0" encoding="UTF-8"?>
      <request>
      <transaction>99999999999h</transaction>
      <msisdn>'.$msisdn.'</msisdn>
      <amount>'.$amount.'</amount>
      <token>'.$token_token.'</token>
      </request>';
      $url_cobro = "http://52.30.94.95/bill";
      $xml_rsp_cobro = $this->registros_model->api_conn($url_cobro, $xml_rq_cobro);
      $xml = simplexml_load_string($xml_rsp_cobro);
      $code_cobro = $xml->statusCode;
      $msg_cobro = $xml->statusMessage;
      $tx_id_cobro = $xml->txId;
      $text = null;
      $shortcode = null;
      //$reg_cobro = $this->registros_model->set_cobro($code_cobro, $tfn)
      //$reg_sw = $this->registros_model->set_ws($tipo, $code_cobro, $msg_cobro, $tx_id_cobro, $token_token, $usuario_id, $trans_cobro, $msisdn, $amount, $text, $shortcode);
      print_r($xml);


    }

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
