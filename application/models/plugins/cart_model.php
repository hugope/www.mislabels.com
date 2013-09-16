<?php
/**
 * Modelo para los carritos de compras
 */
class Cart_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->library('input');
		
		$this->set_table('PLUGIN_SHOPPING_CART');
	}
	
	/**
	 * Agregar un nuevo carro de compras
	 */
	 public function create_new_shopping_cart($stickersArray = array()){
	 	if(!empty($stickersArray)):
			//Insertamos un nuevo carrito de compras
			$data = array(
						'SHOPPING_SESSION' 			=> md5($this->input->ip_address()),
						'SHOPPING_CUSTOMERID'		=> $this->session->userdata('CUSTOMER_ID'),
						'SHOPPING_DATECREATED'		=> date('Y-m-d H:i:s'),
						'SHOPPING_STATUS'			=> 'SIN_PROCESAR',
						'SHOPPING_SHIPPINGDATE'		=> NULL,
						'SHOPPING_SHIPPINGADDRESS'	=> NULL,
						'SHOPPING_FINALPRICE'		=> NULL
					);
			$this->db->insert($this->_table, $data);
			$insertedId = $this->db->insert_id();
			
			//Añadir etiquetas al carro de compras
			return $this->add_cart_stickers($stickersArray, $insertedId);
		endif;
	 }
	 /**
	  * Añadir stickers al carro de compras
	  */
	 public function add_cart_stickers($stickersArray, $shopping_cart){
		foreach($stickersArray as $sticker):
			//Obtener ID del color
			
			$colorQuery = $this->db->select('ID')
			->from('PLUGIN_COLORS')
			->where('COLOR_LABEL', $sticker->STICKER_COLOR)->get();
			$stickerColor = $colorQuery->row();
			//Obtener ID del font
			$fontQuery = $this->db->select('ID')
			->from('PLUGIN_FONTS')
			->where('FONT_LABEL', $sticker->STICKER_FONT)->get();
			$stickerFont = $fontQuery->row();
			
			$data = array(
						'STICKER_TYPE'		=> $sticker->ID,
						'STICKER_COLOR'		=> $stickerColor->ID,
						'STICKER_FONT'		=> $stickerFont->ID,
						'STICKER_TEXT'		=> $sticker->STICKER_LABEL,
						'STICKER_QUANTITY'	=> $sticker->STICKER_QUANTITY,
						'STICKER_CART'		=> $shopping_cart
					);
			$inserted[] = ($this->db->insert('PLUGIN_SHOPPING_CART_STICKERS', $data))? TRUE: FALSE;
		endforeach;
		
		return (in_array(FALSE, $inserted))? FALSE: TRUE;
	 }
	 
	 /**
	  * Mostrar el carro de compras actual
	  */
	  public function get_shopping_cart($cartId = NULL){
	  	
	  	$this->db->from($this->_table);
	  	$this->db->where('SHOPPING_CUSTOMERID', $this->session->userdata('CUSTOMER_ID'));
		if($cartId != NULL){
		$this->db->where('ID', $cartId);}
		else{
		$this->db->where('SHOPPING_STATUS', 'SIN_PROCESAR');}
	  	$this->db->order_by('SHOPPING_DATECREATED DESC');
	  	$this->db->limit(1);
	  	$query = $this->db->get();
		
		return $query->row();
	  }
	  /**
	   * Devolver todas las stickersde un carro de compras
	   */
	   public function shopping_cart_stickers($cartId){
		$query = $this->db->from('PLUGIN_SHOPPING_CART_STICKERS')
		->where('STICKER_CART', $cartId)->get();
		
		//Obtener datos de c/ sticker
		$cartSticker->cartstickers = array();
		$totalsArray = array();
		foreach($query->result() as $i => $sticker){
			$sticker_data = $this->get_sticker_data($sticker->ID);
			
			$cartSticker->cartstickers[$i] = $sticker_data;
			$cartSticker->cartstickers[$i]->STICKER_TOTAL = ($sticker_data->STICKER_QUANTITY * $sticker_data->STICKER_PRICE);
			$totalsArray[] = $cartSticker->cartstickers[$i]->STICKER_TOTAL;
		}
		$cartSticker->cartTotal = array_sum($totalsArray);
		$stickers = (isset($cartSticker->cartTotal) > 0 && !empty($cartSticker->cartstickers))? $cartSticker: FALSE;
		
		return $stickers;
	   }
	  /**
	   * Obtener datos de una etiqueta
	   */
	  public function get_sticker_data($stickerId){
	  	$query = $this->db->select('PSCS.ID, PSC.ID AS CARTID, PS.STICKER_NAME, CP.LABEL, PSCS.STICKER_QUANTITY, PS.STICKER_PRICE')
		->from($this->_table.' PSC')
		->join('PLUGIN_SHOPPING_CART_STICKERS PSCS', 'PSCS.STICKER_CART = PSC.ID')
		->join('PLUGIN_STICKERS PS', 'PS.ID = PSCS.STICKER_TYPE')
		->join('CMS_PAGES CP', 'CP.ID = PS.STICKER_SET')
		->where('PSCS.ID', $stickerId)->get();
		
		return $query->row();
	  }
	  /**
	   * Eliminar etiqueta específica
	   */
	   public function delete_sticker($sticker){
		return $this->db->delete('PLUGIN_SHOPPING_CART_STICKERS', array('ID' => $sticker));
	   }
}
