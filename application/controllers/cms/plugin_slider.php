<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_slider
 * @since	julio 2013
 * 
 */
class Plugin_slider extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library('upload');
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_SLIDER';
		$this->plugin_button_create			= "Crear Nueva";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Direcciones";
		$this->plugin_page_create			= "Crear Nueva Slide";
		$this->plugin_page_read				= "Mostrar Slide";
		$this->plugin_page_update			= "Editar Slide";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Imagen";
		$this->plugin_display_array[2]		= "Descripci&oacute;n";
		
		//Upload configuration
		$this->upload_config['upload_path']			= './user_files/uploads/';
		$this->upload_config['allowed_types']		= "gif|jpg|png";
		$this->upload_config['max_width']			= "680";
		$this->upload_config['max_height']			= "343";
		
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
		$result_array = $this->plugins_model->list_rows();
		
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
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><div style="background-image:url('.base_url($this->upload_config['upload_path'].'/'.$field->SLIDER_IMAGE).')" class="slider_thumbnail" ><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field->ID).'">#</a></div></td>';
		$data_array['body']					.= '<td>'.word_limiter($field->SLIDER_DESCRIPTION, 25).'</td>';
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
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_upload(array('name' => 'SLIDER_IMAGE', 'class' => 'span6'))."<span class='help-block'>Imagen 680 x 343px</span></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'SLIDER_DESCRIPTION', 'class' => 'span6'))."</div></div>";
		
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_upload(array('name' => 'SLIDER_IMAGE', 'class' => 'span6'))."<span class='help-block'>Imagen 680 x 343px</span></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'SLIDER_DESCRIPTION', 'class' => 'span6', 'value' => $result_data->SLIDER_DESCRIPTION))."</div></div>";
		
		return $data_array;
	}
	
	//Funciones de los posts a enviar
	public function post_new_val(){
		
		$submit_posts 					= $this->input->post();
		if(isset($_FILES['SLIDER_IMAGE'])){
			if($_FILES['SLIDER_IMAGE']['error'] < 1){
				$submit_posts['SLIDER_IMAGE']	= $this->upload_image('SLIDER_IMAGE');
			}
		}
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 				= $this->input->post();		
		if(isset($_FILES['SLIDER_IMAGE'])){
			if($_FILES['SLIDER_IMAGE']['error'] < 1){
				$submit_posts['SLIDER_IMAGE']	= $this->upload_image('SLIDER_IMAGE');
			}
		}

		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones específicas del plugin
	 */
	 private function upload_image($image_name){
	 	
		//Cargar imagen
		$this->upload->initialize($this->upload_config); //Definir la configuración del upload
		if($this->upload->do_upload($image_name)):
			$this->fw_alerts->add_new_alert(4001);
			//guardar en la base de datos
			$image_data						= $this->upload->data();
			$sticker_images					= $image_data['file_name'];
			return $sticker_images;
		else:
			$this->fw_alerts->add_new_alert(4002);
			return NULL;
		endif;
	 }
}
