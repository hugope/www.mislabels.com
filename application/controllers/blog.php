<?php
/**
 * 
 */
class Blog extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index(){
		//
		
		$this->load->template('blog');
	}
}