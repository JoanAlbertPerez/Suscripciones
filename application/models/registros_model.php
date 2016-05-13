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
}
?>
