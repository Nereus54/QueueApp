<?php

class File_storage_model extends CI_Model
{ 
	const DATA_FILENAME = 'data.txt';
	
	protected $_storage_path = array();
	
    public function __construct()
    {
		parent::__construct();
    }
	
	public function setStoragePath($storage_path)
	{
		if ( false === file_exists($storage_path) )
		{
			if ( false === $this->_createPath($storage_path) )
			{
				trigger_error("Could not create path -> " . $storage_path);
			}
		}
		
		$this->_storage_path = $storage_path;
	}
	
	protected function _createPath($path)
	{
		$status = false;
		
		if ( false !== mkdir($path, 0777, true) )
		{
			$status = true;
		}
		
		return $status;
	}

	public function save($data)
	{
		$tmp_arr = array(
			'service_option'	=> ( !empty($data['service_option']) ) ? $data['service_option'] : null,
			'customer_type'		=> ( !empty($data['customer_type']) ) ? $data['customer_type'] : null,
			'name'				=> 'Anonymous',
			'time'				=> ( !empty($data['time']) ) ? $data['time'] : null,
		);
		
		if (!empty($data['organisation']) )
		{
			$tmp_arr['name'] = $data['organisation'];
		}
		elseif ( !empty($data['title']) || !empty($data['first_name']) || !empty($data['last_name']) )
		{
			$tmp_arr['name'] = $data['title'] . ' ' . $data['first_name'] . ' ' . $data['last_name'];
		}
		
		$customer_data = array(
			'customer' => $tmp_arr,
		);
		
		$all_customers_data = $this->load();
		
		if ( empty($all_customers_data) )
		{
			$customer_data_json = json_encode(array(1 => $customer_data));
		}
		else
		{
			$all_indexes_arr = array_keys($all_customers_data);
			$new_customer_index = end($all_indexes_arr) + 1;
			$customer_data = array_merge($all_customers_data, array($new_customer_index => $customer_data));
			//$customer_data = $all_customers_data[$new_customer_index] = $customer_data;
			
			$customer_data_json = json_encode($customer_data);
		}
		
		file_put_contents($this->_storage_path . File_storage_model::DATA_FILENAME, $customer_data_json);
	}
	
	public function load()
	{
		$customers_data = array();
		
		$data_filename = $this->_storage_path . File_storage_model::DATA_FILENAME;
		if ( false !== file_exists($data_filename) )
		{
			$data = file_get_contents($data_filename);
			$customers_data = json_decode($data, true);
		}
		
		return $customers_data;
	}
	
	public function deleteAll()
	{
		$status = false;
		
		$data_filename = $this->_storage_path . File_storage_model::DATA_FILENAME;
		
		if ( false !== file_exists($data_filename))
		{
			if ( false !== unlink($data_filename) )
			{
				$status = true;
			}
			else
			{
				trigger_error("Could not delete file in -> " . $data_filename);
			}
		}
		
		return $status;
	}
	
}