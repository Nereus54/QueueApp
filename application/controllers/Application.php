<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Controller
{	
	protected $_service_list_path = null;
	
	protected $_file_storage_path = null;


	public function _init()
	{
		$ci = get_instance();
		$ci->load->config('config');
		
		$this->_service_list_path = $ci->config->item('service_list_path');
		$this->_file_storage_path = $ci->config->item('file_storage_path');
	}
	
	public function index()
	{
		$this->_init();
		
		$this->load->helper('form');
		$this->load->model('service_model');
		$this->load->model('file_storage_model');
		
		$this->file_storage_model->setStoragePath($this->_file_storage_path);
		
		if ( !empty($this->input->post('save_customer')) )
		{
			$customer_data = array(
				'service_option'	=> ( !empty($this->input->post('service_option')) ) ? $this->input->post('service_option') : null,
				'customer_type'		=> ( !empty($this->input->post('customer_type')) ) ? $this->input->post('customer_type') : null,
				'organisation'		=> ( !empty($this->input->post('organisation')) ) ? $this->input->post('organisation') : null,
				'title'				=> ( !empty($this->input->post('title')) ) ? $this->input->post('title') : null,
				'first_name'		=> ( !empty($this->input->post('first_name')) ) ? $this->input->post('first_name') : null,
				'last_name'			=> ( !empty($this->input->post('last_name')) ) ? $this->input->post('last_name') : null,
				'time'				=> date('H:i'),
			);
			
			$this->file_storage_model->save($customer_data);
		}
		
		if ( !empty($this->input->post('clear_queue')) )
		{
			$this->file_storage_model->deleteAll();
		}
		
		$service_list = $this->service_model->loadServiceList($this->_service_list_path);
		$queue_list = $this->file_storage_model->load();
		
		$data = array(
			'service_list' => $service_list,
			'queue_list' => $queue_list,
		);
		
		$this->load->view('templates/header', array('title' => 'Queue App'));
		$this->load->view('scripts/application', $data);
		$this->load->view('templates/footer');
	}

}
