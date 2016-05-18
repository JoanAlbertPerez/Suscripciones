<?php
/**
*
*/
class Registros extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper('url_helper');
    $this->load->model('registros_model');
    $this->load->model('clientes_model');
  }

  public function altas_bajas()
  {
    $data['altas_bajas'] = $this->registros_model->altas_bajas();

    if (empty($data['altas_bajas'])) {
      show_404();
    }

    if ($this->session->userdata('logueado')) {
      $this->load->view('templates/header');
      $this->load->view('registro/altas_bajas', $data);
      $this->load->view('templates/footer');
    }else {
      redirect('usuarios/iniciar_sesion');
    }

  }

  public function cobros()
  {
    $data['cobros'] = $this->registros_model->cobros();

    if (empty($data['cobros'])) {
      show_404();
    }
    if ($this->session->userdata('logueado')) {
      $this->load->view('templates/header');
      $this->load->view('registro/cobros', $data);
      $this->load->view('templates/footer');
    }else {
      redirect('usuarios/iniciar_sesion');
    }
  }

  public function sms()
  {
    $data['sms'] = $this->registros_model->sms();

    if (empty($data['sms'])) {
      show_404();
    }
    if ($this->session->userdata('logueado')) {
      $this->load->view('templates/header');
      $this->load->view('registro/sms', $data);
      $this->load->view('templates/footer');
    }else {
      redirect('usuarios/iniciar_sesion');
    }
  }
  public function web_service()
  {
    $data['web_service'] = $this->registros_model->web_service();

    if (empty($data['web_service'])) {
      show_404();
    }
    if ($this->session->userdata('logueado')) {
      $this->load->view('templates/header');
      $this->load->view('registro/web_service', $data);
      $this->load->view('templates/footer');
    }else {
      redirect('usuarios/iniciar_sesion');
    }
  }


}



?>
