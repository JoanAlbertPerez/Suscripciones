<?php
/**
*
*/
class Registros_model extends CI_Model
{

  function __construct()
  {
    $this->load->database();
    $this->load->library('web_services');
  }

  public function altas_bajas()
  {
    $query = $this->db->get('altas_bajas');
    return $query->result_array();
  }

  public function cobros()
  {
    $query = $this->db->get('cobros');
    return $query->result_array();
  }


  public function sms()
  {
    $query = $this->db->get('sms');
    return $query->result_array();
  }

  public function web_service()
  {
    $query = $this->db->get('web_service');
    return $query->result_array();
  }

  public function ultima_trans()
  {
    $sql = "SELECT * from web_service where id = (select max(id))";
    $query = $this->db->query($sql);
    return $query->row();
  }

  public function set_ws($data)
  {
    $insert  = array(
      'tipo' => $data['tipo'],
      'stat_code' =>  $data['stat_code'],
      'stat_msg' => $data['stat_msg'],
      'tx_id' => $data['tx_id'],
      'token' => $data['token'],
      'usuario_id' => $data['usuario_id'],
      'transaction' => $data['transaction'],
      'msisdn' => $data['msisdn'],
      'amount' => $data['amount'],
      'text' => $data['text'],
      'shortcode' => $data['shortcode']
    );
    return $insert;
    //$this->db->insert('web_service', $insert);
  }

  public function set_cobro($cobrado, $data)
  {
    $newCobro = array(
      'tipo' => $cobrado,
      'mensaje' => $cobrado .' se le han cobrado '.$data['amount'].'€',
      'usuario_id' => $data['usuario_id'],
      'telefono' => $data['msisdn']
    );
    return $this->db->insert('cobros', $newCobro);
  }



  public function set_sms($enviado ,$data)
  {
    $newSms = array(
      'tipo' => $enviado,
      'mensaje' => $data['text'],
      'usuario_id' => $data['usuario_id'],
      'telefono' => $data['msisdn'],
    );
    return $this->db->insert('sms', $newSms);
  }

  public function api_conn($url, $xml)
  {
    $response = $this->web_services->WSRequest($url, $xml);
    return $response;
  }

  public function cambiarEstado($orden, $usuario_id)
  {
    $update = array('estado' => $orden);
    return $this->db->update('usuario', $data, aray('id'=>$usuario_id));
  }

  /*
  public function getToken($data){
  $tran = $this->ultima_trans();
  //xml peticion token
  $req = '<?xml version="1.0" encoding="UTF-8"?>
  <request>
  <transaction>'.$tran.'</transaction>
  </request>';
  $url = "http://52.30.94.95/token";
  //return
  $responseToken = $this->ws->requestWS($url, $req);
  $xml = simplexml_load_string($responseToken) or die("Error: Cannot create object");
  $data['transaction'] = $tran;
  $data['tipo'] = 'ObtencionToken';
  $data['text'] = NULL;
  $data['txId'] = $xml->txId;
  $data['statusCode'] = $xml->statusCode;
  $data['statusMessage'] = $xml->statusMessage;
  $data['token'] = $xml->token;

  //insert
  $this->setWsComunication($data);

  //denana que fer segons STATUS_CODE
  $data = $this->switchResponse($data);
  return $data;
}*/
}
?>
