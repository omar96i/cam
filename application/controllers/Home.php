<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index()	{
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='administrador') {
			redirect('admin/Home');
		}
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='empleado') {
			redirect('empleado/Home');
		}
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='supervisor') {
			redirect('supervisor/Home');
		}
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='talento humano') {
			redirect('talento_humano/Home');
		}
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='tecnico sistemas') {
			redirect('tecnico_sistemas/Home');
		}
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='fotografo') {
			redirect('fotografo/Home');
		}
		if(isset($_SESSION['usuario']) && $this->session->userdata('usuario')["tipo"]=='psicologa') {
			redirect('psicologa/Home');
		}
		$this->load->view('login');
		$data['footer'] = 'fixed-bottom';
		$this->load->view('includes/footer' , $data);
	}
}
