<?php
/**
 * Desplegar información de facturación
 */
class Pago extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('plugins/buying_process_model', 'buying_process');
		$this->load->model('plugins/payment_model', 'payment_model');

		//Show profiler
		$this->output->enable_profiler(FALSE);
		
	}
	/**
	 * Mostrar formulario para ingresar tarjeta
	 */
	public function configurar($cartid = NULL){
		
		//Menu del proceso de compra
		$menu_data['stages'] 		= $this->buying_process->wizard_menu('Pago');
		$data['wizard_menu']		= $this->load->view('includes/wizard_menu', $menu_data, true);
		
		//Datos a enviar para autorización
        //$amount                         = $this->input->post('SHOPPING_AMOUNT');
        $amount                         = '1.00';
        $current_time                   = getdate();
		$time                           = time();
        $orderid                        = $cartid;
        //$orderid                        = "test";
        $key                            = '6tzUn7397En2g9ZDzetDww4h62maN4R9';
        $hash_string                    = $orderid."|".$amount."|".$time."|".$key;
		$hash                           = md5($hash_string);
		
		$card_fields = array(
			"type" => "auth",
			"key_id" => "3494684",
			"hash" => $hash,
			"time" => $time,
			"amount" => $amount,
			"orderid" => $orderid,
			"processor_id" => "",
			"redirect" => site_url('pago/respuesta/'.$cartid).'/'
		);
		$data['validation_fields'] = form_hidden($card_fields);
		$dateArray = date_components('sp', 20);
		$months = $dateArray['meses'];
		$years 	= $dateArray['aSiguientes'];
		$data['expmonth'] = form_dropdown('expmonth', $months, '01', 'id="expmonth" onchange="expdate_format()"');
		$data['expyear'] = form_dropdown('expyear', $years, date('Y'), 'id="expyear" onchange="expdate_format()"');
		
		//Load the template
		$this->load->template('cardpayment', $data);
	}

	/**
	 * Mostrar resuesta del pago
	 */
	public function respuesta($cartid = NULL){
		//Menu del proceso de compra
		$menu_data['stages'] 		= $this->buying_process->wizard_menu('Pago');
		$data['wizard_menu']		= $this->load->view('includes/wizard_menu', $menu_data, true);
		
		$this->insert_payment(((isset($_GET['PAYMENT_TYPE']))?$_GET['PAYMENT_TYPE']: 'CREDITCARD'), $cartid, (json_encode($_GET)));
		
		//Desplegar la respuesta
		$responsedata['card_response'] = $_GET['responsetext'];
		if($_GET['response'] != 1){
		$data['response_display'] = $this->load->view('card_error_response', $responsedata, true);
		}elseif(isset($_GET['PAYMENT_TYPE']) && $_GET['PAYMENT_TYPE'] == 'POST'){
		$data['response_display'] = $this->load->view('post_success_response', $responsedata, true);
		}else{
		$data['response_display'] = $this->load->view('card_success_response', $responsedata, true);
		}
		
		$this->load->template('respuestapago', $data);
	}
	private function insert_payment($type, $cartid, $response){
		$this->load->model('plugins/cart_model', 'cart_model');
		
		if($cartid > 0){
			//Agregar respuesta del pago
			$payment_data['PAYMENT_TYPE'] 		= $type;
			$payment_data['PAYMENT_CART']		= $cartid;
			$payment_data['PAYMENT_RESPONSE']	= $response;
			$this->payment_model->insert($payment_data);
			//Cambiar status del pedido a pendiente
			$update_status['SHOPPING_STATUS'] 	= 'PENDIENTE';
			$this->cart_model->update($update_status, $cartid);
		}
	}
}
