<?php
/**
 * 
 */
class Contacto extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		//
		
		$this->load->template('contacto');
	}
}
