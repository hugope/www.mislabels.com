<?php
/**
 * Modelo para el proceso de compra
 */
class Buying_process_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->set_table('PLUGIN_SHOPPING_CART');
	}
	
	public function wizard_menu($active){
		$query = $this->db->select('ID, LABEL, CLASS')
		->from('FRAMEWORK_PAGES')
		->where('PAGE_PARENT', 8)->get();
		$stages = $query->result();
		foreach($stages as $i =>$stage){
			$stages[$i]->ACTIVE = ($stage->CLASS == $active)? 'active': '';
			$stages[$i]->CLASS = strtolower($stage->CLASS);
		}
		return $stages;
	}
}
