<?php
/**
 * Todos los posts de los diferentes formularios
 */
class Plugin_posts extends MY_Controller {
	
	var $current_website;
	var $company;
	var $tel;
	var $contact_email;
	var $top_image_route;
	function __construct() {
		parent::__construct();
		
		//Datos generales del sitio
		$this->current_website			= $_SERVER['HTTP_HOST'];
		$this->company					= $this->fw_resource->request('RESOURCE_COMPANY_NAME');
		$this->tel						= $this->fw_resource->request('RESOURCE_COMPANY_PHONE');
		$this->contact_email			= $this->fw_resource->request('RESOURCE_CONTACT_EMAIL');
		
		$this->top_image_route			= base_url("/library/cms/uploads/images/email_header.jpg");
		
		//Validar formularios
		$this->load->library('user_agent');
		$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
		
		if(!$this->input->post()){
			$this->fw_alerts->add_new_alert(9990);
			redirect('cms');
		}elseif(!array_filter($this->input->post())){
			$this->fw_alerts->add_new_alert(3003);
			redirect('cms');
		}elseif($this->form_validation->run('FRAMEWORK_ASSISTANCE') == FALSE){
			
			$form_errors_array = array(
				'error_inputName'		=> form_error('inputName'),
				'error_inputEmail'		=> form_error('inputEmail'),
				'error_inputMessage'	=> form_error('inputMessage'),
				
				'data_inputName'		=> set_value('inputName'),
				'data_inputEmail'		=> set_value('inputEmail'),
				'data_inputMessage'		=> set_value('inputMessage'),
			);
			$form_errors_alerts_array = array(
				'alert_inputName'		=> ($form_errors_array['error_inputName']!='')?'error':'',
				'alert_inputEmail'		=> ($form_errors_array['error_inputEmail']!='')?'error':'',
				'alert_inputMessage'	=> ($form_errors_array['error_inputMessage']!='')?'error':''
			);
			$this->session->set_flashdata($form_errors_array);
			$this->session->set_flashdata($form_errors_alerts_array);
			
			$this->fw_alerts->add_new_alert(3004);
			redirect($this->agent->referrer());
		}
		
		//Cargar la librería de email
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] 	= 'iso-8859-1';
		$config['wordwrap']	= TRUE;
		$config['mailtype']	= 'html';
		$this->email->initialize($config);
	}
	
	/**
	 * Funciones de cada post
	 */
	//Enviar formulario de asistencia
	public function assistance_request_post(){
		
		
		//Establecer parámetros
		$this->email->from($this->input->post('inputEmail'), $this->input->post('inputName'));
		$this->email->to('guido@grupoperinola.com'); 
		$this->email->cc($this->input->post('inputEmail'));
			
		$this->email->subject('Correo solicitando asistencia');
		$html_body = array(
						array(
							'LABEL' 	=> 'Nombre',
							'POSTVAL'	=> $this->input->post('inputName')
						),
						array(
							'LABEL' 	=> 'Email',
							'POSTVAL'	=> $this->input->post('inputEmail')
						),
						array(
							'LABEL' 	=> 'Necesita Asistencia en:',
							'POSTVAL'	=> $this->input->post('inputMessage')
						)
					);
		$html_message = $this->_html_body_template($this->current_website, $html_body, $this->company, $this->tel, $this->contact_email);
		$this->email->message($html_message);
		$this->email->send();
			
		$this->fw_alerts->add_new_alert(3001);
		redirect('cms/');
	}
	
	public function order_status_notification($orderId){
		//Conectar al modelo de base de datos
		$this->load->model('cms/cms_plugin_model', 'post_model');
		
		//Obtener datos del cliente
		$customer = $this->post_model->get_customer_user_info($orderId);

		$this->email->from($this->contact_email, $this->company);
		$this->email->to($customer->CUSTOMER_EMAIL);
		$this->email->cc($this->contact_email);
		
		$this->email->subject('Su orden ha sido cambiada de status a '.(str_replace('_', ' ', $this->input->post('SHOPPING_STATUS'))));
		
		$html_body = array(
						array(
							'LABEL'		=> 'Status',
							'POSTVAL'	=> str_replace('_', ' ', $this->input->post('SHOPPING_STATUS'))
						)
		);
		//Agregar fecha de entrega si el status es pendiente
		if($this->input->post('SHOPPING_STATUS') == 'PENDIENTE'):
		$html_body[] = array(
							'LABEL'		=> 'Fecha de entrega',
							'POSTVAL'	=> $this->input->post('SHOPPING_SHIPPINGDATE')
		);
		endif;
		$html_message = $this->_html_body_template($this->current_website, $html_body, $this->company, $this->tel, $this->contact_email);
		$this->email->message($html_message);
		if($this->email->send()):
		$this->fw_alerts->add_new_alert(3001);
		else:
		echo $this->email->print_debugger();
		endif;
		
	}
	/**
	 * Template del HTML a enviar por correo
	 */
	private function _html_body_template($current_website, $body_array, $company, $tel, $contact_email){
		$html_code = '<html>
						<head><title>'.$current_website.'</title></head>
						<body style="font-family:Arial, Helvetica; sans-serif;">
							<p><span style="font-size:18px;color:#000;font-weight:bold;">Solicitud de Contacto - '.$company.'</span><p>
							<p><span style="font-size:14px;color:#505050;">Gracias por su mensaje.</span></p>
							<p><span style="font-size:14px;color:#505050;">A continuaci&oacute;n una copia de la informaci&oacute;n enviada. Si necesita agregar o modificar alg&uacute;n dato, por favor escriba a <b>'.$contact_email.'</b>.</span></p>
							<table width="550" style="background-color:#EEE;width:526px;font-size:12px;">
							<tr>
								<td>
									<table width="550" style="border-color:#dbdbdb;border-style:solid;border-width:1px;width:526px;font-size:12px; font-family:Arial, Helvetica; sans-serif;">
										<tr style="line-height:20px;"><td colspan="2" style="font-size:14px;"><img src="'.$this->top_image_route.'" width="550" height="60" style="padding:0px;margin:0px;" /></td></tr>';
		foreach($body_array as $field):
		$html_code .= '						<tr>
												<td style="padding-left:10px;padding-top:10px;padding-bottom:10px; width:120"><b>'.$field['LABEL'].'</b></td>
												<td style="padding-left:10px;padding-top:10px;padding-bottom:10px">'.$field['POSTVAL'].'</td>
											</tr>';
		endforeach;
		$html_code .= '				</table>
								</td>
							</tr>
							</table>
							<p style="font-size:11px;color:#505050;">La informaci&oacute;n contenida en este mensaje es privada y confidencial. Si la ha recibido por error, por favor proceda a notificar al remitente y eliminarla de su sistema.</p>
							<p style="font-size:12px;color:#505050;">Atentamente,</p>
							<p style="font-size:12px;color:#505050;">'.$company.'</p>
							<p style="font-size:11px;color:#505050;">Tel. '.$tel.'</p>
							<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
						</body>
					</html>';
		return $html_code;
	}
}
