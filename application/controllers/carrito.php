<?php
/**
 * Carrito de compras
 */
class Carrito extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('cart');
		
		$this->load->model('plugins/cart_model', 'cart_model');
		
		//$this->output->profiler(TRUE);
	}
	public function index($cartid = NULL){
		
		//Obtener el carro de compras actual
		$shopping_cart = $this->cart_model->get_shopping_cart($cartid);
		//Obtener las stickers del carro de compras actual
		$shopping_cart_stickers = (!empty($shopping_cart))?$this->cart_model->shopping_cart_stickers($shopping_cart->ID):NULL;

		$data['cartid']		= (!empty($shopping_cart))?$shopping_cart->ID:NULL;
		$data['stickers'] 	= (!empty($shopping_cart_stickers))?$shopping_cart_stickers->cartstickers:NULL;
		$data['cartTotal'] 	= (!empty($shopping_cart_stickers))?$shopping_cart_stickers->cartTotal:NULL;
		//Obtener el template
		$this->load->template('cart', $data);
	}
	public function agregar($cartid = NULL){
		if($this->input->post()):
			$shopping_cart = $this->cart_model->get_shopping_cart($cartid);
			
			if(!empty($_POST['STICKER_LABEL']) && array_search(0, array_map("strlen", $_POST['STICKER_LABEL'])) === false):
				$stickersArray[0] = (object) array(
												'ID' 				=> $this->input->post('STICKER_TYPE'),
												'STICKER_COLOR'		=> $this->input->post('STICKER_COLOR'),
												'STICKER_FONT'		=> $this->input->post('stickerfontfamily'),
												'STICKER_LABEL'		=> json_encode($this->input->post('STICKER_LABEL')),
												'STICKER_QUANTITY'	=> $this->input->post('STICKER_QUANTITY')
											);
				$insert = (!empty($shopping_cart))?$this->cart_model->add_cart_stickers($stickersArray, $shopping_cart->ID):$this->cart_model->create_new_shopping_cart($stickersArray);
				
				if($insert != FALSE):
					$this->fw_alerts->add_new_alert(6001);
					redirect('etiquetas');
				else:
					$this->fw_alerts->add_new_alert(6002);
					redirect('carrito');
				endif;
			else:
				$this->fw_alerts->add_new_alert(6009);
				redirect('etiquetas');
			endif;
		else:
			$this->fw_alerts->add_new_alert(6002);
			redirect('carrito');
		endif;
	}
	public function eliminar($cartid = NULL, $sticker = NULL){
		$shopping_cart = $this->cart_model->get_shopping_cart($cartid);
		if($sticker != NULL)
			if($this->cart_model->delete_sticker($sticker)):
				$this->fw_alerts->add_new_alert(6007);
			else:
				$this->fw_alerts->add_new_alert(6008);
			endif;
			redirect('carrito/index/'.$cartid);
	}
}
