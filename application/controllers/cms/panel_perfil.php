<?php
/**
 * Edici�n de perfil
 */
class Panel_perfil extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('cms/cms_panel_perfil','plugin_model');
	}
	
	public function index(){
		$data['user_email']			= $this->session->userdata('EMAIL');
		$data['user_name']			= $this->session->userdata('USERNAME');
		
		$this->load->templatecms('cms/panel_editar_perfil', $data);
	}
	public function editar(){
		
		$requestArray = $this->input->post();
		$requestArray['PASSWORD'] = ($requestArray['PASSWORD']!='')?md5($requestArray['PASSWORD']):'';
		
		//Remove empty values
		foreach($requestArray as $key => $value):
			if($value == ''):
				unset($requestArray[$key]);
			endif;
		endforeach;
		
		$this->plugin_model->update($requestArray, $this->session->userdata('ID'));
		
		$this->fw_alerts->add_new_alert(2001);
		redirect('cms/panel_login/logoff');
	}
}
