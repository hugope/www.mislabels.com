<?php
/**
 * 
 */
class Etiquetas extends CI_Controller {

	var $formaction;
	function __construct() {
		parent::__construct();
		//Load the plugin
		$this->load->model('plugins/etiquetas_model', 'etiquetas_model');
		
		//Set variables
		$this->formaction			= ($this->session->userdata('CUSTOMER_SESSION') == TRUE)?site_url('carrito/agregar'):site_url('login');
		
		//Show profiler
		$this->output->enable_profiler(FALSE);
		
		
	}
	
	public function index($offset = 0){
		
		//Busqueda
		$search_labels			= (!empty($_POST['search_labels']))? $this->input->post('search_labels'):NULL;
		
		//Configurar la paginación
		$this->load->library('pagination');
		$config['base_url'] 	= site_url('etiquetas/index/');
		$config['first_link'] 	= 'Inicio';
		$config['last_link'] 	= 'Final';
		$config['num_links']	= 5;
		$config['uri_segment']	= 3;
		$config['total_rows'] 	= $this->etiquetas_model->stickers_total_rows($search_labels);
		$config['per_page'] 	= 12; 
		$this->pagination->initialize($config); 
		
		//Send the total stickers values
		$data_array['total_rows']			= $config['total_rows'];
		$data_array['per_page']				= $config['per_page'];
		
		//Get the selected categories and sets
		$data_array['selected_sets']		= (!empty($_POST['labels_sets']))?$this->input->post('labels_sets'):array(12,13,14,15);
		$data_array['selected_categories']	= (!empty($_POST['labels_categories']))?$this->input->post('labels_categories'):array();
		
		//Establecer la sesión
		if(!empty($_POST['labels_sets'])){$this->session->set_userdata('sets_session', json_encode($data_array['selected_sets']));}
		if(!empty($_POST['labels_categories'])){$this->session->set_userdata('sets_categories', json_encode($data_array['selected_categories']));}
		
		//Get the sidebar filters
		$data_array['label_sets_filter'] 	= $this->etiquetas_model->label_sets_list();
		$data_array['categories_filter'] 	= $this->etiquetas_model->categories_list();
		//Get the stickers list
		$data_array['list_stickers'] 		= $this->etiquetas_model->list_stickers($config['per_page'], $offset, $search_labels);
		//Get the pagination
		$data_array['pagination']			= $this->pagination->create_links();
		
		
		$this->load->template('etiquetas', $data_array);
	}
	
	/**
	 * Etiquetas segun set seleccionado
	 */
	public function tipo_a($etiqueta, $texto = 'Esto es Mío', $color = 'PLATA', $font = 'futura', $new = TRUE){
		
		$stickerData 					= $this->etiquetas_model->get_single_sticker($etiqueta);
		$result_data['sticker']			= $stickerData;
		$result_data['iconimg']			= json_decode($stickerData->STICKER_IMAGES, TRUE);
		$result_data['iconimg']			= $result_data['iconimg'][0];
		$result_data['colors']			= $this->etiquetas_model->get_available_colors();
		$result_data['currentcolor']	= $this->etiquetas_model->get_color_data($color);
		$result_data['colorlabel']		= $color;
		$result_data['texto']			= substr(urldecode($texto), 0, 16);
		$result_data['fontfamilies']	= $this->etiquetas_model->get_available_fonts();
		$result_data['fontfamily']		= $this->etiquetas_model->get_font_data($font);
		$result_data['formaction']		= $this->formaction;
		$result_data['img_gallery']		= (json_decode($stickerData->STICKER_GALLERY) != NULL)?json_decode($stickerData->STICKER_GALLERY):array();
		
		
	 	$this->load->template('tipoa', $result_data);
	}
	public function tipo_b($etiqueta, $texto = 'Esto es Mío', $color = 'PLATA', $font = 'futura', $new = TRUE){
		
		$stickerData 					= $this->etiquetas_model->get_single_sticker($etiqueta);
		$result_data['sticker']			= $stickerData;
		$result_data['iconimg']			= json_decode($stickerData->STICKER_IMAGES, TRUE);
		$result_data['colorlabel']		= $color;
		$result_data['texto']			= substr(urldecode($texto), 0, 16);
		$result_data['fontfamilies']	= $this->etiquetas_model->get_available_fonts();
		$result_data['fontfamily']		= $this->etiquetas_model->get_font_data($font);
		$result_data['formaction']		= $this->formaction;
		$result_data['img_gallery']		= (json_decode($stickerData->STICKER_GALLERY) != NULL)?json_decode($stickerData->STICKER_GALLERY):array();
		
		
	 	$this->load->template('tipob', $result_data);
	}
	public function tipo_c($etiqueta, $color = 'PLATA', $font = 'futura', $new = TRUE){
		
		for($i = 0; $i < 40; $i++):
		$texto_array[]					= "Etiqueta ".$i;
		endfor;
		$stickerData 					= $this->etiquetas_model->get_single_sticker($etiqueta);
		$result_data['sticker']			= $stickerData;
		$result_data['iconimg']			= json_decode($stickerData->STICKER_IMAGES, TRUE);
		$result_data['iconimg']			= $result_data['iconimg'][0];
		$result_data['colors']			= $this->etiquetas_model->get_available_colors();
		$result_data['currentcolor']	= $this->etiquetas_model->get_color_data($color);
		$result_data['colorlabel']		= $color;
		$result_data['texto']			= $texto_array;
		$result_data['fontfamilies']	= $this->etiquetas_model->get_available_fonts();
		$result_data['fontfamily']		= $this->etiquetas_model->get_font_data($font);
		$result_data['formaction']		= $this->formaction;
		$result_data['img_gallery']		= (json_decode($stickerData->STICKER_GALLERY) != NULL)?json_decode($stickerData->STICKER_GALLERY):array();
		
		
	 	$this->load->template('tipoc', $result_data);
	}
}
