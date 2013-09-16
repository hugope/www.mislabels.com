<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_contenidos
 * @since	abril 2013
 * 
 */
class Plugin_email extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_EMAIL';
		$this->plugin_button_create			= "Crear Nuevo Email";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Emails";
		$this->plugin_page_create			= "Crear Nuevo Email";
		$this->plugin_page_read				= "Mostrar Email";
		$this->plugin_page_update			= "Editar Email";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->template_display				= "plugin_email"; //Si no se describe, se pone como default "plugin_display"
		
		$this->plugin_image_route			= "/user_files/uploads/images/";
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Imagen del encabezado";
		$this->plugin_display_array[2]		= "Nombre de la empresa";
		$this->plugin_display_array[3]		= "Tel&eacute;fono de la empresa";
		$this->plugin_display_array[4]		= "Email de la empresa";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= FALSE; //Mostrar paginaci�n en listado
		$this->pagination_per_page			= 0; //Numero de registros por p�gina
		$this->pagination_total_rows		= 0; //N�mero total de items a desplegar
		
		$this->display_filter				= FALSE; //Mostrar filtro de b�squeda 'SEARCH' o seg�n listado 'LIST' o no mostrar FALSE
	}
	
	/**
	 * Funci�n para desplegar listado completo de datos guardados, enviar los t�tulos en array con clave header y el cuerpo en un array con clave body.
	 * Para editar fila es a la funci�n 'update_table_row'
	 * 
	 * @param	$result_array 		array 		Array con la listado devuelto por query de la DB
	 * @return	$data_array 		array 		Arreglo con la informaci�n del header y body
	 */
	public function _html_plugin_display(){
		
		//Formulario con datos generales de los correos
		$data_array['email_resource'] 	= form_open_multipart('cms/'.strtolower($this->current_plugin).'/post_update_resource/', array('class' => 'form-horizontal'));
		
		$data_array['email_resource']	.= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_upload(array('name' => 'EMAIL_HEADER'))."<img src='".base_url($this->fw_resource->request('RESOURCE_EMAIL_IMAGE_ROUTE'))."' style='width:260px; margin-left:20px;' alt='Email header' /></div></div>";
		$data_array['email_resource']	.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'RESOURCE_COMPANY_NAME', 'value' => $this->fw_resource->request('RESOURCE_COMPANY_NAME'), 'class' => 'span6'))."</div></div>";
		$data_array['email_resource']	.= "<div class='control-group'>".form_label($this->plugin_display_array[3],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'RESOURCE_COMPANY_PHONE', 'value' => $this->fw_resource->request('RESOURCE_COMPANY_PHONE'), 'class' => 'span6'))."</div></div>";
		$data_array['email_resource']	.= "<div class='control-group'>".form_label($this->plugin_display_array[4],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'RESOURCE_CONTACT_EMAIL', 'value' => $this->fw_resource->request('RESOURCE_CONTACT_EMAIL'), 'class' => 'span6'))."</div></div>";
		
		$data_array['email_resource']	.= '<div class="form-actions">';
		$data_array['email_resource']	.= form_submit(array('value' => $this->plugin_button_update, 'class' => 'btn btn-primary', 'name' => 'POST_SUBMIT')).' ';
		$data_array['email_resource']	.= anchor('cms/'.strtolower($this->current_plugin), $this->plugin_button_cancel, array('class'=>'btn')).' ';
		$data_array['email_resource']	.= '</div>';
		//Header data
		$data_array['header'][1]			= $this->plugin_display_array[1];
		
		//Body data
		$data_array['body'] = '';
		
		return $data_array;
	}
	
	/*
	 * Funci�n para crear nuevo contenido, desde aqu� se especifican los campos a enviar en el formulario.
	 * El formulario se env�a mediante objectos preestablecidos de codeigniter. 
	 * El formulario se env�a con un array con la clave form_html.
	 * Se puede encontrar una gu�a en: http://ellislab.com/codeigniter/user-guide/helpers/form_helper.html
	 */
	public function _html_plugin_create(){
        
		//Datos fijos
		$data_array['page_title'] 			= $this->plugin_page_title;
		$data_array['page_subtitle']		= $this->plugin_button_create;
		
		//Datos a enviar
		$options_values_array 				= $this->display_cateogries_array();
		
		//Formulario
		$data_array['form_html']			=  form_open('cms/'.strtolower($this->current_plugin).'/post_new_val', array('class' => 'form-horizontal'));
		
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CATEGORY_NAME', 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('CATEGORY_PARENT', $options_values_array)."</div></div>";
		
		$data_array['form_html']			.= '<div class="form-actions">'.form_submit(array('value' => $this->plugin_button_create, 'class' => 'btn btn-primary', 'name' => 'POST_SUBMIT')).' '.anchor('cms/'.strtolower($this->current_plugin), $this->plugin_button_cancel, array('class'=>'btn')).'</div>';
		
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		//Datos fijos
		$data_array['page_title'] 			= $this->plugin_page_title;
		$data_array['page_subtitle']		= $this->plugin_page_update;
		
		//Datos a enviar
		$options_values_array 				= $this->display_cateogries_array();
		
		
		//Formulario
		$data_array['form_html']			=  form_open('cms/'.strtolower($this->current_plugin).'/post_update_val/'.$result_data->ID, array('class' => 'form-horizontal'));
		
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'CATEGORY_NAME', 'value' => $result_data->CATEGORY_NAME, 'class' => 'span6'))."</div></div>";
		$data_array['form_html']			.= "<div class='control-group'>".form_label($this->plugin_display_array[2],'',array('class' => 'control-label'))."<div class='controls'>".form_dropdown('CATEGORY_PARENT', $options_values_array, $result_data->CATEGORY_PARENT)."</div></div>";
		
		$data_array['form_html']			.= '<div class="form-actions">';
		$data_array['form_html']			.= form_submit(array('value' => $this->plugin_button_update, 'class' => 'btn btn-primary', 'name' => 'POST_SUBMIT')).' ';
		$data_array['form_html']			.= form_submit(array('value' => $this->plugin_button_delete, 'class' => 'btn btn-danger', 'name' => 'POST_SUBMIT')).' ';
		$data_array['form_html']			.= anchor('cms/'.strtolower($this->current_plugin), $this->plugin_button_cancel, array('class'=>'btn')).' ';
		$data_array['form_html']			.= '</div>';
		
		return $data_array;
	}
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Funci�n para desplegar listado, desde aqu� se puede modificar el query
	public function _plugin_display($filter, $offset){
		return $this->_html_plugin_display();
	}
	//Funciones de los posts a enviar
	public function post_new_val(){
		$submit_posts 				= $this->input->post();
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 				= $this->input->post();
		$submit_posts['ID']			= $data_id;
		
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones espec�ficas del plugin
	 */
	public function post_update_resource(){
		if(!$this->input->post()):
			$this->fw_alerts->add_new_alert(9990);
		else:
			//Si se carga una imagen
			if(!empty($_FILES["EMAIL_HEADER"]["name"])):
				$upload_config['upload_path'] 		= '.'.$this->plugin_image_route;
				$upload_config['overwrite']			= TRUE;
				$upload_config['allowed_types'] 	= 'gif|jpg|png';
				$upload_config['max_width']  		= '550';
				$upload_config['max_height'] 		= '60';
				$this->upload->initialize($upload_config);
				
				if (!$this->upload->do_upload('EMAIL_HEADER')):
					$this->fw_alerts->add_new_alert(4002);
				else:
					$uploaded_data = $this->upload->data();
					$update_data['RESOURCE_EMAIL_IMAGE_ROUTE'] = $this->plugin_image_route.$uploaded_data['file_name'];
					$this->fw_alerts->add_new_alert(4001);
				endif;
			endif;
			
			//Enviar los datos a actualizar
			$update_data['RESOURCE_COMPANY_NAME']		= $this->input->post('RESOURCE_COMPANY_NAME');
			$update_data['RESOURCE_COMPANY_PHONE']		= $this->input->post('RESOURCE_COMPANY_PHONE');
			$update_data['RESOURCE_CONTACT_EMAIL']		= $this->input->post('RESOURCE_CONTACT_EMAIL');
			$alert_key = $this->plugins_model->update_email_data($update_data); //Actualizar la informaci�n de los correos
			$this->fw_alerts->add_new_alert($alert_key); //Mostrar el resultado de la actualizaci�n
			
			redirect('cms/plugin_email');
		endif;
	}
}
