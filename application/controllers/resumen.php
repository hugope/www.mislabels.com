<?php 
/**
 * Resumen de proceso de compra
 */
class Resumen extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		$this->load->model('plugins/buying_process_model', 'buying_process');
		$this->load->model('plugins/summary_model', 'summary_model');
		$this->load->model('plugins/cart_model', 'cart_model');
		$this->load->model('plugins/shipping_model','shipping_model');
	}
	public function configurar($cartid = NULL){
		
		//Menu del proceso de compra
		$menu_data['stages'] 		= $this->buying_process->wizard_menu('Resumen');
		$data['wizard_menu']		= $this->load->view('includes/wizard_menu', $menu_data, true);
		
		//Enviar datos del carro de compras
		$shopping_cart = $this->cart_model->get_shopping_cart($cartid);
		$shopping_cart_stickers = $this->cart_model->shopping_cart_stickers($shopping_cart->ID);
		$data['cartid']		= $shopping_cart->ID;
		$data['stickers'] 	= $shopping_cart_stickers->cartstickers;
		$data['cartTotal'] 	= $shopping_cart_stickers->cartTotal;
		$data['carro']		= $shopping_cart;
		
		//Mostrar datos de envío
		$stickers_quantity = array();
		foreach($data['stickers'] as $sticker):
			$stickers_quantity[] = $sticker->STICKER_QUANTITY;
		endforeach;
		$data['envio'] 		= $this->shipping_model->display_shipping_data($shopping_cart->SHOPPING_SHIPPINGADDRESS);
		$total_shipping_cost = (array_sum($stickers_quantity) * display_zonas_prices($data['envio']->SHIPPING_CITY)) * 1.20; //Se le aumenta un 20% al costo.
		$data['costoEnvio'] = ($data['envio']->SHIPPING_TYPE == 'DELIVER')?$total_shipping_cost:0;
		
		//Load the template
		$this->load->template('resumen', $data);
	}
}
