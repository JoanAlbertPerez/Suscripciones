<?php
/**
*
*/
class Registros_model extends CI_Model
{

  function __construct()
  {
    $this->load->database();
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

  public function set_token($code, $msg, $tx_id, $token, $usuario_id, $trans)
  {
    $data  = array(
      'tipo' => 'pet_token',
      'stat_CODE' =>  $code,
      'stat_msg' => $msg,
      'tx_id' => $tx_id,
      'token' => $token,
      'usuario_id' => $usuario_id,
      'transaction' => $trans
    );
    return $this->db->insert('web_service', $data);
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
