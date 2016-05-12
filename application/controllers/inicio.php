<?php

if (!defined('BASEPATH'))
exit('No derect script access allowed');
/**
*
*/
class Inicio extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url_helper');
    $this->load->model('usuarios_model');
  }
  public function index(){
    if($this->session->userdata('logueado')){
      redirect('Clientes/datatable');
    }else {
      redirect('Usuarios/iniciar_sesion');
    }
  }
}

?>
