<?php
/**
 * 
 */
class Nosotros extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('plugins/shipping_model', 'shipping_model');
	}
	
	public function index(){
			
		//Localidades
		$data['locations'] = $this->shipping_model->display_pickup_locations();
		
		$this->load->template('nosotros', $data);
	}
}
