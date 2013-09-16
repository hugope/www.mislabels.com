<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/**
 * Librería con mensajes de alerta
 */
class FW_alerts {
	var $FW;
	public function __construct(){
		$this->FW			=& get_instance();
	}
	
	/**
	 * Mensajes a desplegar en las alertas
	 * 
	 * $return_message[key] = Mensaje a desplegar segun el key asignado.
	 */
	private function alerts_messages_array($key){
		//Login messages
		$return_message[1001]				= "<h4>Error al iniciar sesi&oacute;n</h4>Los datos de su sesi&oacute;n no coinciden, por favor intente nuevamente.";
		$return_message[1002]				= "<h4>Sesi&oacute;n expirada</h4> Ha salido de su sesi&oacute;n, por favor vuelva a ingresar.";
		$return_message[1003]				= "<h4>Sesi&oacute;n ingresada</h4> Ha ingresado a su sesi&oacute;n satisfactoriamente.";
		//Mi perfil
		$return_message[2001]				= "<h4>Informaci&oacute;n actualizada</h4> Se han actualizado sus datos de usuario satisfactoriamente, por favor vuelva a auntenticarse.";
		//Permisos
		$return_message[9990]				= "<h4>Ingreso incorrecto</h4> No puede ingresar a esta &aacute;rea directamente.";
		//Email notifications
		$return_message[3001]				= "<h4>Mensaje enviado</h4> Su mensaje ha sido enviado exitosamente.";
		$return_message[3002]				= "<h4>Error enviando mensaje</h4> Hubo alg&uacute;n error al enviar su mensaje, por favor intente nuevamente.";
		$return_message[3003]				= "<h4>Error enviando mensaje</h4> Los campos del formulario vienen vac&iacute;os, por favor completar los campos requeridos.";
		$return_message[3004]				= "<h4>Error enviando mensaje</h4> Revisar que todos los campos requeridos est&eacute;n debidamente llenos.";
		//Upload notifications
		$return_message[4001]				= "<h4>Archivo cargado</h4> Su archivo ha sido cargado exitosamente.";
		$return_message[4002]				= "<h4>Error al cargar archivo</h4> Su archivo no ha sido cargado, esto puede deberse a que no cumple con los par&aacute;metros establecidos. Por favor, revise que su archivo es v&aacute;lido e intente cargarlo nuevamente.";
		//CRUD notifications
		$return_message[4010]				= "<h4>Datos cambiados</h4> Su informaci&oacute;n ha sido actualizada exitosamente.";
		$return_message[4011]				= "<h4>Error al cambiar datos</h4> Su informaci&oacute;n no ha podido ser actualizada exitosamente.";
		$return_message[4012]				= "<h4>Datos Eliminados</h4> Su informaci&oacute;n ha sido eliminada exitosamente.";
		$return_message[4013]				= "<h4>Datos Ingresados</h4> Su informaci&oacute;n ha sido ingresada exitosamente.";
		//Email confirmation code
		$return_message[5001]				= 'No ha podido enviarse el c&oacute;dio de verificaci&oacute;n al correo electr&oacute;nico. Verifica haber ingresado todos los campos correctamente y aceptado los t&eacute;rminos y condiciones.';
		$return_message[5002]				= "Se ha enviado un enlace de verificaci&oacute;n a su cuenta de correo electr&oacute;nico.";
		$return_message[5003]				= "No se ha podido verificar su cuenta de correo electr&oacute;nico.";
		$return_message[5004]				= "Se ha verificado tu email exitosamente, por favor ingresa con tu direcci&oacute;n de correo electr&oacute;nico y contrase&ntilde;a.";
		//Inicio de sesión
		$return_message[5005]				= "Has iniciado sesi&oacute;n correctamente, ¡Bienvenido!";
		$return_message[5006]				= "No coinciden los datos de inicio de sesi&oacute;n.";
		$return_message[5007]				= "No se ha podido iniciar sesi&oacute;n en este momento, int&eacute;ntalo nuevamente";
		$return_message[5008]				= "Has salido de tu sesi&oacute;n.";
		//Carrito de compras
		$return_message[6001]				= "Se ha agregado la etiqueta al carrito de compras.";
		$return_message[6002]				= "Hubo un problema al agregar la etiqueta.";
		$return_message[6003]				= "Se han almacenado los datos de entrega exitosamente.";
		$return_message[6004]				= "Hubo un problema al almacenar los datos de entrega; por favor, vuelva a intentarlo.";
		$return_message[6005]				= "Se han almacenado sus datos de facturaci&oacute;n exitosamente";
		$return_message[6006]				= "Hubo un problema al almacenar los datos de facturaci&oacute;n; por favor, vuelva a intentarlo.";
		$return_message[6007]				= "Se ha eliminado exitosamente la etiqueta.";
		$return_message[6008]				= "Hubo un problema al tratar de eliminar la etiqueta; por favor, vuelva a intentarlo.";
		$return_message[6009]				= "Por favor rellenar todos los campos para las etiquetas.";
		$return_message[6010]				= "No se ha encontrado esa cuenta de correo registrada, registrate en el formulario de registro";
		$return_message[6011]				= "Hubo alg&uacute;n problema al tratar de enviar la contrase&ntilde;a, por favor, int&eacute;ntelo nuevamente.";
		$return_message[6012]				= "Se ha enviado una contrase&ntilde;a a su bandeja de entrada.";
		//Perfil
		$return_message[6050]				= "Se han cambiado sus datos del perfil exitosamente";
		$return_message[6051]				= "Hubo un problema al intentar actualizar sus datos del perfil; por favor, vuelva a intentarlo.";
		$return_message[6052]				= "Se ha cambiado exitosamente su contrase&ntilde;a;por favor, vuelva a auntenticarse.";
		$return_message[6053]				= "Hubo alg&uacute;n problema al cambiar su contrase&ntilde;a; por favor, vuelva a intentarlo.";
		
		return $return_message[$key];
	}
	
	/**
	 * Tipos de alerta a desplegar
	 * 
	 * $return_type[key] = Tipo de alerta a mostrar según key asignado, por default se asigna mensaje de warning.
	 * 
	 * Tipos de alerta:
	 * $this->alert_type['ERROR']		= Alerta roja, que muestra algún error o peligro de mal uso.
	 * $this->alert_type['SUCCESS']		= Alerta verde, que muestra exito en algún proceso
	 * $this->alert_type['INFO']		= Alerta azul, que muestra información que se requiera mostrar.
	 * $this->alert_type['WARNING']		= Alerta amarilla, que muestra datos que pueden causar algún error.
	 * 
	 */
	public function alerts_types_array($key){
		//Login messages
		$return_type[1001]					= $this->alert_type('ERROR');
		$return_type[1002]					= $this->alert_type('WARNING');
		$return_type[1003]					= $this->alert_type('SUCCESS');
		//Mi perfil
		$return_type[2001]					= $this->alert_type('SUCCESS');
		//Permisos
		$return_type[9990]					= $this->alert_type('ERROR');
		$return_type[9991]					= $this->alert_type('ERROR');
		//Email notifications
		$return_type[3001]					= $this->alert_type('SUCCESS');
		$return_type[3002]					= $this->alert_type('ERROR');
		$return_type[3003]					= $this->alert_type('ERROR');
		$return_type[3004]					= $this->alert_type('ERROR');
		//Upload notifications
		$return_type[4001]					= $this->alert_type('SUCCESS');
		$return_type[4002]					= $this->alert_type('ERROR');
		//CRUD notifications
		$return_type[4010]					= $this->alert_type('SUCCESS');
		$return_type[4011]					= $this->alert_type('ERROR');
		$return_type[4012]					= $this->alert_type('SUCCESS');
		$return_type[4013]					= $this->alert_type('SUCCESS');
		//Email confirmation code
		$return_type[5001]					= $this->alert_type('ERROR');
		$return_type[5002]					= $this->alert_type('SUCCESS');
		$return_type[5003]					= $this->alert_type('ERROR');
		$return_type[5004]					= $this->alert_type('SUCCESS');
		$return_type[5005]					= $this->alert_type('SUCCESS');
		$return_type[5006]					= $this->alert_type('ERROR');
		$return_type[5007]					= $this->alert_type('ERROR');
		$return_type[5008]					= $this->alert_type('ERROR');
		//Carrito de compras
		$return_type[6001]					= $this->alert_type('SUCCESS');
		$return_type[6002]					= $this->alert_type('ERROR');
		$return_type[6003]					= $this->alert_type('SUCCESS');
		$return_type[6004]					= $this->alert_type('ERROR');
		$return_type[6005]					= $this->alert_type('SUCCESS');
		$return_type[6006]					= $this->alert_type('ERROR');
		$return_type[6007]					= $this->alert_type('SUCCESS');
		$return_type[6008]					= $this->alert_type('ERROR');
		$return_type[6009]					= $this->alert_type('ERROR');
		$return_type[6010]					= $this->alert_type('ERROR');
		$return_type[6011]					= $this->alert_type('ERROR');
		$return_type[6012]					= $this->alert_type('SUCCESS');
		//Perfil
		$return_type[6050]					= $this->alert_type('SUCCESS');
		$return_type[6051]					= $this->alert_type('ERROR');
		$return_type[6052]					= $this->alert_type('SUCCESS');
		$return_type[6053]					= $this->alert_type('ERROR');
		
		if(array_key_exists($key, $return_type)):
			return $return_type[$key];
		else:
			return $this->alert_type('WARNING');
		endif;
	}
	
	/**
	 * Funciones especificas para desplegar mensajes
	 */
    public function add_new_alert($alert_key){
    	$alerts_string		= $this->FW->session->userdata('FRAMEWORK_RESOURCE_ALERTS');
    	$alerts_string 		.= $alert_key."||";
		
		$this->create_session_alert($alerts_string);
    }
	private function create_session_alert($alerts_string){
		
    	$this->FW->session->set_userdata('FRAMEWORK_RESOURCE_ALERTS', $alerts_string);
	}
	
	public function display_alert_message(){
		
		if($this->FW->session->userdata('FRAMEWORK_RESOURCE_ALERTS')):
			$messages_array 	= explode("||", $this->FW->session->userdata('FRAMEWORK_RESOURCE_ALERTS'));//Obtenemos cada mensaje en un array
			$html_alert			= ''; //Constriumos la variable que contendrá las alertas.
			
			foreach($messages_array as $message):
				if(!empty($message)):
					$html_alert		.=	'<div class="alert alert-block fade in '.$this->alerts_types_array($message).'">';
					$html_alert		.=	'<button type="button" class="close" data-dismiss="alert">&times;</button>';
					$html_alert		.=	$this->alerts_messages_array($message);
					$html_alert		.=	'</div>';
				endif;
			endforeach;
			
			$this->FW->session->unset_userdata('FRAMEWORK_RESOURCE_ALERTS');
			return $html_alert;
		else:
			return null;
		endif;
	}
	private function alert_type($type = 'WARNING'){
		$return_class_type		= array(
									'ERROR'		=> 'alert-error',
									'SUCCESS'	=> 'alert-success',
									'INFO'		=> 'alert-info',
									'WARNING'	=> ''
									);

		if(array_key_exists($type, $return_class_type)):
			return $return_class_type[$type];
		else:
			return $return_class_type['WARNING'];
		endif;
	}
}
