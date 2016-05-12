<?php
/**
*
*/
class Registrod extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url_helper');
    $this->load->model('Registros_model');
    $this->load->model('Clientes_model');
  }

  public function altas_bajas()
  {
    $data['altas_bajas'] = $this->registros_model->altas_bajas();

    if (empty($data['altas_bajas'])) {
      show_404();
    }

    $this->load->view('templates/header');
    $this->load->library('registros/altas_bajas');
    $this->load->library('templates/footer');
  }

  public function cobros()
  {
    $data['cobros'] = $this->registros_model->cobros();

    if (empty($data['cobros'])) {
      show_404();
    }

    $this->load->view('templates/header');
    $this->load->library('registros/cobros');
    $this->load->library('templates/footer');
  }

  public function sms()
  {
    $data['sms'] = $this->registros_model->sms();

    if (empty($data['sms'])) {
      show_404();
    }

    $this->load->view('templates/header');
    $this->load->library('registros/sms');
    $this->load->library('templates/footer');
  }
  public function web_service()
  {
    $data['web_service'] = $this->registros_model->web_service();

    if (empty($data['web_service'])) {
      show_404();
    }

    $this->load->view('templates/header');
    $this->load->library('registros/web_service');
    $this->load->library('templates/footer');
  }


}



?>
