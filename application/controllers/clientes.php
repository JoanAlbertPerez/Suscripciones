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
    if ($this->session->userdata('logueado')) {
      $this->load->view('templates/header');
      $this->load->view('general/inicio', $data);
      $this->load->view('templates/footer');
    }else {
      redirect('usuarios/iniciar_sesion');
    }
  }

  public function pedir_alta($id=0)
  {
    $id = $this->input->post('id');
    $cliente = (array) $this->clientes_model->ver_cliente($id);
    $data = array(
      'tipo' => '',
      'stat_code' => '',
      'stat_msg' => '',
      'transaction' => '',
      'msisdn' => $cliente['telefono'],
      'shortcode' => substr($cliente['telefono'], 0, 3),
      'text' => '',
      'token' => '',
      'tx_id' => '',
      'usuario_id' => $id,
      'amount' => '1',
      'accion' => 'pedir_alta'
    );
    $alta = $this->token_cobro_sms($data);
    redirect('Clientes/datatable');
  }

  public function cobra_mes()
  {
    $lista = $this->registros_model->mensual();
    foreach ($lista as $cliente) {
      $data = array(
        'tipo' => '',
        'stat_code' => '',
        'stat_msg' => '',
        'transaction' => '',
        'msisdn' => $cliente['telefono'],
        'shortcode' => substr($cliente['telefono'], 0, 3),
        'text' => '',
        'token' => '',
        'tx_id' => '',
        'usuario_id' => $cliente['id'],
        'amount' => '1',
        'accion' => 'cobrar_mes'
      );
      $cobro = $this->token_cobro_sms($data);
    }
    redirect('Clientes/datatable');
  }

  public function pedir_baja($id = 0)
  {
    $id = $this->input->post('id');
    $cliente = (array) $this->clientes_model->ver_cliente($id);
        print_r($cliente);
    $data = array(
      'tipo' => '',
      'stat_code' => '',
      'stat_msg' => '',
      'transaction' => '',
      'msisdn' => $cliente['telefono'],
      'shortcode' => substr($cliente['telefono'], 0, 3),
      'text' => '',
      'token' => '',
      'tx_id' => '',
      'usuario_id' => $id,
      'amount' => '1',
      'accion' => 'pedir_baja'
    );
    $baja = $this->mandar_sms($data);
    $cambiar_estado = $this->registros_model->cambiarEstado('baja', $id);
    $registrar_baja = $this->registros_model->set_altas_bajas('baja', $data);
    redirect('Clientes/datatable');
  }

  #----------------------Parte Token-------------------------------

  public function solicitar_token($data)
  {
    $data['tipo'] = 'pet_token';
    $ws = (array) $this->registros_model->ultima_trans();
    $data['transaction'] = $ws[0];
    $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
    <request>
    <transaction>'.$data['transaction'].'</transaction>
    </request>';
    $url = "http://52.30.94.95/token";
    $xml_rsp = $this->registros_model->api_conn($url, $xml_rq);
    $xml = simplexml_load_string($xml_rsp);
    $data['stat_code'] = $xml->statusCode;
    $data['stat_msg'] = $xml->statusMessage;
    $data['tx_id'] = $xml->txId;
    $data['token'] = $xml->token;
    $reg_sw = $this->registros_model->set_ws($data);
    return $data;
  }

  #-----------------------Parte Cobro---------------------------

  public function solicitar_cobro($data)
  {
    $data['tipo'] = 'pet_cobro';
    $data['msisdn'];
    $data['amount'] = '1';
    $ws = (array) $this->registros_model->ultima_trans();
    $data['transaction'] = $ws[0];
    $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
    <request>
    <transaction>'.$data['transaction'].'</transaction>
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
    return $data;
  }

  #-----------------------------------Parte SMS------------------------------------

  public function mandar_sms($data)
  {
    $data['tipo'] = 'pet_sms';
    $ws = (array) $this->registros_model->ultima_trans();
    $data['transaction'] = $ws[0];
    if ($data['accion'] === 'pedir_alta') {
      if ($data['stat_code'] == 'SUCCESS') {
        $data['text'] = 'Se le ha dado de alta al servicio.';
      }elseif ($data['stat_code'] == 'NO_FUNDS') {
        $data['text'] = 'No se le ha podido dar de alta al servicio por falta de fondos.';
      }
    }elseif ($data['accion'] === 'cobrar_mes') {
      if ($data['stat_code'] == 'SUCCESS') {
        $data['text'] = 'Se le ha dado cobrado la suscripcion.';
      }elseif ($data['stat_code'] == 'NO_FUNDS') {
        $data['text'] = 'Se le ha dado de baja del servicio por falta de fondos.';
      }
    }elseif ($data['accion'] === 'pedir_baja') {
      if ($data['stat_code'] == 'SUCCESS') {
        $data['text'] = 'Se le ha dado de baja al servicio.';
      }else{
        $data['text'] = 'No se le ha podido dar de baja al servicio por falta de fondos.';
      }
    }

    $xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
    <request>
    <shortcode>'.$data['shortcode'] = substr($data["msisdn"], 0, 3).'</shortcode>
    <text>'.$data["text"].'</text>
    <msisdn>'.$data["msisdn"].'</msisdn>
    <transaction>'.$data['transaction'].'</transaction>
    </request>';
    $url = 'http://52.30.94.95/send_sms';
    $xml_rsp = $this->registros_model->api_conn($url, $xml_rq);
    $xml = simplexml_load_string($xml_rsp);
    $data['stat_code'] = $xml->statusCode;
    $data['stat_msg'] = $xml->statusMessage;
    $data['tx_id'] = $xml->txId;
    $reg_sw = $this->registros_model->set_ws($data);
    return $data;
  }




  /*--------------------------------Metodo Anidado---------------------------------------------------*/

  public function token_cobro_sms($data)
  {
    $data = $data;
    $i = 0;
    while ($i != 10) {
      if ($i == 0) {
        $data = $this->solicitar_token($data);
        switch ($data['stat_code']) {
          case 'TOKEN_SUCCESS':
          $i = 1;
          break;
          case 'SYSTEM_ERROR':
          $i = 0;
          break;
          default:
          $cobrado = 'no';
          $this->session->set_flashdata('alert', 'Error al solicitar Token.');
          $i = 10;
          break;
        }
      }elseif ($i == 1) {
        $data = $this->solicitar_cobro($data);
        if ($data['accion'] === 'pedir_alta') {
          switch ($data['stat_code']) {
            case 'SUCCESS':
            $cobrado = 'si';
            $i = 2;
            $alta = $this->registros_model->cambiarEstado('alta', $data['usuario_id']);
            $registrar_alta = $this->registros_model->set_altas_bajas('alta', $data);
            $cobrar = $this->registros_model->cobrar($data['usuario_id']);
            $this->session->set_flashdata('alert', 'Se ha podido dar de alta al usuario.');
            break;
            case 'NO_FUNDS':
            $cobrado = 'no';
            $this->session->set_flashdata('alert', 'No se ha podido dar de alta al usuario por falta de fondos.');
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
            $this->session->set_flashdata('alert', 'No se ha podido dar de alta al usuario.');
            $i = 10;
            break;
          }$reg_cobro = $this->registros_model->set_cobro($cobrado, $data);
        }elseif ($data['accion'] === 'cobrar_mes') {
          switch ($data['stat_code']) {
            case 'SUCCESS':
            $cobrado = 'si';
            $i = 2;
            $cobrar = $this->registros_model->cobrar($data['usuario_id']);
            $this->session->set_flashdata('alert', 'Se ha podido dar de alta al usuario.');
            break;
            case 'NO_FUNDS':
            $cobrado = 'no';
            $this->session->set_flashdata('alert', 'Se ha dado de baja al usuario por falta de fondos.');
            $baja = $this->pedir_baja($data['usuario_id']);
            $cambiar_estado = $this->registros_model->cambiarEstado('baja', $data['usuario_id']);
            $registrar_baja = $this->registros_model->set_altas_bajas('baja', $data);
            $i = 10;
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
            $this->session->set_flashdata('alert', 'No se ha podido cobrar al usuario.');
            $registrar_error = $this->registros_model->set_altas_bajas('error', $data);
            $i = 10;
            break;
          }$reg_cobro = $this->registros_model->set_cobro($cobrado, $data);
        }
      }elseif ($i == 2) {
        $data = $this->mandar_sms($data);
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
        }
        $reg_sms = $this->registros_model->set_sms($enviado, $data);
      }elseif ($i == 10) {
      }
    }
  }
}


/*
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
while ($i != 10) {
switch ($i) {
case 0:
$data['tipo'] = 'pet_token';
$ws = (array) $this->registros_model->ultima_trans();
$data['transaction'] = $ws[0];
echo $data['transaction'];
$xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
<request>
<transaction>'.$data['transaction'].'</transaction>
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
}
break;


case 1:
$data['tipo'] = 'pet_cobro';
$data['msisdn'] = $client['telefono'];
$data['amount'] = '1';
$ws = (array) $this->registros_model->ultima_trans();
$data['transaction'] = $ws[0];
$xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
<request>
<transaction>'.$data['transaction'].'</transaction>
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
break;


case 2:
$data['tipo'] = 'pet_sms';
$ws = (array) $this->registros_model->ultima_trans();
$data['transaction'] = $ws[0];
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
<transaction>'.$data['transaction'].'</transaction>
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
}
$reg_sms = $this->registros_model->set_sms($enviado, $data);
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
'text' => 'Se le ha dado de baja del servicio.',
'token' => '',
'tx_id' => '',
'usuario_id' => $usuario_id,
'amount' => ''
);
$x = 0;
while ($x != 10) {
$tipo = 'pet_sms';
$ws = (array) $this->registros_model->ultima_trans();
$data['transaction'] = $ws[0];
$xml_rq = '<?xml version="1.0" encoding="UTF-8"?>
<request>
<shortcode>'.$data['shortcode'].'</shortcode>
<text>'.$data["text"].'</text>
<msisdn>'.$data["msisdn"].'</msisdn>
<transaction>'.$data['transaction'].'</transaction>
</request>';
$prova = simplexml_load_string($xml_rq);
echo $xml_rq;
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
}
}
redirect('Clientes/datatable');
}
*/
?>
