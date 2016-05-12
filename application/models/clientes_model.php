<?php
class Clientes_model extends CI_Model{
  function __construct()
  {
    $this->load->database();
  }

  public function listar()
  {
      $query = $this->db->get('usuario');
      return $query->result_array();
  }

  public function ver_cliente($id)
  {
      $sql = 'SELECT * FROM cliente where id=$id';
      $query = $this->db->query($sql);
      echo $query;
  }
}
