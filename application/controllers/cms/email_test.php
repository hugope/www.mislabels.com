<?php
/**
 * Prueba de envío de email
 */
class Email_test extends MY_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->library('email');
	}
	
	public function index(){
		$email_data = $this->fw_posts->order_status_notification('23');
		//Send email
		$this->email->from($email_data['from']['email'], 'Your Name');
		$this->email->to($email_data['to']); 
		$this->email->cc($email_data['cc']);
		
		$this->email->subject($email_data['subject']);
		$this->email->message($email_data['message']);	
		
		$this->email->send();
		
		$data_array['result'] = $this->email->print_debugger();
		
		$this->load->templatecms('cms/email_test', $data_array);
	}
}
