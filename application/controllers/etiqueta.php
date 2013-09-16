<?php
/**
 * Sticker builder
 */
class Etiqueta extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		//Habilitar el profiler
		$this->output->enable_profiler(FALSE);
	}
	
	/**
	 * Sticker buidler
	 */
	 public function index(){
		
	 	$this->load->template('etiqueta');
	 }
}
