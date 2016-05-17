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
      $orden = 'alta';
      $data = array(
        'tipo' => '',
        'stat_code' => '',
        'stat_msg' => '',
        'transaction' => '',
        'msisdn' => '',
        'shortcode' => '',
        'text' => '',
        'token' => '',
        'tx_id' => '',
        'usuario_id' => $usuario_id,
        'amount' => ''
     );
     $i = 0;
$fnt = '999999999999999999999999999915236580411';
      while ($i != 10) {

        switch ($i) {
          case 0:
          $tipo = 'pet_token';
          $ws = (array) $this->registros_model->ultima_trans();
          $data['transaction'] = $ws['transaction']+1;
          $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
          <request>
          <transaction>'.$fnt.'</transaction>
          </request>';
          $url = "http://52.30.94.95/token";
          $xml_rsp = $this->registros_model->api_conn($url, $xml_rq);
          $xml = simplexml_load_string($xml_rsp);
          $data['stat_code'] = $xml->statusCode;
          $data['stat_msg'] = $xml->statusMessage;
          $data['tx_id'] = $xml->txId;
          $data['token'] = $xml->token;
          $reg_sw = $this->registros_model->set_ws($data);
          print_r($reg_sw);
          echo "-----------------------".$fnt."-----------------------";
          //print_r($data['stat_code']);
          switch ($data['stat_code']) {
            case 'TOKEN_SUCCESS':
            $i = 1;
            break;
            case 'SYSTEM_ERROR':
            $i = 0;
            break;
            default:
            $cobrado = 'no';
            echo "-------------------T_P_M---------------------";
            $i = 10;
            break;
          }$fnt=$fnt.'1';
          break;


          case 1:
          $data['tipo'] = 'pet_cobro';
          $data['msisdn'] = $client['telefono'];
          $data['amount'] = '1';
          $ws = (array) $this->registros_model->ultima_trans();
          $data['transaction'] = $ws['transaction']+1;
          $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
          <request>
          <transaction>'.$fnt.'</transaction>
          <msisdn>'.$data['msisdn'].'</msisdn>
          <amount>'.$data['amount'].'</amount>
          <token>'.$data['token'].'</token>
          </request>';
          $url = "http://52.30.94.95/bill";
          $xml_rsp = $this->registros_model->api_conn($url, $xml_rq);
          $xml = simplexml_load_string($xml_rsp);
          $data['stat_code'] = $xml->statusCode;
          $data['stat_msg'] = $xml->statusMessage;
          $data['tx_id'] = $xml->txId;
          $reg_sw = $this->registros_model->set_ws($data);
          print_r($reg_sw);
          echo "-----------------------".$fnt."-----------------------";
          //print_r($data['stat_code']);
          switch ($data['stat_code']) {
            case 'SUCCESS':
            $cobrado = 'si';
              $i = 2;
            break;

            case 'NO_FUNDS':
            $cobrado = 'no';
              $i = 2;
            break;

            case 'SYSTEM_ERROR':
            $cobrado = 'no';
            $i = 1;
            break;

            case 'CHARGING_ERROR':
            $cobrado = 'no';
            $i = 0;
            break;
            default:
            $cobrado = 'no';
            echo "-------------------T_P_M---------------------";
            $i = 10;
            break;
          }$reg_cobro = $this->registros_model->set_cobro($cobrado, $data);
          print_r($reg_cobro);
          $fnt=$fnt.'2';
          break;


          case 2:
          $tipo = 'pet_sms';
          $ws = (array) $this->registros_model->ultima_trans();
          $data['transaction'] = $ws['transaction']+1;
          if ($data['stat_code'] == 'SUCCESS') {
            $data['text'] = 'Se le ha dado de alta al servicio.';
          }elseif ($data['stat_code'] == 'NO_FUNDS') {
            $data['text'] = 'No se le ha podido dar de alta al servicio por falta de fondos.';
          }
          $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
          <request>
          <shortcode>'.$data['shortcode'] = substr($data["msisdn"], 0, 3).'</shortcode>
          <text>'.$data["text"].'</text>
          <msisdn>'.$data["msisdn"].'</msisdn>
          <transaction>'.$fnt.'</transaction>
          </request>';
          $url = 'http://52.30.94.95/send_sms';
          $xml_rsp = $this->registros_model->api_conn($url, $xml_rq);
          $xml = simplexml_load_string($xml_rsp);
          $data['stat_code'] = $xml->statusCode;
          $data['stat_msg'] = $xml->statusMessage;
          $data['tx_id'] = $xml->txId;

          $reg_sw = $this->registros_model->set_ws($data);
          print_r($reg_sw);
          echo "-----------------------".$fnt."-----------------------";

          //print_r($data['stat_code']);
          switch ($data['stat_code']) {
            case 'SUCCESS':
            $enviado = 'si';
            $i = 10;
            break;
            case 'CHARGING_ERROR':
            $enviado = 'no';
            $i = 2;
            break;
            case 'SYSTEM_ERROR':
            $enviado = 'no';
            $i = 0;
            break;
            default:
            $enviado = 'no';
            echo "-------------------T_P_M---------------------";
            $i = 10;
            break;
          }$fnt=$fnt.'3';
          $reg_sms = $this->registros_model->set_sms($enviado, $data);
          print_r($reg_sms);
          break;

        }echo "----------------Entrant al cas ". $i."----------------";
      }echo "------------------Finalitzat------------------";
      $alta = $this->registros_model->cambiarEstado($orden, $usuario_id);
    }elseif ($client['estado'] == 'alta')) {
      $data = array(
        'tipo' => '',
        'stat_code' => '',
        'stat_msg' => '',
        'transaction' => '',
        'msisdn' => $client['telefono'],
        'shortcode' => substr($client['telefono'];, 0, 3),
        'text' => 'Se te ha dado de baja del servicio.',
        'token' => '',
        'tx_id' => '',
        'usuario_id' => $usuario_id,
        'amount' => ''
     );
      $tipo = 'pet_sms';
      $ws = (array) $this->registros_model->ultima_trans();
      $data['transaction'] = $ws['transaction']+1;
      $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
      <request>
      <shortcode>'.$data['shortcode'].'</shortcode>
      <text>'.$data["text"].'</text>
      <msisdn>'.$data["msisdn"].'</msisdn>
      <transaction>'.$fnt.'</transaction>
      </request>';
      $url = 'http://52.30.94.95/send_sms';
      $xml_rsp = $this->registros_model->api_conn($url, $xml_rq);
      $xml = simplexml_load_string($xml_rsp);
      $reg_sw = $this->registros_model->set_ws($data);
      $reg_sms = $this->registros_model->set_sms($data)
      print_r($reg_sw);

    }
  }
  /*

  $tipo_token = 'pet_token';
  $ws = (array) $this->registros_model->ultima_trans();
  $data['transaction']_token = $ws['transaction']+1;
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
  print_r(simplexml_load_string($xml_rq_token));
  print_r($xml);

  if ($code_token == 'SUCCESS') {

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
  print_r(simplexml_load_string($xml_rq_cobro));
  print_r($xml);

  if ($code_cobro == 'SUCCESS' || $code_cobro == 'NO_FUNDS') {
  $tipo_sms = 'pet_sms';
  $ws = (array) $this->registros_model->ultima_trans();
  $tran_sms = $ws['transaction']+1;
  if ($code_cobro == 'SUCCESS') {
  $text = 'Se le ha dado de alta al servicio.';
}else{
$text = 'No se le ha podido dar de alta al servicio por falta de fondos.';
}
$xml_rq_sms = '<?xml version="1.0" encoding="UTF-8"?>
<request>
<shortcode>'.$shortcode = substr($msisdn, 0, 3).'</shortcode>
<text>'.$text.'</text>
<msisdn>'.$msisdn.'</msisdn>
<transaction>'.$tran_sms.'</transaction>
</request>';
print_r(simplexml_load_string($xml_rq_sms));
}
}
}*/

}
?>
