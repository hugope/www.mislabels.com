<?php
/**
 * Modelo para informaci�n de facturaci�n
 */
class Summary_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->set_table('PLUGIN_SHOPPING_CART');
	}
}