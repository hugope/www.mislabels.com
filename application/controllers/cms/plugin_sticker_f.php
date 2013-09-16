<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_sticker_a
 * @since	mayo 2013
 * 
 */
class Plugin_sticker_f extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Sticker set
		$this->sticker_set							= "17";
		$this->set_name								= $this->plugins_model->get_set_name($this->sticker_set);
		
		//Load the plugin data
		$this->plugin_action_table					= 'PLUGIN_STICKERS';
		$this->plugin_button_create					= "Crear Nueva Etiqueta";
		$this->plugin_button_cancel					= "Cancelar";
		$this->plugin_button_update					= "Guardar Cambios";
		$this->plugin_button_delete					= "Eliminar";
		$this->plugin_page_title					= "Etiquetas ($this->set_name)";
		$this->plugin_page_create					= "Crear Nueva Etiqueta";
		$this->plugin_page_read						= "Mostrar Etiqueta";
		$this->plugin_page_update					= "Editar Etiqueta";
		$this->plugin_page_delete					= "Eliminar";
		
		$this->plugin_display_array[0]				= "ID";
		$this->plugin_display_array[1]				= "Set";
		$this->plugin_display_array[2]				= "T&iacute;tulo";
		$this->plugin_display_array[3]				= "Categor&iacute;a";
		$this->plugin_display_array[4]				= "Imagen de m&aacute;scara";
		$this->plugin_display_array[5]				= "Precio";
		$this->plugin_display_array[6]				= "Galer&iacute;a";
		$this->plugin_display_array[7]				= "Descripci&oacute;n";
		$this->plugin_display_array[8]				= "&#191;Agregar a populares?";
		
		//Upload configuration
		$this->upload_config['upload_path']			= './user_files/uploads/';
		$this->upload_config['allowed_types']		= "gif|jpg|png";
		
		
		$this->plugins_model->initialise($this->plugin_action_table);
		$this->load->helper('array');
		
		//Extras to send
		$this->display_pagination					= TRUE; //Mostrar paginación en listado
		$this->pagination_per_page					= 10; //Numero de registros por página
		$this->pagination_total_rows				= $this->plugins_model->total_rows("STICKER_SET = ".$this->sticker_set); //Número total de items a desplegar
		
		$this->display_filter						= FALSE; //Mostrar filtro de búsqueda 'SEARCH' o según listado 'LIST' o no mostrar FALSE
	}
	
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Función para desplegar listado, desde aquí se puede modificar el query
	public function _plugin_display($filter, $offset){
		$result_array = array();
		$result_array = $this->plugins_model->list_rows('*', "STICKER_SET = ".$this->sticker_set, $this->pagination_per_page, $offset);
		
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
		$data_array['header'][1]			= $this->plugin_display_array[2];
		$data_array['header'][2]			= $this->plugin_display_array[3];
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field->ID).'">'.$field->STICKER_NAME.'</a></td>';
		$data_array['body']					.= '<td>'.element($field->STICKER_CATEGORY, $this->categories_array(), NULL).'</td>';
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
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'><strong>$this->set_name</strong></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'STICKER_NAME', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[5],'',array('class' => 'control-label'))."<div class='controls'><div class='input-prepend'><span class='add-on'>Q.</span>".form_input(array('name' => 'STICKER_PRICE', 'class' => 'span2'))."</div></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('STICKER_CATEGORY', $this->categories_array())."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_upload(array('name' => 'STICKER_IMAGE', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[7],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'STICKER_DESCRIPTION', 'class' =>'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[8],'',array('class' => 'control-label'))."<div class='controls'><label class='checkbox'>".form_checkbox('STICKER_POPULAR', 'SI')."Seleccionar para que aparezca esta etiqueta en la pagina de inicio.</label></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[6],'',array('class' => 'control-label'))."<div class='controls'>".form_uploader(site_url('cms/plugin_uploader/'))."</div></div>";
		
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		$selected = ($result_data->STICKER_POPULAR == 'SI')? TRUE:FALSE;
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'><strong>$this->set_name</strong></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'STICKER_NAME', 'value' => $result_data->STICKER_NAME, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[5],'',array('class' => 'control-label'))."<div class='controls'><div class='input-prepend'><span class='add-on'>Q.</span>".form_input(array('name' => 'STICKER_PRICE', 'value' => $result_data->STICKER_PRICE, 'class' => 'span2'))."</div></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('STICKER_CATEGORY', $this->categories_array(), $result_data->STICKER_CATEGORY)."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_upload(array('name' => 'STICKER_IMAGE', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[7],'',array('class' => 'control-label'))."<div class='controls'>".form_textarea(array('name' => 'STICKER_DESCRIPTION', 'value' => $result_data->STICKER_DESCRIPTION, 'class' =>'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[8],'',array('class' => 'control-label'))."<div class='controls'><label class='checkbox'>".form_checkbox('STICKER_POPULAR', 'SI', $selected)."Seleccionar para que aparezca esta etiqueta en la pagina de inicio.</label></div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[6],'',array('class' => 'control-label'))."<div class='controls'>".form_uploader(site_url('cms/plugin_uploader/'), json_decode($result_data->STICKER_GALLERY, TRUE))."</div></div>";
		
		return $data_array;
	}
	
	/**
	 * Funciones de los posts a enviar
	 * Se debe enviar el array del post como primer parámetro y como segundo, configuración del upload, en caso no se este cargando ningún archivo, no se envía nada.
	 */
	public function post_new_val(){
		$submit_posts 					= $this->input->post();
		$submit_posts['STICKER_SET']	= $this->sticker_set;
		$submit_posts['STICKER_GALLERY']= json_encode($this->input->post('galleryImgs'));
		if($_FILES['STICKER_IMAGE']['error'] < 1)
			$submit_posts['STICKER_IMAGES']	= $this->upload_image('STICKER_IMAGE');
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 					= $this->input->post();
		$submit_posts['STICKER_SET']	= $this->sticker_set;
		$submit_posts['STICKER_GALLERY']= json_encode($this->input->post('galleryImgs'));
		if($_FILES['STICKER_IMAGE']['error'] < 1)
			$submit_posts['STICKER_IMAGES']	= $this->upload_image('STICKER_IMAGE');
	
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones específicas del plugin
	 */
	 private function categories_array(){
	 	$categories_obj			= $this->plugins_model->get_categories_array();
		$categories_array 		= array();
		foreach($categories_obj as $cat):
			$categories_array[$cat->ID] = $cat->CATEGORY_NAME;
		endforeach;
		
		return $categories_array;
	 }
	 private function border_radius_array(){
	 	$radius_options			= $this->plugins_model->list_rows('', '', NULL, NULL, NULL, 'PLUGIN_BORDER_RADIUS');
		$radius_array 			= array();
		foreach($radius_options as $rad):
			$radius_array[$rad->ID] = $rad->RADIUS_LABEL;
		endforeach;
		
		return $radius_array;
	 }
	 private function upload_image($image_name){
	 	
		//Cargar imagen
		$this->upload->initialize($this->upload_config); //Definir la configuración del upload
		if($this->upload->do_upload($image_name)):
			$this->fw_alerts->add_new_alert(4001);
			//guardar en la base de datos
			$image_data						= $this->upload->data();
			$sticker_images[]				= $image_data['file_name'];
			return json_encode($sticker_images);
		else:
			$this->fw_alerts->add_new_alert(4002);
			return NULL;
		endif;
	 }
}
