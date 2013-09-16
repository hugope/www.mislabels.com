<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_users
 * @since	mayo 2013
 * 
 */
class Plugin_orders extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the libraries
		$this->load->library('email');
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_SHOPPING_CART';
		$this->plugin_button_create			= "Crear Nueva Orden";
		$this->plugin_button_cancel			= "Cancelar Orden";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "&Oacute;rdenes";
		$this->plugin_page_create			= "Crear Nueva Orden";
		$this->plugin_page_read				= "Mostrar Orden";
		$this->plugin_page_update			= "Editar Orden";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->template_display				= "plugin_display_orders";
		$this->template_update				= "plugin_update_orders";
		
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "C&oacute;digo";
		$this->plugin_display_array[2]		= "Carrito de compra";
		$this->plugin_display_array[3]		= "Usuario";
		$this->plugin_display_array[4]		= "Fecha de creaci&oacute;n";
		$this->plugin_display_array[5]		= "Status";
		$this->plugin_display_array[6]		= "Fecha de entrega";
		$this->plugin_display_array[7]		= "Direcci&oacute;n de entrega";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= TRUE; //Mostrar paginación en listado
		$this->pagination_per_page			= 10; //Numero de registros por página
		$this->pagination_total_rows		= 0; //Número total de items a desplegar
		
		$this->display_filter				= 'LIST'; //Mostrar filtro de búsqueda 'SEARCH' o según listado 'LIST' o no mostrar FALSE
		
		//Obtener el profiler del plugin
		$this->output->enable_profiler(FALSE);
		
		
		//List filter
		$this->filteroptions				= array('EN_PROCESO' => 'En Proceso',
													'PENDIENTE' => 'Pendiente',
													'CANCELADO' => 'Cancelado',
													'ENTREGADO' => 'Entregado'
													);
	}
	
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Función para desplegar listado, desde aquí se puede modificar el query
	public function _plugin_display($filter, $offset){
		$filter				= ($filter != 'display_all' && $filter != '')?$filter:'EN_PROCESO';
		$this->pagination_total_rows = $this->plugins_model->total_rows("SHOPPING_STATUS = '$filter'");
		
		$result_array 		= array();
		$result_array 		= $this->plugins_model->list_rows('', "SHOPPING_STATUS = '$filter'", $this->pagination_per_page, $offset, 'SHOPPING_DATECREATED DESC, ID DESC');
		
		return $this->_html_plugin_display($result_array, $filter);
	}
	
	/**
	 * Función para desplegar listado completo de datos guardados, enviar los títulos en array con clave header y el cuerpo en un array con clave body.
	 * Para editar fila es a la función 'update_table_row'
	 * 
	 * @param	$result_array 		array 		Array con la listado devuelto por query de la DB
	 * @return	$data_array 		array 		Arreglo con la información del header y body
	 */
	public function _html_plugin_display($result_array, $filter){
		
		//Header data
		$data_array['header'][1]			= $this->plugin_display_array[1];
		$data_array['header'][2]			= $this->plugin_display_array[3];
		$data_array['header'][4]			= $this->plugin_display_array[4];
		
		//Body data
		$data_array['body'] = '';
		foreach($result_array as $field):
		$orderArray							= array('date' => $field->SHOPPING_DATECREATED, 'ID' => $field->ID);
		$data_array['body']					.= '<tr>';
		$data_array['body']					.= '<td><a href="'.base_url('cms/'.strtolower($this->current_plugin).'/update_table_row/'.$field->ID).'">'.($this->fw_utilities->get_order_code($orderArray)).'</a></td>';
		$data_array['body']					.= '<td>'.$this->get_user_data($field->SHOPPING_CUSTOMERID).'</td>';
		$data_array['body']					.= '<td>'.$this->fw_utilities->mysql_date_to_dmy($field->SHOPPING_DATECREATED).'</td>';
		$data_array['body']					.= '</tr>';
		endforeach;
		
		//List filter
		$data_array['filteroptions']		= $this->filteroptions;
		$data_array['filter'] = $filter;
		
		return $data_array;
	}
	
	/*
	 * Función para crear nuevo contenido, desde aquí se especifican los campos a enviar en el formulario.
	 * El formulario se envía mediante objectos preestablecidos de codeigniter. 
	 * El formulario se envía con un array con la clave form_html.
	 * Se puede encontrar una guía en: http://ellislab.com/codeigniter/user-guide/helpers/form_helper.html
	 */
	public function _html_plugin_create(){
       return NULL;
    }
	public function _html_plugin_update($result_data){
		$orderInfo = $this->plugins_model->get_single_order($result_data->ID);
		
		//Información General
		$data_array['SHOPPING_ID']				= $orderInfo->ID;
		$data_array['SHOPPING_CODE']			= $this->fw_utilities->get_order_code(array('ID' => $orderInfo->ID, 'date' => $orderInfo->SHOPPING_DATECREATED));
		$data_array['CUSTOMER_NAME']			= $orderInfo->CUSTOMER_NAME;
		$data_array['CUSTOMER_EMAIL']			= $orderInfo->CUSTOMER_EMAIL;
		$data_array['SHOPPING_DATECREATED']		= $this->fw_utilities->mysql_date_to_dmy($orderInfo->SHOPPING_DATECREATED);
		$data_array['SHOPPING_STATUS_OPTIONS']	= $this->filteroptions;
		$data_array['SHOPPING_STATUS']			= $orderInfo->SHOPPING_STATUS;
		$data_array['SHOPPING_SHIPPINGDATE']	= $orderInfo->SHOPPING_SHIPPINGDATE;
		
		//Stickers compradas
		$data_array['STICKERS_CART']			= $orderInfo->SHOPPING_CART;
		//Boton de submit
		$data_array['submit_button']			= $this->plugin_button_update;
		
		return $data_array;
	}
	
	//Funciones de los posts a enviar
	public function post_new_val(){
		return NULL;
	}
	public function post_update_val($data_id){
		
		$submit_posts 				= $this->input->post();
		$submit_posts['POST_ID']	= $data_id;
		
		//Send email
		$this->fw_posts->order_status_notification($data_id, $submit_posts['CUSTOMER_EMAIL']);
		unset($submit_posts['CUSTOMER_EMAIL']);
		
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones específicas del plugin
	 */
	 private function get_user_data($costumerId){
	 	$data['TABLE'] 		= 'PLUGIN_CUSTOMERS';
	 	$data['COLUMN_VAR'] = $costumerId;
	 	$query = $this->plugins_model->get_single_row($data);
		
		$fullname = $query->CUSTOMER_NAME.' '.$query->CUSTOMER_LASTNAME;
		
		return $fullname;
	 }
	//Plantilla de impresión
	public function print_order($order){
		$data['ORDER_DATA'] 	= $this->plugins_model->get_single_order($order);
		$data['SHOPPING_CODE']	= $this->fw_utilities->get_order_code(array('ID' => $data['ORDER_DATA']->ID, 'date' => $data['ORDER_DATA']->SHOPPING_DATECREATED));
		
		
		$this->load->view('cms/print_order', $data);
	}
}
