<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_users
 * @since	mayo 2013
 * 
 */
class Plugin_users extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_CUSTOMERS';
		$this->plugin_button_create			= "Crear Nuevo Usuario";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Usuarios";
		$this->plugin_page_create			= "Crear Nuevo Usuario";
		$this->plugin_page_read				= "Mostrar Usuario";
		$this->plugin_page_update			= "Editar Usuario";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Nombre";
		$this->plugin_display_array[2]		= "Apellido";
		$this->plugin_display_array[3]		= "Email";
		$this->plugin_display_array[4]		= "Tel&eacute;fono";
		$this->plugin_display_array[5]		= "Direcci&oacute;n";
		$this->plugin_display_array[6]		= "Pa&iacute;s";
		$this->plugin_display_array[7]		= "Habilitado";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= FALSE; //Mostrar paginación en listado
		$this->pagination_per_page			= 20; //Numero de registros por página
		$this->pagination_total_rows		= 0; //Número total de items a desplegar
		
		$this->display_filter				= FALSE; //Mostrar filtro de búsqueda 'SEARCH' o según listado 'LIST' o no mostrar FALSE
	}
	
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Función para desplegar listado, desde aquí se puede modificar el query
	public function _plugin_display($filter, $offset){
		$result_array = array();
		$result_array = $this->plugins_model->list_rows('', '', $this->pagination_per_page, $offset);
		
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
		$data_array['header'][1]			= $this->plugin_display_array[1].' y '.$this->plugin_display_array[2];
		$data_array['header'][2]			= $this->plugin_display_array[3];
		$data_array['header'][3]			= $this->plugin_display_array[7];
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field->ID).'">'.$field->CUSTOMER_NAME.' '.$field->CUSTOMER_LASTNAME.'</a></td>';
		$data_array['body']					.= '<td>'.$field->CUSTOMER_EMAIL.'</td>';
		$data_array['body']					.= '<td>'.$field->CUSTOMER_ENABLED.'</td>';
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
        
		//Datos a enviar
		$world_countries_array = $this->fw_utilities->world_countries('sp');
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_NAME', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_LASTNAME', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_EMAIL', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_PHONE', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[5],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_ADDRESS', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[6],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('CUSTOMER_COUNTRY', $world_countries_array, 68)."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[7],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('CUSTOMER_ENABLED', array('YES' => 'Si', 'NO' => 'No'))."</div></div>";
		
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		//Datos a enviar
		$world_countries_array = $this->fw_utilities->world_countries('sp');
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_NAME', 'value' => $result_data->CUSTOMER_NAME, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_LASTNAME', 'value' => $result_data->CUSTOMER_LASTNAME,  'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_EMAIL', 'value' => $result_data->CUSTOMER_EMAIL,  'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_PHONE', 'value' => $result_data->CUSTOMER_PHONE,  'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[5],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CUSTOMER_ADDRESS', 'value' => $result_data->CUSTOMER_ADDRESS,  'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[6],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('CUSTOMER_COUNTRY', $world_countries_array, $result_data->CUSTOMER_COUNTRY)."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[7],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('CUSTOMER_ENABLED', array('YES' => 'Si', 'NO' => 'No'), $result_data->CUSTOMER_ENABLED)."</div></div>";
		
		return $data_array;
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
	 private function display_cateogries_array(){
	 	//Datos a enviar
		$options_values_array 				= array('-1' => 'Principal');
		$categories_object					= $this->plugins_model->list_rows('','CATEGORY_PARENT = -1');
		foreach($categories_object as $parent_cat):
			$options_values_array[$parent_cat->ID] = $parent_cat->CATEGORY_NAME;
		endforeach;
		
		return $options_values_array;
	 }
}
