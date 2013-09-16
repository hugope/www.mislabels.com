<?php
/**
 * Obtener la pagina de Login
 */
class Login extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('plugins/login_model', 'login_model');//Modelo

		$this->form_validation->set_error_delimiters('<span class="validation_error">', '</span>');
		$this->form_validation->set_message('email_check', 'El correo electr&oacute;nico ya fu&eacute; registrado anteriormente.');
		//Enable profiler
		$this->output->enable_profiler(FALSE);
	}
	
	public function index(){
		
		//Validar registro
		if($this->input->post('register_user') != ''){
			
			if ($this->form_validation->run('FRAMEWORK_USER_REGISTRATION') == FALSE):
				$this->fw_alerts->add_new_alert(5001);
			else:
				$new_customer	= $_POST; 
				unset($new_customer['CUSTOMER_PASSWORD_CONFIRMATION']); //Eliminar la confirmación de la contraseña
				unset($new_customer['CUSTOMER_TERMS_ACCEPTANCE']); //Eliminar el input de términos y condiciones
				unset($new_customer['register_user']); //Eliminar el input de submit button
	 			
			 	//Insert in database
				$new_customer['CUSTOMER_PASSWORD'] 				= sha1($new_customer['CUSTOMER_PASSWORD']);
				$new_customer['CUSTOMER_DATECREATED']			= date('Y-m-d');
				$new_customer['CUSTOMER_ENABLED']				= 'NO';
				$new_customer['CUSTOMER_CONFIRMATIONCODE']		= random_string('alnum', 44);
				
				$insertedId = $this->login_model->save_new_customer($new_customer);
				
				//Enviar código de verificación
				$this->fw_posts->send_confirmation_code($insertedId, $new_customer['CUSTOMER_CONFIRMATIONCODE'], $new_customer['CUSTOMER_EMAIL']);
				$this->fw_alerts->add_new_alert(5002);
				
			endif;
		}
		
		
			if(!empty($_POST['STICKER_LABEL']) && array_search(0, array_map("strlen", $_POST['STICKER_LABEL'])) === false):
				//Send sticker info
				$dataArray = array(
					'STICKER_COLOR'		=> (($this->input->post('STICKER_COLOR') != '')?$this->input->post('STICKER_COLOR'):''),
					'STICKER_FONT'		=> (($this->input->post('STICKER_QUANTITY') > 0)?$this->input->post('stickerfontfamily'): ''),
					'STICKER_LABEL'		=> (($this->input->post('STICKER_QUANTITY') > 0)?json_encode($this->input->post('STICKER_LABEL')): ''),
					'STICKER_TYPE'		=> (($this->input->post('STICKER_QUANTITY') > 0)?$this->input->post('STICKER_TYPE'):''),
					'STICKER_QUANTITY'	=> (($this->input->post('STICKER_QUANTITY') > 0)?$this->input->post('STICKER_QUANTITY'):'')
					);
				$dataArray = array_filter($dataArray);
				$login_data['stickerdata'] = form_hidden($dataArray);
			elseif(($this->input->post('STICKER_QUANTITY') > 0)):
				$this->fw_alerts->add_new_alert(6009);
				redirect('etiquetas');
			else:
				$login_data['stickerdata'] = NULL;
			endif;
		//Load the template
		$this->load->template('login', $login_data);
	}
	
	/**
	 * Función de validación de correo
	 */
	 public function email_confirmation($userid, $confirmation_code){
	 	$confirm = $this->login_model->email_confirmation($userid, $confirmation_code);
		if($confirm == TRUE):
			$this->fw_alerts->add_new_alert(5004);
		else:
			$this->fw_alerts->add_new_alert(5003);
		endif;
		
		redirect('login');
	 }
	
	/**
	 * Función que valida que no haya ya registrado un email como el que se está ingresando
	 */
	public function email_check($str){
		return $this->login_model->check_email_existence($str);
	}
	
	/**
	 * Función para inicio de sesión
	 */
	 public function iniciar_sesion(){
	 	
	 	$start = $this->login_model->set_session_start($this->input->post('CUSTOMER_EMAIL'), $this->input->post('CUSTOMER_PASSWORD'));
		if(count($start) > 0):
			//Iniciar la sesión
			$newdata = array(
						'CUSTOMER_NAME' 	=> $start->CUSTOMER_NAME.' '.$start->CUSTOMER_LASTNAME,
						'CUSTOMER_EMAIL' 	=> $start->CUSTOMER_EMAIL,
						'CUSTOMER_ID' 		=> $start->ID,
						'CUSTOMER_SESSION' 	=> TRUE
               );
		   $this->session->set_userdata($newdata);
			if($this->session->userdata('CUSTOMER_SESSION') == TRUE):
				//Agregar datos de sticker si existiera
				if($this->input->post('STICKER_QUANTITY') > 0):
					$stickerArray = array(
										(object) array(
											'ID'				=> $this->input->post('STICKER_TYPE'),
											'STICKER_COLOR'		=> $this->input->post('STICKER_COLOR'),
											'STICKER_FONT'		=> $this->input->post('STICKER_FONT'),
											'STICKER_LABEL'		=> json_encode($this->input->post('STICKER_LABEL')),
											'STICKER_QUANTITY'	=> $this->input->post('STICKER_QUANTITY')
										)
									);
			    	$this->load->model('plugins/cart_model', 'cart_model');
			
					//Añadir el sticker al carro de compra
					$this->cart_model->create_new_shopping_cart($stickerArray);
					
					$this->fw_alerts->add_new_alert(5005);
					redirect('carrito');
				else:
					$this->fw_alerts->add_new_alert(5005);
					redirect('miperfil');
				endif;
				
			else:
				$this->fw_alerts->add_new_alert(5007);
				redirect('login');
			endif;
			
		else:
			$newdata = array(
						'CUSTOMER_SESSION' 	=> FALSE
               );
			$this->session->set_userdata($newdata);
			$this->fw_alerts->add_new_alert(5006);
			redirect('login');
		endif;
		
	 }
	 /**
	  * Cerrar sesión
	  */
	  public function out(){
		$newdata = array(
						'CUSTOMER_NAME' 	=> '',
						'CUSTOMER_EMAIL' 	=> '',
						'CUSTOMER_ID' 		=> '',
						'CUSTOMER_SESSION' 	=> FALSE
					);
	  	$this->session->unset_userdata($newdata);
		$this->fw_alerts->add_new_alert(5008);
		redirect('login');
	  }
		
		/**
		 * Recuperar Contraseña
		 */
		 public function recuperar(){
			$this->load->model('plugins/myprofile_model', 'myprofile_model');
			
			if($this->input->post()):
				//Obtener datos del usuario
				$usuario = $this->myprofile_model->get_profile_data($this->input->post('EMAIL_PASSWORD_RECOVERY'));
			 	
				if(!empty($usuario)){
					//Generar Contraseña
					$password = random_string('alnum', 16);
					
					//Enviar datos
					$this->fw_posts->send_confirmation_password($usuario->CUSTOMER_EMAIL, $password);
					
					//Modificar información
					$updatedata = array(
									'CUSTOMER_PASSWORD' 	=> sha1($password)
									);
					if($this->myprofile_model->update($updatedata, $usuario->ID)):
						$this->fw_alerts->add_new_alert(6012);
						redirect('login');
					else:
						$this->fw_alerts->add_new_alert(6011);
					endif;
					
					
				}else{
					$this->fw_alerts->add_new_alert(6010);
					redirect('login');
				}
			endif;
			
			
		 	$this->load->template('recuperar');
		 }
}
