<?php
/**
 * Configurar entrega
 */
class Miperfil extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('plugins/myprofile_model', 'myprofile_model');
		

		//Show profiler
		$this->output->enable_profiler(FALSE);
	}
	public function index(){
		//Desplegar menu
		$menudata['btns'] 		= $this->myprofile_model->myprofile_menu('index');
		$data['menu']			= $this->load->view('includes/profilemenu', $menudata, true);
		
		//Obtener datos del perfil
		$templatedata['perfil']	= $this->myprofile_model->get_single_row(array('COLUMN_VAR' => $this->session->userdata('CUSTOMER_ID')));
		
		//Obtener pedidos incompletos
		$templatedata['incomplete'] = $this->myprofile_model->display_order_by_status($this->session->userdata('CUSTOMER_ID'), 'EN_PROCESO', 5);
		
		//Obtener historial de pedidos
		$templatedata['historical'] = $this->myprofile_model->display_order_by_status($this->session->userdata('CUSTOMER_ID'), 'HISTORICOS', 5);
		
		$data['display']		= $this->load->view('miperfil_resumen', $templatedata, true);
		
		
		//Mostrar el view
		$this->load->template('miperfil', $data);
	}
	public function datos(){
		//Desplegar menu
		$menudata['btns'] 	= $this->myprofile_model->myprofile_menu('datos');
		$data['menu']		= $this->load->view('includes/profilemenu', $menudata, true);
		
		//Obtener datos del perfil
		$templatedata['perfil']		= $this->myprofile_model->get_single_row(array('COLUMN_VAR' => $this->session->userdata('CUSTOMER_ID')));
		$data['display']	= $this->load->view('miperfil_datos', $templatedata, true);
		
		if($this->input->post('PROFILE_SUBMIT')):
			//Editar el perfil
			if($this->form_validation->run('USER_INFO_EDIT') == FALSE):
					$this->fw_alerts->add_new_alert(6051);
			else:
				$updatedata = array(
								'CUSTOMER_NAME' 	=> $this->input->post('CUSTOMER_NAME'),
								'CUSTOMER_LASTNAME' => $this->input->post('CUSTOMER_LASTNAME'),
								'CUSTOMER_COUNTRY' 	=> $this->input->post('CUSTOMER_COUNTRY'),
								'CUSTOMER_ADDRESS' 	=> $this->input->post('CUSTOMER_ADDRESS')
								);
				$this->myprofile_model->update($updatedata, $this->session->userdata('CUSTOMER_ID'));
				$this->fw_alerts->add_new_alert(6050);
			endif;
		endif;
		if($this->input->post('PASSWORD_SUBMIT')):
			//Editar contraseña
			if($this->form_validation->run('USER_PASSWORD_EDIT') == FALSE):
					$this->fw_alerts->add_new_alert(6053);
			else:
				$updatedata = array(
								'CUSTOMER_PASSWORD' 	=> sha1($this->input->post('CUSTOMER_PASSWORD'))
								);
				$this->myprofile_model->update($updatedata, $this->session->userdata('CUSTOMER_ID'));
				$this->fw_alerts->add_new_alert(6052);
				
				redirect('login/out');
			endif;
		endif;
		
		//Mostrar el view
		$this->load->template('miperfil', $data);
	}
	public function incompletos(){
		//Desplegar menu
		$menudata['btns'] 	= $this->myprofile_model->myprofile_menu('incompletos');
		$data['menu']		= $this->load->view('includes/profilemenu', $menudata, true);
		
		//Obtener pedidos incompletos
		$templatedata['incomplete'] = $this->myprofile_model->display_order_by_status($this->session->userdata('CUSTOMER_ID'), 'EN_PROCESO');
		$data['display']	= $this->load->view('miperfil_incompletos', $templatedata, true);
		
		//Mostrar el view
		$this->load->template('miperfil', $data);
	}
	public function historial(){
		//Desplegar menu
		$menudata['btns'] 	= $this->myprofile_model->myprofile_menu('historial');
		$data['menu']		= $this->load->view('includes/profilemenu', $menudata, true);
		
		//Obtener pedidos incompletos
		$templatedata['historical'] = $this->myprofile_model->display_order_by_status($this->session->userdata('CUSTOMER_ID'), 'HISTORICOS');
		$data['display']	= $this->load->view('miperfil_historial', $templatedata, true);
		
		//Mostrar el view
		$this->load->template('miperfil', $data);
	}
}