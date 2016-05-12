<?php
class Usuarios_model extends CI_Model{
  function __construct()
  {
    $this->load->database();
  }

  /*Sacar información de la bbdd (parte usuarios)*/
  public function login($user, $pass)
  {
    $this->db->select('id, nombre');
    $this->db->from('admin');
    $this->db->where('nombre', $user);
    $this->db->where('password', md5($pass));
    $consulta = $this->db->get();
    $result = $consulta->row();
    return $result;
  }
}


?>
