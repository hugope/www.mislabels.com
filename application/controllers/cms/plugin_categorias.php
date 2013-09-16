<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_contenidos
 * @since	abril 2013
 * 
 */
class Plugin_categorias extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_CATEGORIES';
		$this->plugin_button_create			= "Crear Nueva Categoría";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Categorías";
		$this->plugin_page_create			= "Crear Nueva Categoría";
		$this->plugin_page_read				= "Mostrar Categoría";
		$this->plugin_page_update			= "Editar Categoría";
		$this->plugin_page_delete			= "Eliminar";
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "T&iacute;tulo";
		$this->plugin_display_array[2]		= "Color de Etiqueta";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= FALSE; //Mostrar paginación en listado
		$this->pagination_per_page			= 1; //Numero de registros por página
		$this->pagination_total_rows		= count($this->plugins_model->categorization_array()); //Número total de items a desplegar
		
		$this->display_filter				= FALSE; //Mostrar filtro de búsqueda 'SEARCH' o según listado 'LIST' o no mostrar FALSE
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
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field['CATEGORY']->ID).'">'.$field['CATEGORY']->CATEGORY_NAME.'</a></td>';
		$data_array['body']					.= '<td><div id="color_display" style="background-color:'.$field['CATEGORY']->CATEGORY_COLOR.';"></div></td>';
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
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CATEGORY_NAME', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CATEGORY_COLOR', 'class' => 'span6', 'id' => 'color', 'value' => '#ffffff'))."<span class='help-block'>Seleccionar color con el selector de colores.</span></div><div id='picker_container'><div id='picker'></div></div></div>";
		
		//Extra data
		$data_array['extra_form']			= "<script type='text/javascript'>
												$(document).ready(function() {
													$('#picker').farbtastic('#color');
													$('input#color').click(function(event){
														$('#picker').fadeIn(500);
														event.stopPropagation();
													});
													$('#content').click(function(){
														$('#picker').fadeOut(500);
													})
												});
												</script>";
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CATEGORY_NAME', 'value' => $result_data->CATEGORY_NAME, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CATEGORY_COLOR', 'class' => 'span6', 'id' => 'color', 'value' => $result_data->CATEGORY_COLOR))."<span class='help-block'>Seleccionar color con el selector de colores.</span></div><div id='picker_container'><div id='picker'></div></div></div>";
		
		//Extra data
		$data_array['extra_form']			= "<script type='text/javascript'>
												$(document).ready(function() {
													$('#picker').farbtastic('#color');
													$('input#color').click(function(event){
														$('#picker').fadeIn(500);
														event.stopPropagation();
													});
													$('#content').click(function(){
														$('#picker').fadeOut(500);
													})
												});
												</script>";
		
		return $data_array;
	}
	
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Función para desplegar listado, desde aquí se puede modificar el query
	public function _plugin_display($filter, $offset){
		$result_array = array();
		$result_array = $this->plugins_model->categorization_array($offset,$this->pagination_per_page, TRUE);
		
		return $this->_html_plugin_display($result_array);
	}
	//Funciones de los posts a enviar
	public function post_new_val(){
		$submit_posts 				= $this->input->post();
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 				= $this->input->post();
		$submit_posts['ID']			= $data_id;
		
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones específicas del plugin
	 */
}
