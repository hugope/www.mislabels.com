<?php
/**
 * Modelo para edici�n del perfil
 */
class Cms_panel_perfil extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->set_table("FRAMEWORK_USERS");
	}
}
