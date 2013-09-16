<?php
/**
 * Agregar un arreglo, con arreglos por cada campo del formulario a validar. Para validar los campos del formulario se deben agregar:
 * 		[field] => Nombre del campo
 * 		[label] => Nombre a desplegar en caso de error
 * 		[rules] => Reglas a asignar para la validación
 */
$config = array(
	'FRAMEWORK_ASSISTANCE' => array(
		array(
			'field' => 'inputName',
			'label' => 'Nombre',
			'rules' => 'required'
		),
		array(
			'field' => 'inputEmail',
			'label' => 'Email',
			'rules' => 'required|valid_email'
		),
		array(
			'field' => 'inputMessage',
			'label' => 'Mensaje',
			'rules' => 'required'
		)
	),
	'FRAMEWORK_USER_REGISTRATION' => array(
		array(
			'field' => 'CUSTOMER_NAME',
			'label'	=> 'Nombre',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_LASTNAME',
			'label'	=> 'Apellido',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_EMAIL',
			'label'	=> 'Email',
			'rules' => 'required|valid_email|callback_email_check'
		),
		array(
			'field' => 'CUSTOMER_PASSWORD',
			'label'	=> 'Contrase&ntilde;a',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_PASSWORD_CONFIRMATION',
			'label'	=> 'Confirmaci&oacute;n de contrase&ntilde;a',
			'rules' => 'required|matches[CUSTOMER_PASSWORD]'
		),
		array(
			'field' => 'CUSTOMER_TERMS_ACCEPTANCE',
			'label' => 'aceptar terminos y condiciones',
			'rules' => 'required'
		)
	),
	'USER_INFO_EDIT' => array(
		array(
			'field' => 'CUSTOMER_NAME',
			'label' => 'Nombre',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_LASTNAME',
			'label' => 'Apellido',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_COUNTRY',
			'label' => 'Pa&iacute;s',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_ADDRESS',
			'label' => 'Direcci&oacute;n',
			'rules' => 'required'
		)
	),
	'USER_PASSWORD_EDIT' => array(
		array(
			'field' => 'CUSTOMER_PASSWORD',
			'label'	=> 'Contrase&ntilde;a',
			'rules' => 'required'
		),
		array(
			'field' => 'CUSTOMER_PASSWORD_CONFIRMATION',
			'label'	=> 'Confirmaci&oacute;n de contrase&ntilde;a',
			'rules' => 'required|matches[CUSTOMER_PASSWORD]'
		)
	)
);