<?php 
class Myprofile_model extends MY_Model{
					
	function __construct() {
		parent::__construct();
		$this->set_table("PLUGIN_CUSTOMERS");
	}
	
	/**
	 * Desplegar botones del menú
	 */
	 public function myprofile_menu($current = 'index'){
	 	$current = ($current == '' || empty($current))?'index':$current;
		
		$query = $this->db->select('ID, LABEL, CLASS')
		->from('FRAMEWORK_PAGES')
		->where('PAGE_PARENT', '14')->get();
		$btns = $query->result();
		
		foreach($btns as $i => $btn):
			$btns[$i]->ACTIVE = ($btn->CLASS == $current)?'active':'';
		endforeach;
		
		return $btns;
		
	 }
	 
	 /**
	  * Desplegar pedidos incompletos
	  * @param $customerId Id del usuario
	  * @param $status Status de las ordenes a obtener
	  * @param $limit Número total de órdenes a obtener, si no se establece se desplegarán todas.
	  */
	  public function display_order_by_status($customerId, $status = 'EN_PROCESO', $limit = NULL){
	  	$query = $this->db->select("ID, SHOPPING_SESSION, SHOPPING_DATECREATED, SHOPPING_STATUS, SHOPPING_SHIPPINGDATE, SHOPPING_SHIPPINGADDRESS, SHOPPING_FINALPRICE, SHOPPING_RECEIVER, SHOPPING_CUSTOMER_BILLINGNAME, SHOPPING_CUSTOMER_BILLINGTIN, SHOPPING_CUSTOMER_BILLINGLOCATION, CONCAT('OPL', '-', LPAD(ID,4,'0')) AS SHOPPING_CODE", false)
	  	->from('PLUGIN_SHOPPING_CART')
		->where('SHOPPING_CUSTOMERID', $customerId);
		$query = ($status == 'EN_PROCESO')?$query->where('SHOPPING_STATUS', $status):$query->where("SHOPPING_STATUS != 'EN_PROCESO'");
		$query = ($limit > 0)?$query->limit($limit):$query;
		
		$query = $query->get();
		
		return $query->result();
	  }
	  
	  /**
	   * Obtener datos según correo
	   * @param $email Correo electrónico registrado a la cuenta por obtener datos.
	   */
	   public function get_profile_data($email){
	   	$query = $this->db->from('PLUGIN_CUSTOMERS')
		->where('CUSTOMER_EMAIL', $email)->get();
		
		return $query->row();
	   }
}