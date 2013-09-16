<?php
/**
 * Modelo para información de entrega
 */
class Shipping_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->set_table('PLUGIN_SHIPPING_ADDRESS');
	}
	
	/**
	 * Enviar las localidades para pickup
	 * @param boolean $array Establece como true si el valor a devolver sea un array asociativo
	 */
	public function display_pickup_locations($array = FALSE){
		$this->db->where('SHIPPING_TYPE', 'PICKUP');
		$query = $this->db->get($this->_table);
		
		foreach($query->result() as $location):
			$locations_array[$location->ID] = $location->SHIPPING_TITLE; 
		endforeach;
		
		return ($array == TRUE)? $locations_array:$query->result();
	}
	/**
	 * Desplegar información de entrega
	 */
	 public function display_shipping_data($id){
	 	$query = $this->db->where('ID', $id)
		->get($this->_table);
		
		return $query->row();
	 }
	 /**
	  * Guardar nueva ubicación a enviar
	  */
	  public function add_shipping_address($cartid = NULL, $data){
	  	$this->db->where('ID', $cartid);
		return $this->db->update('PLUGIN_SHOPPING_CART', $data);
	  }
	  /**
	   * Desplegar informaci
	   */
	   
}
