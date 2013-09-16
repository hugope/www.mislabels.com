<?php
/**
 * Modelo para el plugin de login
 */
class Login_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->set_table("PLUGIN_CUSTOMERS");
	}
	/**
	 * Verificar la existencia de un correo electrónico
	 */
	public function check_email_existence($email_entered){
		$query = $this->db->where('CUSTOMER_EMAIL', $email_entered)
		->from($this->_table)
		->count_all_results();
		
		return ($query > 0)?FALSE:TRUE;
	}
	
	/**
	 * Almacenar datos de usuarios
	 */
	 public function save_new_customer($new_customer){
	 	$this->db->insert($this->_table, $new_customer);
		
		return $this->db->insert_id();
	 }
	 /**
	  * Confirmar correo
	  */
	  public function email_confirmation($id, $confirmationcode){
	  	
		$query = $this->db->from($this->_table)
		->where('ID', $id)
		->where('CUSTOMER_CONFIRMATIONCODE', $confirmationcode)
		->count_all_results();
		
		$confirm = FALSE;
		if($query > 0):
			$data = array(
				'CUSTOMER_ENABLED'			=> 'YES',
				'CUSTOMER_CONFIRMATIONCODE'	=> md5('mislabelsdisabled') //Cambiar codigo de verificación para evitar que pueda volver a autenticarse
			);
			$this->db->where('ID', $id);
			$this->db->update($this->_table, $data); 
			$confirm = TRUE;
		endif;
		
		return $confirm;
	  }
	  /**
	   * Inicio de sesión
	   */
	   public function set_session_start($email, $password){
			$query = $this->db->from($this->_table)
			->where('CUSTOMER_EMAIL', $email)
			->where('CUSTOMER_PASSWORD', sha1($password))
			->get();
			
			$result = $query->row();
			
			return $result;
	   }
	   /**
	    * Crear nuevo carrito de compras
	    */
	    public function new_shopping_cart($cart_sticker){
	    	$this->load->model('plugins/cart_model', 'cart_model');
			
			//Añadir el sticker al carro de compra
			return $this->cart_model->create_new_shopping_cart($cart_sticker);
	    }
}
