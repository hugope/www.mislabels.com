<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Clase que administra los contenidos editables
 */
class FW_content {
	
	var $FW;
	var $page;
	function __construct() {
		$this->FW			=& get_instance();
		$this->page			= get_class($this->FW); //pagina actual
		
		$this->FW->load->model('cms/cms_content_model', 'content_model');
	}
	
	//Obtener informaci�n del post
	public function single_post($post_key = NULL, $title = FALSE){
//		$page			= $this->_get_post_page();
		$post_content	= $this->FW->content_model->post_content($post_key);
		$return_val		= ($title == FALSE)? $post_content->POST_DETAIL: $post_content->POST_TITLE;
		
		return $return_val;
	}
	//Obtener titulo del post
	public function single_title($post_key = NULL){
		return $this->single_post($post_key, TRUE);
	}
	//Obtener imagen a desplegar
	public function imgsrc($img_file){
		$this->FW->load->model('cms/cms_plugin_images_model','images_model');
		$img_route			= $this->FW->images_model->display_image_route();
		$imgsrc				= base_url($img_route.$img_file);
		
		return $imgsrc;
	}
	
	//Obtener ID de la p�gina actual
	private function _get_post_page(){
		return $this->FW->content_model->post_page_number($this->page);
	}
}