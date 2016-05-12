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
  }
  public function datatable()
  {
      $data['cliente'] = $this->clientes_model->listar();

      if (empty($data['cliente'])) {
        show_404();
      }

      $this->load->view('templates/header');
      $this->load->view('general/inicio', $data);
      $this->load->view('templates/footer');
  }

  public function sol_alta()
  {
    $id = $this->input->post('id');
    $client = $this->clientes_model->ver_cliente($id);
    //$tfn = $client['telefono'];

  }
}

 ?>
