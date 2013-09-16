<?php
/**
 * Modelo del slider
 */
class Slider_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function display_slider(){
		$query = $this->db->from('PLUGIN_SLIDER')->get();
		
		return $query->result();
	}
}
