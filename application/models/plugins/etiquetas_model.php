<?php
/**
 * Plugin con los querys para obtener datos del catálogo de etiquetas
 */
class Etiquetas_model extends MY_Model {
	
	protected $_sticker_set;
	function __construct() {
		parent::__construct();
		$this->set_table('PLUGIN_STICKERS');
		
		$this->_sticker_set = array(
								12 => 'tipo_a',
								13 => 'tipo_b',
								14 => 'tipo_c',
								15 => 'tipo_d',
								16 => 'tipo_e',
								17 => 'tipo_f',
								18 => 'tipo_g',
								19 => 'tipo_h',
								20 => 'tipo_i'
								);
	}
	
	/**
	 * Obtener los sets de las etiquetas
	 * @param	Array	$current	Array con ID's de los sets seleccionados.
	 * @return 	Object				Objeto con los sets y su parámetro como activo.
	 */
	 public function label_sets_list(){
	 	$current = ($this->session->userdata('sets_session'))?json_decode($this->session->userdata('sets_session'), TRUE):array();
		
	 	$query = $this->db->select('ID, LABEL, PATH')
		->from('CMS_PAGES')
		->where('PAGE_PARENT', 11)
		->order_by('ID', 'ASC')->get();
		$label_sets = $query->result();
		
		foreach($label_sets as $i => $label_set):
			$label_sets[$i]->ACTIVE = (!empty($current))?in_array($label_set->ID, $current):TRUE;
		endforeach;
		
		return $label_sets;
	 }
	 /**
	  * Obtener la primera categoría
	  */
	public function get_first_category(){
		$query = $this->db->select('CATEGORY_NAME')
		->from('PLUGIN_CATEGORIES')
		->order_by('ID', 'ASC')
		->limit(1)->get();
		$firstCat = $query->row();
		
		return strtolower(convert_accented_characters($firstCat->CATEGORY_NAME));
	}
	/**
	 * Obtener los sets de las etiquetas
	 * @param	Array	$current	Array con ID's de los sets seleccionados.
	 * @return 	Object				Objeto con los sets y su parámetro como activo.
	 */
	 public function categories_list(){
	 	$current = ($this->session->userdata('sets_categories'))?json_decode($this->session->userdata('sets_categories'), TRUE):array();
		
	 	$query = $this->db->select('ID, CATEGORY_NAME, CATEGORY_COLOR')
		->from('PLUGIN_CATEGORIES')
		->order_by('ID', 'ASC')->get();
		$categories = $query->result();
		
		foreach($categories as $i => $cat):
			$categories[$i]->ACTIVE = (!empty($current))?in_array($cat->ID, $current):TRUE;
		endforeach;
		
		return $categories;
	 }
	 /**
	  * Obtener las etiquetas
	  */
	  public function list_stickers($limit, $offset, $search = NULL){
	  	
		$query = $this->stickers_query_object(FALSE, $limit, $offset, $search);
		$stickers = $query->result();
		
		foreach($stickers as $i => $sticker):
			//Poner imágenes como array
			$stickers[$i]->STICKER_IMAGES 	= json_decode($sticker->STICKER_IMAGES, TRUE);
			//Poner imágenes como array
			$stickers[$i]->STICKER_GALLERY 	= json_decode($sticker->STICKER_GALLERY, TRUE);
			//Mostrar tipo de etiquetas según set
			$stickers[$i]->STICKER_SET		= $this->_sticker_set[$sticker->STICKER_SET];
		endforeach;
		
		return $stickers;
	  }
	  /**
	   * Obtener el total de filas
	   */
	  public function stickers_total_rows($search = NULL){
	  	
		$query 		= $this->stickers_query_object(TRUE, 10, 0, $search);
		$stickers 	= $query->row();
		
		return $stickers->TOTAL;
	  }
	   
	/**
	 * Query de las stickers
	 */
	 private function stickers_query_object($total = TRUE, $limit = 10, $offset = 0, $search = NULL){
	  	//Obtener los sets y categorías
	  	$sets_session	= ($this->session->userdata('sets_session'))?$this->session->userdata('sets_session'):'["12","13","14","15"]';
	  	$cats_session 	= ($this->session->userdata('sets_categories'))?$this->session->userdata('sets_categories'): '[]';
		
		$sets			= json_decode($sets_session, TRUE);
		$categories		= json_decode($cats_session, TRUE);
	 	
		$select = ($total == FALSE)? 
							'PS.ID, PS.STICKER_NAME, PS.STICKER_IMAGES, PS.STICKER_PRICE, PC.CATEGORY_COLOR, PC.CATEGORY_NAME, PS.STICKER_SET, PS.STICKER_GALLERY':
							'COUNT(1) AS TOTAL';
		
	  	$sets_string		= implode(', ', $sets);
	  	$categories_string	= implode(', ', $categories);
	  			
		$query = $this->db->select($select)
		->from($this->_table.' PS')
		->join('PLUGIN_CATEGORIES PC', 'PC.ID = PS.STICKER_CATEGORY');
		if(!empty($sets))
		$query = $query->where("PS.STICKER_SET IN ($sets_string)");
		
		if(!empty($categories))
		$query = $query->where("PS.STICKER_CATEGORY IN ($categories_string)");

		if(!empty($search)):
		$query = $query->like('STICKER_DESCRIPTION', $search);
		endif;
		$query = $query->order_by('PS.ID', 'DESC');
		if($total == FALSE):
		$query = $query->limit($limit, $offset);
		endif;
		$query = $query->get();
		
		return $query;
	 }
	
	/**
	 * OBTENER INFORMACIÓN DE UNA ETIQUETA
	 */
	 public function get_single_sticker($sticker){
	 	$query = $this->db->select('PS.ID, PS.STICKER_NAME, PC.CATEGORY_NAME, PSET.LABEL, PS.STICKER_IMAGES, PS.STICKER_RADIUS, PS.STICKER_PRICE, PS.STICKER_DESCRIPTION, PS.STICKER_GALLERY, PS.STICKER_TEXT_COLOR')
		->from($this->_table.' PS')
		->join('PLUGIN_CATEGORIES PC', 'PC.ID = PS.STICKER_CATEGORY')
		->join('CMS_PAGES PSET', 'PSET.ID = PS.STICKER_SET')
		->where('PS.ID', $sticker)->get();
		
		return $query->row();
	 }
	/**
	 * Obtener los colores disponibles
	 */
	 public function get_available_colors(){
	 	$query = $this->db->from('PLUGIN_COLORS')->get();
		
		return $query->result();
	 }
	/**
	 * Obtener info de un color según etiqueta
	 */
	 public function get_color_data($label = 'PLATA'){
	 	$query = $this->db->from('PLUGIN_COLORS')
	 	->where('COLOR_LABEL', $label)->get();
		
		return $query->row();
	 }
	/**
	 * Obtener los fonts disponibles
	 */
	 public function get_available_fonts(){
	 	$query = $this->db->from('PLUGIN_FONTS')->get();
		
		foreach($query->result() as $i => $fonts):
			$group	= floor($i / 3);
			$returnFonts[$group][] = $fonts;
		endforeach;
		
		return $returnFonts;
	 }
	/**
	 * Obtener info de un font segun label
	 */
	 public function get_font_data($label = 'futura'){
	 	$query = $this->db->from('PLUGIN_FONTS')
	 	->where('FONT_LABEL', $label)->get();
		
		return $query->row();
	 }
	/**
	 * Obtener las últimas etiquetas a desplegar
	 * @param $limit Número de etiquetas a desplegar
	 * 
	 */
	 public function latest_stickers($limit = 10){
	 	$query = $this->db->from($this->_table)
		->order_by('ID DESC')->limit($limit)->get();
		
		return $this->_display_images_to_array($query->result());
	 }
	 /**
	  * Obtener las últimas 4 etiquetas mas populares
	  */
	  public function popular_stickers(){
	  	$query = $this->db->from($this->_table)
		->where('STICKER_POPULAR', 'SI')->order_by('ID DESC')
		->limit(4)->get();
		$popular = $query->result();
		$popular = $this->_display_images_to_array($popular);
		
		$stickerids = array();
		foreach($popular as $i => $sticker){
			$stickerids[]		= $sticker->ID;
		}
		
		//Quitar del listado a partir del quinto
		$this->db->where('STICKER_POPULAR', 'SI');
		$this->db->where_not_in('ID', $stickerids);
		$this->db->update($this->_table, array('STICKER_POPULAR' => 'NO'));
		
		return $popular;
	  }
	  /**
	   * Desplegar imágenes y galería como array
	   * @param Object Resultado del objeto obtenido desde el query
	   */
	   private function _display_images_to_array($stickers){
	   	
		//Desplegar las imágenes como array y obtener los ids en un array
		foreach($stickers as $i => $sticker){
			$stickers[$i]->STICKER_GALLERY	= json_decode($sticker->STICKER_GALLERY, true);
			$stickers[$i]->STICKER_IMAGES 	= json_decode($sticker->STICKER_IMAGES, true);
			$stickers[$i]->STICKER_SET 		= $this->_sticker_set[$sticker->STICKER_SET];
		}
		return $stickers;
	   }
}
