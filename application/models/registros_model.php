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

  public function altas_bajas();
  {
    $query = $this->db->get('altas_bajas');
    return $query->result_array();
  }

  public function cobros();
  {
    $query = $this->db->get('cobros');
    return $query->result_array();
  }


  public function sms();
  {
    $query = $this->db->get('sms');
    return $query->result_array();
  }

  public function web_service();
  {
    $query = $this->db->get('web_service');
    return $query->result_array();
  }

  public function ultima_trans();
  {
      $sql = "SELECT max(id) from web_service"
      $query = $this->db->query($sql);
      return $query;
  }
}
?>
