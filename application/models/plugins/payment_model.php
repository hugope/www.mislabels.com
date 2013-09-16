<?php
/**
 * Modelo del módulo de pagos
 */
class Payment_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->set_table('PLUGIN_PAYMENT');
	}
}
