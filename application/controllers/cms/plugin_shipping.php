<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_users
 * @since	mayo 2013
 * 
 */
class Plugin_shipping extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_SHIPPING_ADDRESS';
		$this->plugin_button_create			= "Crear Nueva";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Direcciones";
		$this->plugin_page_create			= "Crear Nueva Direcci&oacute;n";
		$this->plugin_page_read				= "Mostrar Direcci&oacute;n";
		$this->plugin_page_update			= "Editar Direcci&oacute;n";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "T&iacute;tulo";
		$this->plugin_display_array[2]		= "Direcci&oacute;n";
		$this->plugin_display_array[3]		= "Datos de localidad";
		$this->plugin_display_array[4]		= "Tel&eacute;fono";
		$this->plugin_display_array[5]		= "Mapa";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= FALSE; //Mostrar paginación en listado
		$this->pagination_per_page			= 0; //Numero de registros por página
		$this->pagination_total_rows		= 0; //Número total de items a desplegar
		
		$this->display_filter				= FALSE; //Mostrar filtro de búsqueda 'SEARCH' o según listado 'LIST' o no mostrar FALSE
		
		//Obtener el profiler del plugin
		$this->output->enable_profiler(FALSE);
	}
	
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Función para desplegar listado, desde aquí se puede modificar el query
	public function _plugin_display(){
		$result_array = array();
		$result_array = $this->plugins_model->list_rows('*', "SHIPPING_TYPE = 'PICKUP'");
		
		return $this->_html_plugin_display($result_array);
	}
	
	/**
	 * Función para desplegar listado completo de datos guardados, enviar los títulos en array con clave header y el cuerpo en un array con clave body.
	 * Para editar fila es a la función 'update_table_row'
	 * 
	 * @param	$result_array 		array 		Array con la listado devuelto por query de la DB
	 * @return	$data_array 		array 		Arreglo con la información del header y body
	 */
	public function _html_plugin_display($result_array){
		
		//Header data
		$data_array['header'][1]			= $this->plugin_display_array[1];
		$data_array['header'][2]			= $this->plugin_display_array[2];
		$data_array['header'][4]			= $this->plugin_display_array[4];
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field->ID).'">'.$field->SHIPPING_TITLE.'</a></td>';
		$data_array['body']					.= '<td>'.word_limiter($field->SHIPPING_ADDRESS, 5).'</td>';
		$data_array['body']					.= '<td>'.$field->SHIPPING_TEL.'</td>';
		$data_array['body']					.= '</tr>';
		endforeach;
		
		return $data_array;
	}
	
	/*
	 * Función para crear nuevo contenido, desde aquí se especifican los campos a enviar en el formulario.
	 * El formulario se envía mediante objectos preestablecidos de codeigniter. 
	 * El formulario se envía con un array con la clave form_html.
	 * Se puede encontrar una guía en: http://ellislab.com/codeigniter/user-guide/helpers/form_helper.html
	 */
	public function _html_plugin_create(){
        
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'SHIPPING_TITLE', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'SHIPPING_ADDRESS', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'SHIPPING_LOCATION', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'SHIPPING_TEL', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[5],'',array('class' => 'control-label'))."<div class='controls input-append'>".form_input(array('name' => 'SHIPPING_MAP', 'class' => 'span6 location-picker'))."<span class='help-block'>Utilizar el mapa para obtener la localidad.</span></div></div>";
		
		$data_array['extra_form']			= "<script>
													$(document).on('ready', function(){
														$('.location-picker').locationPicker();												
													});
												</script>";
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'SHIPPING_TITLE', 'value' => $result_data->SHIPPING_TITLE, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'SHIPPING_ADDRESS', 'value' => $result_data->SHIPPING_ADDRESS, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'SHIPPING_LOCATION', 'value' => $result_data->SHIPPING_LOCATION, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'SHIPPING_TEL', 'value' => $result_data->SHIPPING_TEL, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[5],'',array('class' => 'control-label'))."<div class='controls'><div class='mapcontainer input-append'>".form_input(array('name' => 'SHIPPING_MAP', 'value' => $result_data->SHIPPING_MAP, 'class' => 'span6 location-picker'))."</div><span class='help-block'>Utilizar el mapa para obtener la localidad.</span></div></div>";
		
		$data_array['extra_form']			= "<script>
													$(document).on('ready', function(){
														$('.location-picker').locationPicker();												
													});
												</script>";
		return $data_array;
	}
	
	//Funciones de los posts a enviar
	public function post_new_val(){
		$submit_posts 					= $this->input->post();
		$submit_posts['SHIPPING_TYPE']	= 'PICKUP'; 
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 				= $this->input->post();
		
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones específicas del plugin
	 */
}
