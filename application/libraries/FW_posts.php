<?php
/**
 * Todos los posts de los diferentes formularios
 */
class FW_posts {
	
	var $current_website;
	var $company;
	var $tel;
	var $contact_email;
	var $top_image_route;
	var $FW;
	function __construct() {
		
		$this->FW						=& get_instance();
		$this->FW->load->library('email');
		
		//Datos generales del sitio
		$this->current_website			= $_SERVER['HTTP_HOST'];
		$this->company					= $this->FW->fw_resource->request('RESOURCE_COMPANY_NAME');
		$this->tel						= $this->FW->fw_resource->request('RESOURCE_COMPANY_PHONE');
		$this->contact_email			= $this->FW->fw_resource->request('RESOURCE_CONTACT_EMAIL');
		$this->email_header				= $this->FW->fw_resource->request('RESOURCE_EMAIL_IMAGE_ROUTE');
		
		$this->top_image_route			= base_url($this->email_header);
		
	}
	
	/**
	 * Funciones de cada post
	 */
	//Enviar formulario de asistencia
	public function assistance_request_post(){
		
		
		//Establecer par�metros
		$this->FW->email->from($this->FW->input->post('inputEmail'), $this->FW->input->post('inputName'));
		$this->FW->email->to('info@grupoperinola.com'); 
		$this->FW->email->cc($this->FW->input->post('inputEmail'));
			
		$this->FW->email->subject('Correo solicitando asistencia');
		$html_body = array(
						array(
							'LABEL' 	=> 'Nombre',
							'POSTVAL'	=> $this->FW->input->post('inputName')
						),
						array(
							'LABEL' 	=> 'Email',
							'POSTVAL'	=> $this->FW->input->post('inputEmail')
						),
						array(
							'LABEL' 	=> 'Necesita Asistencia en:',
							'POSTVAL'	=> $this->FW->input->post('inputMessage')
						)
					);
		$html_message = $this->_html_body_template($this->current_website, $html_body, $this->company, $this->tel, $this->contact_email);
		$this->FW->email->message($html_message);
		$this->FW->email->send();
			
		$this->FW->fw_alerts->add_new_alert(3001, 'SUCCESS');
		redirect('cms/');
	}
	public function order_status_notification($orderId, $customerEmail){
		//Conectar al modelo de base de datos
		$this->FW->load->model('cms/cms_plugin_model', 'post_model');
		$this->FW->load->helper('utilities');
		
		//Obtener datos del cliente
		$customer = $this->FW->post_model->get_customer_user_info($orderId);

		$this->FW->email->from($this->contact_email, $this->company);
		$this->FW->email->to($customerEmail);
		$this->FW->email->cc($this->FW->fw_resource->request('RESOURCE_COMPANY_ORDERS_EMAIL'));
		$this->FW->email->reply_to('noreply@mislabels.com', 'Mis Labels');
		
		$this->FW->email->subject('Su orden ha sido cambiada de status a '.(str_replace('_', ' ', $this->FW->input->post('SHOPPING_STATUS'))));
		
		$html_body = array(
						array(
							'LABEL'		=> '&nbsp;',
							'POSTVAL'	=> 'Su orden ha sido cambiada de status, si desea mas informaci&oacute;n contactarse con mislabels.com a trav&eacute;s del correo electr&oacute;nico '.$this->contact_email.' o el tel&eacute;fono '.$this->tel
							),
						array(
							'LABEL'		=> 'Status',
							'POSTVAL'	=> str_replace('_', ' ', $this->FW->input->post('SHOPPING_STATUS'))
						)
		);
		//Agregar fecha de entrega si el status es pendiente
		if($this->FW->input->post('SHOPPING_STATUS') == 'PENDIENTE'):
		$html_body[] = array(
							'LABEL'		=> 'Fecha de entrega',
							'POSTVAL'	=> date_descriptive_sp($this->FW->input->post('SHOPPING_SHIPPINGDATE'))
		);
		endif;
		$html_message = $this->_html_body_template($this->current_website, $html_body, $this->company, $this->tel, $this->contact_email);
		$this->FW->email->message($html_message);
		if($this->FW->email->send()):
		$this->FW->fw_alerts->add_new_alert(3001, 'SUCCESS');
		else:
		echo $this->FW->email->print_debugger();
		endif;
		
	}
	//Enviar datos para confirmar contrase�a
	public function send_confirmation_code($id, $confirmation_code, $toemail){
		
		$this->FW->email->from('noreply@mislabels.com', $this->company);
		$this->FW->email->to($toemail);
		$this->FW->email->reply_to('noreply@mislabels.com', 'Mis Labels');
		
		$this->FW->email->subject('Email registrado como usuario de mislabels.com');
		
		
		$html_body = array(
						array(
							'LABEL'		=> '&nbsp;',
							'POSTVAL'	=> 'Esta cuenta de correo electr&oacute;nico ha sido registrada como usuario en mislabels.com, para confirmar pulse o copie el enlace.'
							),
						array(
							'LABEL'		=> 'Enlace',
							'POSTVAL'	=> '<a href="'.site_url('login/email_confirmation/'.$id.'/'.$confirmation_code).'" >'.site_url('login/email_confirmation/'.$id.'/'.$confirmation_code).'</a>'
						)
		);
		$html_message = $this->_html_body_template($this->current_website, $html_body, $this->company, $this->tel, $this->contact_email);
		$this->FW->email->message($html_message);
		
		$this->FW->email->send();
	}
	//Enviar datos para editar contrase�a
	public function send_confirmation_password($email, $pass){
		
		$this->FW->email->from('noreply@mislabels.com', $this->company);
		$this->FW->email->to($email);
		$this->FW->email->reply_to('noreply@mislabels.com', 'Mis Labels');
		
		$this->FW->email->subject('Solicitud de actualizaci�n de contrase�a');
		
		
		$html_body = array(
						array(
							'LABEL'		=> '&nbsp;',
							'POSTVAL'	=> 'Se ha solicitado una actualizaci&oacute;n de la contrase&ntilde;a para esta cuenta. Se le recomienda cambiar su contrase&ntilde;a una vez haya ingresado a su perfil de mislabels.com'
							),
						array(
							'LABEL'		=> 'Nueva Contrase&ntilde;a',
							'POSTVAL'	=> $pass
						)
		);
		$html_message = $this->_html_body_template($this->current_website, $html_body, $this->company, $this->tel, $this->contact_email);
		$this->FW->email->message($html_message);
		
		$this->FW->email->send();
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
							<p style="font-size:12px;color:#505050;">'.$this->company.'</p>
							<p style="font-size:11px;color:#505050;">Tel. '.$this->tel.'</p>
							<p style="font-size:9px;color:#707070;">Custom Site desarrollado por <a href="http://www.grupoperinola.com">Perinola</a></p>
						</body>
					</html>';
		return $html_code;
	}
}
