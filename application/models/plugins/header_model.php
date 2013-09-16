<?php 
class Header_model extends MY_Model{
					
	function __construct() {
		parent::__construct();
		$this->set_table("FRAMEWORK_RESOURCE");
	}
	
	public function get_menu_pages(){
		//Select the pages
		$this->db->from('FRAMEWORK_PAGES');
		$this->db->where('PAGE_PARENT <', 0);
		$query = $this->db->get();
		
		$parents = $query->result();
		
		return $parents;
	}
	
	public function get_categories_array(){
		
	 	$this->db->from('PLUGIN_CATEGORIES');
		$this->db->where('CATEGORY_PARENT','-1');
		$query = $this->db->get();
		$categories = $query->result();
		
		foreach($categories as $i => $cat):
			$categories[$i]->CATEGORY_SEGMENT = strtolower(convert_accented_characters($cat->CATEGORY_NAME));
		endforeach;
		
		return $categories;
	}
	
}