<?php
/**
 * Función para enviar datos al header del FRONTEND
 */
 
 function data_array(){
 	$instance =& get_instance();
	
	//Load model
	$instance->load->model('plugins/header_model', 'header_model');
	$instance->load->model('plugins/etiquetas_model', 'etiquetas_model');
	$instance->load->library('router');
	
	//Get the menu buttons
	$menu = $instance->header_model->get_menu_pages();
	$data_array['current_page']	= $instance->router->fetch_class();
	$data_array['menu_btns']	= $menu;
	
	//Get the categories menu
	$data_array['first_cat']		= $instance->etiquetas_model->get_first_category();
	$data_array['categories_menu'] 	= $instance->etiquetas_model->categories_list();
	
	//
		
	
 	return $data_array;
 }
