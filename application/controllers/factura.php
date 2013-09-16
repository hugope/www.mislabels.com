<?php
/**
 * Desplegar información de facturación
 */
class Factura extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('plugins/buying_process_model', 'buying_process');
		$this->load->model('plugins/billing_model', 'billing_model');
	}
	public function configurar($cartid = NULL){
		
		//Menu del proceso de compra
		$menu_data['stages'] 		= $this->buying_process->wizard_menu('Factura');
		$data['wizard_menu']		= $this->load->view('includes/wizard_menu', $menu_data, true);
		
		//Obtener datos de facturación
		$billing_request['COLUMN_VAR'] = $cartid;
		$billing_data = $this->billing_model->get_single_row($billing_request);
		
		//Enviar datos de facturación
		$data['billing_name']		= $billing_data->SHOPPING_CUSTOMER_BILLINGNAME;
		$data['billing_tin']		= $billing_data->SHOPPING_CUSTOMER_BILLINGTIN;
		$data['billing_location']	= $billing_data->SHOPPING_CUSTOMER_BILLINGLOCATION;
		
		//Load the template
		$this->load->template('facturacion', $data);
	}
	public function add_billing($cartid = NULL){
		$data = array(
					'SHOPPING_CUSTOMER_BILLINGNAME' => $this->input->post('SHOPPING_CUSTOMER_BILLINGNAME'),
					'SHOPPING_CUSTOMER_BILLINGTIN' => $this->input->post('SHOPPING_CUSTOMER_BILLINGTIN'),
					'SHOPPING_CUSTOMER_BILLINGLOCATION' => $this->input->post('SHOPPING_CUSTOMER_BILLINGLOCATION')
				);
	
		
		/*
		echo '<pre>';
		print_r($update_data);
		echo '</pre>';
		*/
		if($this->billing_model->update($data, $cartid)):
			$this->fw_alerts->add_new_alert(6005);
			redirect(site_url('resumen/configurar/'.$cartid));
		else:
			$this->fw_alerts->add_new_alert(6006);
			redirect(site_url('factura/configurar/'.$cartid));
		endif;
	}
}
