<?php
/**
 * Plugin para agregar imagenes editables 
 */
class Plugin_imagenes extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('cms/cms_plugin_images_model', 'images_model');
		
		$this->image_directory				= './library/cms/uploads/images/'; //Este directorio si se cambia debe cambiarse en el modelo tambi�n.
		$this->images_array[0]				= glob($this->image_directory."*.jpg");
		$this->images_array[1]				= glob($this->image_directory."*.png");
		$this->images_array[2]				= glob($this->image_directory."*.gif");
		
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Nombre";
		$this->plugin_display_array[2]		= "Imagen";
		$this->plugin_display_array[3]		= "P&aacute;gina";
	}
	
	/**
	 * Obtener la informaci�n de las im�genes y desplegarlo
	 */
	 public function index(){
	 	//Listar las im�genes sin el directorio
	 	$data_array['imagenes']			= str_replace($this->image_directory, '', array_merge($this->images_array[0], $this->images_array[1], $this->images_array[2]));
	 	$data_array['directory']		= $this->image_directory;
		
		foreach($data_array['imagenes'] as $i => $image):
			/* Create the object */
			@$data_array['imagen_properties'][$i] = getimagesize(base_url($this->image_directory.$image));
			//Obtener info de la im�gen
			$image_ext						= strstr($image, '.');
			$image_name_path				= str_replace($image_ext, '', $image);
			$image_name[$i]					= str_replace('_', ' ',$image_name_path);
					
		endforeach;
		
		//Contar las im�genes en la ruta para comparar con las im�genes en la base de datos
		$folder_images					= count($data_array['imagenes']);
		$db_images						= $this->images_model->total_rows();
		
		//Si hay mas im�genes en el folder que en la base de datos, se agregan a la base de datos
		if($folder_images > $db_images):
			//Insertar la im�gen en la DB
			foreach($data_array['imagenes'] as $i => $imagen):

				$data['COLUMN_GET']	= 'IMAGE_FILE';
				$data['COLUMN_VAR'] = $imagen;
				$image_existence	= count($this->images_model->get_single_row($data));
				//Si no ha sido ingresada, se inserta nueva imagen
				if($image_existence == 0):
					$requestArray['IMAGE_NAME']		= $image_name[$i];
					$requestArray['IMAGE_FILE']		= $imagen;
					$requestArray['IMAGE_WIDTH']	= $data_array['imagen_properties'][$i][0];
					$requestArray['IMAGE_HEIGHT']	= $data_array['imagen_properties'][$i][1];
					$requestArray['IMAGE_PAGE']		= 1;
					
					$this->images_model->insert($requestArray);
				endif;
			endforeach;
		//si hay menos, se borran
		elseif($folder_images < $db_images):
			$images_in_db = $this->images_model->list_rows($columns = 'ID, IMAGE_FILE');
			$images_to_remove = array();
			foreach($images_in_db as $imagen):
				//Si no est� en la ruta de imagenes del cms, se elimina del cms
				if(!in_array($imagen->IMAGE_FILE, $data_array['imagenes'])):
					$images_to_remove[] = $imagen->IMAGE_FILE;
				endif;
			endforeach;
			
			$this->images_model->delete_removed_images($images_to_remove);
		endif;
		
		$result_array['images'] 	= $this->images_model->display_images_categorized();
		$result_array['directory']	= $data_array['directory'];
		
		
		$result_array['image_content']		= '<div class="row-fluid">';
		$result_array['image_content']		.= 	'<div class="span12">';
		foreach($result_array['images'] as $pageID => $page):
		$result_array['image_content']		.= 		'<h4>'.$page['PAGE'].'</h4>';
		$result_array['image_content']		.= 		'<ul class="thumbnails">';
			foreach($page['IMAGES'] as $i => $image):
			$result_array['image_content']		.= 		'<li class="span3">';
			$result_array['image_content']		.= 			'<div class="thumbnail">';
			$result_array['image_content']		.= 			'<a href="./plugin_imagenes/editar_imagen/'.$image->ID.'" class="thumbnail">';
			$result_array['image_content']		.= 				'<img src="'.base_url($data_array['directory'].$image->IMAGE_FILE).'" alt="">';
			$result_array['image_content']		.= 			'</a>';
			$result_array['image_content']		.= 			'<h3>'.$image->IMAGE_NAME.'</h3>';
			$result_array['image_content']		.= 			'<p><b>Archivo: </b>'.$image->IMAGE_FILE.'</p>';
			$result_array['image_content']		.= 			'<p><b>Tama&ntilde;o: </b>'.$image->IMAGE_WIDTH.' x '.$image->IMAGE_HEIGHT.'</p>';
			$result_array['image_content']		.= 			'</div>';
			$result_array['image_content']		.= 		'</li>';
			endforeach;
			$result_array['image_content']		.= 	'</ul>';
		endforeach;
		$result_array['image_content']		.= 	'</div>';
		$result_array['image_content']		.= '</div>';
		
	 	$this->load->templatecms('cms/plugin_imagenes', $result_array);
	 }
	
	public function editar_imagen($ID){
		$data['COLUMN_VAR']					= $ID;
		$image_info							= $this->images_model->get_single_row($data);
		$images_pages_categories			= $this->images_model->get_pages_info();
		foreach($images_pages_categories as $page):
			$pages_categories[$page->ID]	= $page->LABEL;
		endforeach;
		
		$result_array['image_content']		=  '<div class="row-fluid">';
		$result_array['image_content']		.= 	'<div class="span12">';
		
		$result_array['image_content']		.=  form_open_multipart('cms/plugin_imagenes/edit_image_val/'.$ID, array('class' => 'form-horizontal'));
		$result_array['image_content']			.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('IMAGE_PAGE', $pages_categories, $image_info->IMAGE_PAGE, "class = 'span6'")."</div></div>";
		$result_array['image_content']		.= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'IMAGE_NAME', 'value' => $image_info->IMAGE_NAME, 'class' => 'span6'))."</div></div>";
		$result_array['image_content']		.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_upload(array('name' => 'IMAGE_FILE', 'class' => 'span6'))."<span class='help-block'>Tama&ntilde;o requerido ".$image_info->IMAGE_WIDTH." x ".$image_info->IMAGE_HEIGHT." PX</span></div></div>";
				
		$result_array['image_content']		.= '<div class="form-actions">';
		$result_array['image_content']		.= form_submit(array('value' => $this->plugin_button_update, 'class' => 'btn btn-primary', 'name' => 'POST_SUBMIT')).' ';
//		$result_array['image_content']		.= form_submit(array('value' => $this->plugin_button_delete, 'class' => 'btn btn-danger', 'name' => 'POST_SUBMIT')).' ';
		$result_array['image_content']		.= anchor('cms/plugin_imagenes', $this->plugin_button_cancel, array('class'=>'btn')).' ';
		$result_array['image_content']		.= '</div>';
		
		$result_array['image_content']		.=	'</div>';
		$result_array['image_content']		.= '</div>';
		
	 	$this->load->templatecms('cms/plugin_imagenes', $result_array);
	}

	/**
	 * Funciones espec�ficas del plugin
	 */
	public function edit_image_val($image){
		
		$this->images_model->edit_image_data($image);
		$this->fw_alerts->add_new_alert(4010);
		
		redirect('cms/plugin_imagenes');
	}
}
