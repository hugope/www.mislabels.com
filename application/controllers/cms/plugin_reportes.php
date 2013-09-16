<?php
/**
 * @author 	Guido A. Orellana
 * @name	Plugin_users
 * @since	mayo 2013
 * 
 */
class Plugin_reportes extends PL_Controller {
	
	function __construct(){
		parent::__construct();
		
		//Load the plugin data
		$this->plugin_action_table			= 'PLUGIN_ORDERS';
		$this->plugin_button_create			= "Crear Nuevo Reporte";
		$this->plugin_button_cancel			= "Cancelar";
		$this->plugin_button_update			= "Guardar Cambios";
		$this->plugin_button_delete			= "Eliminar";
		$this->plugin_page_title			= "Reportes";
		$this->plugin_page_create			= "Crear Nuevo Reporte";
		$this->plugin_page_read				= "Mostrar Reporte";
		$this->plugin_page_update			= "Editar Reporte";
		$this->plugin_page_delete			= "Eliminar";
		
		$this->template_display				= 'plugin_display_reports';
		
		$this->plugin_display_array[0]		= "ID";
		$this->plugin_display_array[1]		= "Par&aacute;metro";
		
		$this->plugins_model->initialise($this->plugin_action_table);
		
		//Extras to send
		$this->display_pagination			= FALSE; //Mostrar paginación en listado
		$this->pagination_per_page			= 0; //Numero de registros por página
		$this->pagination_total_rows		= 0; //Número total de items a desplegar
		
		$this->display_filter				= FALSE; //Mostrar filtro de búsqueda 'SEARCH' o según listado 'LIST' o no mostrar FALSE
		
		//Obtener el profiler del plugin
		$this->output->enable_profiler(FALSE);
	}
	
	
	/**
	 * Funciones para editar Querys o Datos a enviar desde cada plugin
	 */
	//Función para desplegar listado, desde aquí se puede modificar el query
	public function _plugin_display($date_filter){
		$filter			= ($date_filter != 'COMPLETE' && $date_filter != '')?explode('-',$date_filter):'COMPLETE';
		
		$result_array['reportes'] 	= array(
									'&Oacute;rdenes',
									'Usuarios',
									'Etiquetas'
									);
		$result_array['filter']		= $filter;
		return $this->_html_plugin_display($result_array);
	}
	
	/**
	 * Función para desplegar listado completo de datos guardados, enviar los títulos en array con clave header y el cuerpo en un array con clave body.
	 * Para editar fila es a la función 'update_table_row'
	 * 
	 * @param	$result_array 		array 		Array con la listado devuelto por query de la DB
	 * @return	$data_array 		array 		Arreglo con la información del header y body
	 */
	public function _html_plugin_display($result_array){
		$this->load->helper('utilities');
		
		$data_array['componentes_fecha'] 	= date_components(); //Componentes del filtro
		$data_array['reportes']				= $result_array['reportes']; //Tipos de reportes
		$data_array['segment']				= ($this->uri->segment(4) != '')?$this->uri->segment(4):date('m-Y');
		$data_array['month']				= (is_array($result_array['filter']))?$result_array['filter'][0]:date('m');
		$data_array['year']					= (is_array($result_array['filter']))?$result_array['filter'][1]:date('Y');	
		
		return $data_array;
	}
	
	/*
	 * Función para crear nuevo contenido, desde aquí se especifican los campos a enviar en el formulario.
	 * El formulario se envía mediante objectos preestablecidos de codeigniter. 
	 * El formulario se envía con un array con la clave form_html.
	 * Se puede encontrar una guía en: http://ellislab.com/codeigniter/user-guide/helpers/form_helper.html
	 */
	public function _html_plugin_create(){
        
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'SHIPPING_PARAMETER', 'class' => 'span6'))."</div></div>";
		
		return $data_array;
    }
	public function _html_plugin_update($result_data){
		
		//Formulario
		$data_array['form_html']			= "<div class='control-group'>".form_label($this->plugin_display_array[1],'',array('class' => 'control-label'))."<div class='controls'>".form_input(array('name' => 'SHIPPING_PARAMETER', 'value' => $result_data->SHIPPING_PARAMETER, 'class' => 'span6'))."</div></div>";
		
		return $data_array;
	}
	
	//Funciones de los posts a enviar
	public function post_new_val(){
		$submit_posts 					= $this->input->post();
		
		return $this->_set_new_val($submit_posts);
	}
	public function post_update_val($data_id){
		$submit_posts 				= $this->input->post();
		
		return $this->_set_update_val($submit_posts);
	}
	
	/**
	 * Funciones específicas del plugin
	 */
	 public function download_excel($filter = 'COMPLETE', $file){
	 	$this->load->library('FW_export'); //Cargar la librería
		
	 	$db_data = array(
						$this->plugins_model->export_orders_data($filter),
						$this->plugins_model->export_users_data($filter),
						$this->plugins_model->export_stickers_data($filter)
						);
		$report_name = array('Reporte_de_órdenes', 'Reporte_de_usuarios', 'Reporte_de_stickers');
		
		$this->fw_export->filename = $report_name[$file];
		$this->fw_export->make_from_db($db_data[$file]);
	 }
}
