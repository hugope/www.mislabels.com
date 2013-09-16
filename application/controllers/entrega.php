<?php
/**
 * Configurar entrega
 */
class Entrega extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('plugins/shipping_model', 'shipping_model');
		$this->load->model('plugins/buying_process_model', 'buying_process');
		

		//Show profiler
		$this->output->enable_profiler(FALSE);
	}
	public function configurar($cartid = NULL){
		$this->load->model('plugins/cart_model', 'cart_model');
		
		//Cambiar status del shopping cart
		$this->cart_model->update(array('SHOPPING_STATUS' => 'EN_PROCESO'), $cartid);
		
		//Menu del proceso de compra
		$menu_data['stages'] 		= $this->buying_process->wizard_menu('Entrega');
		$data['wizard_menu']		= $this->load->view('includes/wizard_menu', $menu_data, true);
		
		//Obtener el shopping cart
		$shopping_cart 		= $this->cart_model->get_shopping_cart($cartid); //Obtener datos del shopping cart ingresado por el usuario
		$shipping_info		= $this->shipping_model->display_shipping_data($shopping_cart->SHOPPING_SHIPPINGADDRESS);
		
		//Tipo de entrega
		$pickup 			= (!empty($shipping_info) && $shipping_info->SHIPPING_TYPE == 'PICKUP')?TRUE:FALSE;
		$deliver 			= ($pickup == FALSE)?TRUE:FALSE;
		$data['deliver']	= form_radio(array( "id" => "dd1",  "checked" => $deliver, "value" => "DELIVER", "name" => "CART_LOCATION", "onclick" => "set_inputs_enable('.confLeft')" ));
		$data['pickup']		= form_radio(array( "id" => "dd2",  "checked" => $pickup, "value" => "PIVKUP", "name" => "CART_LOCATION", "onclick" => "set_inputs_enable('.registerRight')" ));
		
		//Enviar datos formulario de envío
		$data['deliver_person']					= $shopping_cart->SHOPPING_RECEIVER;
		$data['deliver_address']				= @$shipping_info->SHIPPING_ADDRESS;
		$data['deliver_municipios']				= localidades_caex();
		$data['deliver_municipio']				= (isset($shipping_info->SHIPPING_CITY) && !empty($shipping_info->SHIPPING_CITY))?$shipping_info->SHIPPING_CITY:0;
		$data['deliver_location']				= @$shipping_info->SHIPPING_LOCATION;
		
		//Enviar datos de pickup
		$data['pickup_locations']				= $this->shipping_model->display_pickup_locations(TRUE);
		$data['pickup_location']				= @$shipping_info->ID;
		
		
		//Display the template
		$this->load->template('entrega', $data);
	}
	public function add_shipping($cartid = NULL){
		if($this->input->post()){
			if($this->input->post('CART_LOCATION') == 'DELIVER'):
				$insert_data = array(
							'SHIPPING_ADDRESS' 	=> $this->input->post('SHIPPING_ADDRESS'),
							'SHIPPING_CITY'		=> $this->input->post('SHIPPING_CITY'),
							'SHIPPING_LOCATION'	=> $this->input->post('SHIPPING_LOCATION'),
							'SHIPPING_TYPE'		=> 'DELIVER'
							);
				$update_data['SHOPPING_SHIPPINGADDRESS'] = $this->shipping_model->insert($insert_data);
			else:
				$update_data['SHOPPING_SHIPPINGADDRESS'] = $this->input->post('PICKUP_LOCATIONS');
			endif;
			$update_data['SHOPPING_RECEIVER'] = $this->input->post('SHOPPING_RECEIVER');
			$this->shipping_model->add_shipping_address($cartid, $update_data);
			/*
			echo '<pre>';
			print_r($update_data);
			echo '</pre>';
			*/
			if($this->shipping_model->add_shipping_address($cartid, $update_data)):
				$this->fw_alerts->add_new_alert(6003);
				redirect(site_url('factura/configurar/'.$cartid));
			else:
				$this->fw_alerts->add_new_alert(6004);
				redirect(site_url('entrega/configurar/'.$cartid));
			endif;
		}
	}
}

