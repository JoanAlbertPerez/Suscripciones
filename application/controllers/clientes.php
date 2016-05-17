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
    $data['alert'] = $this->session->flashdata('error');

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
          switch ($data['stat_code']) {
            case 'TOKEN_SUCCESS':
            $i = 1;
            break;
            case 'SYSTEM_ERROR':
            $i = 0;
            break;
            default:
            $cobrado = 'no';
            $this->session->set_flashdata('alert', 'No se ha podido dar de alta al usuario.');
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
            $alta = $this->registros_model->cambiarEstado($orden, $usuario_id);
            $cobrar = $this->registros_model->cobrar($data['usuario_id']);
            $this->session->set_flashdata('alert', 'Se ha podido dar de alta al usuario.');
            break;

            case 'NO_FUNDS':
            $cobrado = 'no';
            $i = 2;
            $this->session->set_flashdata('alert', 'No se ha podido dar de alta al usuario por falta de fondos.');
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
            $this->session->set_flashdata('alert', 'No se ha podido dar de alta al usuario.');
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
            $this->session->set_flashdata('alert', 'No se ha podido mandar el mensaje al usuario.');
            $i = 10;
            break;
          }$fnt=$fnt.'3';
          $reg_sms = $this->registros_model->set_sms($enviado, $data);
          print_r($reg_sms);
          break;
        }
      }
          }elseif ($client['estado'] == 'alta') {
      $orden = 'baja';
      $data = array(
        'tipo' => '',
        'stat_code' => '',
        'stat_msg' => '',
        'transaction' => '',
        'msisdn' => $client['telefono'],
        'shortcode' => substr($client['telefono'], 0, 3),
        'text' => 'Se te ha dado de baja del servicio.',
        'token' => '',
        'tx_id' => '',
        'usuario_id' => $usuario_id,
        'amount' => ''
      );
      $x = 0;
      while ($x != 10) {
        $fnt = '99999999999999999999999999991111212331111';
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
        $data['stat_code'] = $xml->statusCode;
        $data['stat_msg'] = $xml->statusMessage;
        $data['tx_id'] = $xml->txId;

        switch ($data['stat_code']) {
          case 'SUCCESS':
          $enviado = 'si';
          $x = 10;
          $baja = $this->registros_model->cambiarEstado($orden, $data['usuario_id']);
          $this->session->set_flashdata('alert', 'Se ha dado de baja al usuario.');
          break;
          case 'CHARGING_ERROR':
          $enviado = 'no';
          $x = 0;
          break;
          default:
          $enviado = 'no';
          $this->session->set_flashdata('alert', 'No se ha podido dar de baja al usuario.');
          $x = 10;
          break;
        }        $reg_sw = $this->registros_model->set_ws($data);
                $reg_sms = $this->registros_model->set_sms($enviado, $data);
                print_r($reg_sw);
      }
      }
      redirect('Clientes/datatable');
    }
}
?>
