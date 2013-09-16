<?php
/**
 * @author 	Guido A. Orellana
 * @name	Panel Usuarios
 * @since	junio 2013
 * 
 */
class Panel_usuarios extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the plugin data
		$this->plugin_action_table			= 'FRAMEWORK_USERS';
		$this->plugin_button_create			= "Crear Nuevo Usuario Administrativo";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Usuarios Administrativos";
		$this->plugin_page_create			= "Crear Nuevo Usuario Administrativo";
		$this->plugin_page_read				= "Mostrar Usuario Administrativo";
		$this->plugin_page_update			= "Editar Usuario Administrativo";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->template_display				= "plugin_display"; //Si no se describe, se pone como default "plugin_display"
		
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Nombre de usuario";
		$this->plugin_display_array[2]		= "Correo Electr&oacute;nico";
		$this->plugin_display_array[3]		= "Contrase&ntilde;a";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= FALSE; //Mostrar paginaci�n en listado
		$this->pagination_per_page			= 0; //Numero de registros por p�gina
		$this->pagination_total_rows		= 0; //N�mero total de items a desplegar
		
		$this->display_filter				= FALSE; //Mostrar filtro de b�squeda 'SEARCH' o seg�n listado 'LIST' o no mostrar FALSE
		
		//Obtener el profiler del plugin
		$this->output->enable_profiler(FALSE);
	}
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Funci�n para desplegar listado, desde aqu� se puede modificar el query
	public function _plugin_display($filterArray){
		$result_array = array();
		$result_array = $this->plugins_model->list_rows('', "username != 'admin'");
		
		return $this->_html_plugin_display($result_array);
	}
	
	/**
	 * Funci�n para desplegar listado completo de datos guardados, enviar los t�tulos en array con clave header y el cuerpo en un array con clave body.
	 * Para editar fila es a la funci�n 'update_table_row'
	 * 
	 * @param	$result_array 		array 		Array con la listado devuelto por query de la DB
	 * @return	$data_array 		array 		Arreglo con la informaci�n del header y body
	 */
	public function _html_plugin_display($result_array){
		
		//Header data
		$data_array['header'][1]			= $this->plugin_display_array[1];
		$data_array['header'][2]			= $this->plugin_display_array[2];
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field->ID).'">'.$field->USERNAME.'</a></td>';
		$data_array['body']					.= '<td>'.$field->EMAIL.'</td>';
		$data_array['body']					.= '</tr>';
		endforeach;
		
		return $data_array;
	}
	
	/*
	 * Funci�n para crear nuevo contenido, desde aqu� se especifican los campos a enviar en el formulario.
	 * El formulario se env�a mediante objectos preestablecidos de codeigniter. 
	 * El formulario se env�a con un array con la clave form_html.
	 * Se puede encontrar una gu�a en: http://ellislab.com/codeigniter/user-guide/helpers/form_helper.html
	 */
	public function _html_plugin_create(){
        
		//Formulario
		$data_array['form_html']			=  "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'USERNAME', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'EMAIL', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_password(array('name' => 'PASSWORD', 'class' => 'span6'))."</div></div>";
		
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		//Formulario
		$data_array['form_html']			=  "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'USERNAME', 'value' => $result_data->USERNAME, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'EMAIL', 'value' => $result_data->EMAIL, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_password(array('name' => 'UPDATED_PASSWORD', 'class' => 'span6'))."</div></div>";
		
		return $data_array;
	}
	
	//Funciones de los posts a enviar
	public function post_new_val(){
		$submit_posts 					= $this->input->post();
		$submit_posts['PASSWORD']		= md5($submit_posts['PASSWORD']);
		$submit_posts['ACCESS_LEVEL']	= '999';
		$submit_posts['USER_DATEADDED']	= date('Y-m-d');
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 					= $this->input->post();
		$submit_posts['ID']				= $data_id;
		if($submit_posts['UPDATED_PASSWORD'] != ''):
		$submit_posts['PASSWORD']		= md5($submit_posts['UPDATED_PASSWORD']);
		endif;
		unset($submit_posts['UPDATED_PASSWORD']);
		$submit_posts['ACCESS_LEVEL']	= '999';
		$submit_posts['USER_DATEADDED']	= date('Y-m-d');
		
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones espec�ficas del plugin
	 */
}
