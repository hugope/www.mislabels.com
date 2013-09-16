<?php
/**
 * 
 */
class Inicio extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('plugins/slider_model', 'slider_model');
		$this->load->model('plugins/etiquetas_model', 'etiquetas_model');
	}
	
	public function index(){
		
		//Mostrar el slider
		$data['slides'] = $this->slider_model->display_slider();
		
		//Enviar las etiquetas mas populares
		$data['populares'] = $this->etiquetas_model->popular_stickers();
		
		//Enviar las etiquetas nuevas
		$data['latest'] = $this->etiquetas_model->latest_stickers(8);
		
		
		//Cargar el view del inicio
		$this->load->template('inicio', $data);
		
		
	}
}
