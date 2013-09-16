<?php
class Cms_plugin_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
		$this->load->library('upload');
    }
    public function initialise($current_table)
    {
        $this->_table = $current_table;
    }
    
    public function display_result(){
        $query = $this->db->get($this->_table);
        
        return $query->result();
    }
	
	/**
	 * Plugin categorías
	 */
	 public function categorization_array($offset = 0, $limit = 10, $display_all = TRUE){
	 	$result_array = array();
	 	$this->db->from($this->_table);
		$this->db->where('CATEGORY_PARENT','-1');
		if($display_all != TRUE):
		$this->db->limit($limit, $offset);
		endif;
		$query = $this->db->get();
		$parent_cats = $query->result();
		
		//Colocar categoría con subcategoría
		foreach($parent_cats as $i => $parent):
			$result_array[$i]['CATEGORY'] = $parent;
			//Obtener las subcategorías de cada categoría
			$this->db->from($this->_table);
			$this->db->where('CATEGORY_PARENT', $parent->ID);
			$query = $this->db->get();
			$result_array[$i]['SUBCATEGORIES'] = $query->result();
		endforeach;
		
		return $result_array;
	 }
	 
	 /**
	  * Plugin Email
	  */
	  public function update_email_data($update_array){
	  	//Actualizar cada dato en el framework resource
	  	foreach($update_array as $label => $value):
			$data['RESOURCE_DETAIL'] = $value;
			$this->db->where('RESOURCE_LABEL', $label);
			$result[] = $this->db->update('FRAMEWORK_RESOURCE', $data);
		endforeach;
		$message_key = (in_array(FALSE, $result))?4011:4010;
		return $message_key;
	  }
	  
	  /**
	   * Plugin Stickers
	   */
	   public function get_categories_array(){
	   	$this->db->from('PLUGIN_CATEGORIES');
		$query = $this->db->get();
		
		return $query->result();
	   }
	   public function get_set_name($set_id){
	   	$this->db->select('ID, LABEL');
		$this->db->from('CMS_PAGES');
		$this->db->where('PAGE_PARENT', '11');
		$this->db->where('ID', $set_id);
		$query = $this->db->get();
		$set_data = $query->row();
		
		return $set_data->LABEL;
	   }
	   /**
	    * Plugin Orders
	    */
	    public function get_single_order($orderID){
	    	$this->db->select('PSC.ID, PSC.SHOPPING_SESSION, CONCAT(PC.CUSTOMER_NAME, \' \', PC.CUSTOMER_LASTNAME) as CUSTOMER_NAME, PSC.SHOPPING_CUSTOMERID, PSC.SHOPPING_DATECREATED, PSC.SHOPPING_STATUS, PSC.SHOPPING_SHIPPINGDATE, CONCAT(PSA.SHIPPING_ADDRESS, \', \', PSA.SHIPPING_CITY) AS SHOPPING_SHIPPINGADDRESS, PSA.SHIPPING_TYPE, PC.CUSTOMER_EMAIL, PC.CUSTOMER_PHONE, PSC.SHOPPING_CUSTOMER_BILLINGNAME, PSC.SHOPPING_CUSTOMER_BILLINGTIN, PSC.SHOPPING_CUSTOMER_BILLINGLOCATION, PC.CUSTOMER_ADDRESS', FALSE);
	    	$this->db->from($this->_table.' AS `PSC`');
			$this->db->join('PLUGIN_CUSTOMERS PC', 'PC.ID = PSC.SHOPPING_CUSTOMERID');
			$this->db->join('PLUGIN_SHIPPING_ADDRESS PSA', 'PSA.ID = PSC.SHOPPING_SHIPPINGADDRESS');
			$this->db->where('PSC.ID', $orderID);
			$query = $this->db->get();
			$orderInfo = $query->row();
			
				
			//Get the order products
			$this->db->select('PS.ID, PS.STICKER_NAME, PC.CATEGORY_NAME, PS.STICKER_PRICE, PSCS.STICKER_QUANTITY, PSCS.STICKER_COLOR, PSCS.STICKER_TEXT, PSCS.STICKER_QUANTITY, PF.FONT_NAME');
			$this->db->from('PLUGIN_STICKERS PS');
			$this->db->join('PLUGIN_CATEGORIES PC', 'PC.ID = PS.STICKER_CATEGORY');
			$this->db->join('PLUGIN_SHOPPING_CART_STICKERS PSCS', 'PSCS.STICKER_TYPE = PS.ID');
			$this->db->join('PLUGIN_FONTS PF', 'PF.ID = PSCS.STICKER_FONT');
			$this->db->where('PSCS.STICKER_CART', $orderID);
			$query = $this->db->get();
			$sticker = $query->result();
			
			foreach($sticker as $sticker):
				$orderInfo->SHOPPING_CART[] = (object) array(
															'ID'				=> $sticker->ID,
															'STICKER_NAME' 		=> $sticker->STICKER_NAME,
															'STICKER_CATEGORY'	=> $sticker->CATEGORY_NAME,
															'STICKER_QUANTITY'	=> $sticker->STICKER_QUANTITY,
															'STICKER_PRICE'		=> $sticker->STICKER_PRICE,
															'FONT_NAME'			=> $sticker->FONT_NAME,
															'STICKER_TEXT'		=> json_decode($sticker->STICKER_TEXT),
															'STICKER_COLOR'		=> $sticker->STICKER_COLOR
															);
			endforeach;
			
			return $orderInfo;
	    }
		
		/**
		 * Librería posts
		 */
		 public function get_customer_user_info($orderID){
		 	$this->db->select('PC.ID, PC.CUSTOMER_NAME, PC.CUSTOMER_LASTNAME, PC.CUSTOMER_EMAIL', FALSE);
			$this->db->from('PLUGIN_SHOPPING_CART PSC');
			$this->db->join('PLUGIN_CUSTOMERS PC', 'PC.ID = PSC.SHOPPING_CUSTOMERID');
			$this->db->where('PSC.ID', $orderID);
			$query = $this->db->get();
			
			return $query->row();
		 }
		 /**
		  * Funciones de exportación
		  */
		  //Exportar órdenes
		  public function export_orders_data($filter){
		  	$query = $this->orders_query($filter);

			return $query->result();
		  }
		  //exportar usuarios
		  public function export_users_data($filter = 'COMPLETE'){
			$userGroup = $this->users_query($filter, TRUE)->get();
			$userQuery = $this->users_query($filter)->get();
			
			//Obtener los productos
			foreach($userQuery->result() as $userOrder){
				//Obtener todas las órdenes realizadas
				$stickersArray = json_decode($userOrder->SHOPPING_CART, true);
				foreach($stickersArray as $stickerID => $stickerQuan){
					//Obtener todos los productos
					$query = $this->db->select('STICKER_PRICE')
					->from('PLUGIN_STICKERS')
					->where('ID', $stickerID)
					->get();
					
					$singleSticker = $query->row();
					
					$stickerAmount[$userOrder->ID][] = ($singleSticker->STICKER_PRICE * $stickerQuan);
				}
				
			}
			
			$returnClass = array();
			//Asignar a cada cliente, el monto gastado en producto
			foreach($userGroup->result() as $customer){
				//Los gastos del cliente especifico
				$customerExpenses = array_sum($stickerAmount[$customer->ID]);
				
				//Asignamos los gastos al cliente
				$customer->CUSTOMER_TOTALEXPENSES = $customerExpenses;
				
				$returnClass[] = $customer;
			}
			
			return $returnClass;
		  }
		 //Exportar etiquetas
		 public function export_stickers_data($filter){
		 	//Obtener órdenes
		 	$orders = $this->orders_query($filter, TRUE)->result();
			
			$stickers = array();
			//Obtener stickers
			foreach($orders as $order):
				//Obtener los productos en un array
				$productsArray = json_decode($order->SHOPPING_CART, true);
				foreach($productsArray as $productID => $productQuant){
					//Obtener datos de cada sticker
					$query = $this->db->select('PS.ID, PS.STICKER_NAME, PC.CATEGORY_NAME')
					->from('PLUGIN_STICKERS PS')
					->join('PLUGIN_CATEGORIES PC', 'PC.ID = PS.STICKER_CATEGORY')
					->where('PS.ID', $productID)->get();
					$sticker = $query->row();
					$sticker->SHOPPING_CUSTOMER = $order->SHOPPING_CUSTOMER;
					$sticker->SHOPPING_DATE = $order->SHOPPING_DATECREATED;
					
					$stickers[] = $sticker;
				}
			endforeach;
			
			return $stickers;
		 }
		 //Función para desplegar query de órdenes
		 private function orders_query($filter, $stickers = FALSE){
		 	$selectArray = array(	"PSC.ID",
		 							"CONCAT(DATE_FORMAT(PSC.SHOPPING_DATECREATED, '%Y')",
		 							"DATE_FORMAT(PSC.SHOPPING_DATECREATED, '%m'),'-',PSC.ID) AS SHOPPING_CODE",
		 							"CONCAT(PC.CUSTOMER_NAME,' ',PC.CUSTOMER_LASTNAME) AS SHOPPING_CUSTOMER",
		 							"DATE_FORMAT(PSC.SHOPPING_DATECREATED, '%d/%m/%Y') AS SHOPPING_DATECREATED",
		 							"PSC.SHOPPING_STATUS"
									);
			if($stickers != FALSE){
			$selectArray[] = "PSC.SHOPPING_CART";
			}
			$select = implode(', ', $selectArray);
			
			//Create the query
		  	$query = $this->db->select($select, FALSE)
		  	->from('PLUGIN_SHOPPING_CART PSC')
			->join('PLUGIN_CUSTOMERS PC', 'PC.ID = PSC.SHOPPING_CUSTOMERID');
			if($filter != 'COMPLETE'):
			$datefilter = explode('-',$filter);
			$bdate = $datefilter[1].'-'.$datefilter[0].'-01';
			$edate = date("Y-m-t", strtotime($datefilter[1].'-'.$datefilter[0]));
			$query = $query->where("SHOPPING_DATECREATED BETWEEN '$bdate' AND '$edate'");
			endif;
			
			return $query->get();
		 }
		 
		  //Función para desplegar query usuarios
		 private function users_query($filter = 'COMPLETE', $gorup_by = FALSE){
		 	$selectArray = array(
		 						"PC.ID", 
		 						"CONCAT(PC.CUSTOMER_NAME, ' ', PC.CUSTOMER_LASTNAME) AS CUSTOMER_NAME",
		 						"PC.CUSTOMER_EMAIL",
		 						"DATE_FORMAT(PC.CUSTOMER_DATECREATED, '%d/%m/%Y') AS CUSTOMER_DATECREATED"
								);
			if($gorup_by != FALSE){
			$selectArray[] = "COUNT(1) AS CUSTOMER_ORDERS";
			}else{
			$selectArray[] = "PSC.SHOPPING_CART";
			}
			$select = implode(', ', $selectArray);
			
		 	$query = $this->db->select($select, FALSE)
			->from('PLUGIN_CUSTOMERS PC')
			->join('PLUGIN_SHOPPING_CART PSC', 'PC.ID = PSC.SHOPPING_CUSTOMERID', 'left')
			->where('CUSTOMER_ENABLED', 'YES');
			//Si se agrega filtro
			if($filter != 'COMPLETE'){
			$datefilter = explode('-',$filter);
			$bdate = $datefilter[1].'-'.$datefilter[0].'-01';
			$edate = date("Y-m-t", strtotime($datefilter[1].'-'.$datefilter[0]));
			$query = $query->where("PSC.SHOPPING_DATECREATED BETWEEN '$bdate' AND '$edate'");
			}
			//Si se debe agrupar
			if($gorup_by != FALSE){
			$query = $query->group_by('PC.ID');
			}
			
			return $query;
		 }
		 
		 //Obtener los datos de la orden
}