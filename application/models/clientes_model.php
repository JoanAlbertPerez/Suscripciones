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
      //$sql = 'SELECT * FROM usuario where id=$id';
      $this->db->select('id, nombre, estado, telefono, ultimo_cobro');
      $this->db->from('usuario');
      $this->db->where('id', $id);
      $consulta = $this->db->get();
      $result = $consulta->row();
      return $result; 
      //$query = $this->db->query($sql);
      //echo $query;
  }
}
