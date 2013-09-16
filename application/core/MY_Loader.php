<?php
/**
 * Template that loads header and footer automatically
 */
class MY_Loader extends CI_Loader {
	
	
	public function template($template_name, $vars = array(), $return = FALSE)
    {
        parent::__construct();
        $instance =& get_instance();
		$instance->load->helper('layout');
		
		$data					= data_array();
		
		$content  = $instance->load->view('layout/header', $data, $return);
		$content .= $instance->load->view($template_name, $vars, $return);
		$content .= $instance->load->view('layout/footer', $data, $return);
		
		if ($return){
			return $content;
		}
	}
	

    public function templatecms($template_name, $vars = array(), $return = FALSE)
    {
        parent::__construct();
        
        $instance =& get_instance();
		
		$instance->load->model('cms/cms_header_model', 'header_model');
		$instance->load->helper('breadcrumb');
		
            //requerimientos del header
            $header['COLUMN_SELECT'] 			= 'RESOURCE_DETAIL';
            $header['COLUMN_GET'] 				= 'RESOURCE_LABEL';
            
            //obtener lenguaje
            $header['COLUMN_VAR'] 				= 'RESOURCE_THEME_LANGUAGE';
            $type 								= $instance->header_model->get_single_row($header);
            $data['RESOURCE_THEME_LANGUAGE'] 	= $type->RESOURCE_DETAIL;
            
            //obtener html TYPE
            $header['COLUMN_VAR'] 				= 'RESOURCE_THEME_HTMLTYPE';
            $type 								= $instance->header_model->get_single_row($header);
            $data['RESOURCE_THEME_HTMLTYPE'] 	= $type->RESOURCE_DETAIL;
            
            //obtener html TYPE
            $header['COLUMN_VAR'] 				= 'RESOURCE_THEME_CHARSET';
            $type 								= $instance->header_model->get_single_row($header);
            $data['RESOURCE_THEME_CHARSET'] 	= $type->RESOURCE_DETAIL;
            
            //Titulo de la p�gina
            $header['COLUMN_VAR'] 				= 'RESOURCE_WEBSITE_TITLE';
            $type 								= $instance->header_model->get_single_row($header);
            $RESOURCE_WEBSITE_TITLE 			= $type->RESOURCE_DETAIL;
            $ci = get_instance();
            $RESOURCE_PAGE_TITLE 				= get_class($ci);
            $data['engine_show_header_website'] = $RESOURCE_WEBSITE_TITLE;
            $data['engine_show_header_pagename']= $RESOURCE_PAGE_TITLE;
			
			//PAGINAS A MOSTRAR
			$data['CMS_PAGES_LIST']				= $instance->header_model->get_menu_pages($RESOURCE_PAGE_TITLE);
		
		$content  = $instance->load->view('cms/layout/header', $data, $return);
		$content .= $instance->load->view($template_name, $vars, $return);
		$content .= $instance->load->view('cms/layout/footer', $vars, $return);
		
		if ($return){
			return $content;
		}
	}
}
