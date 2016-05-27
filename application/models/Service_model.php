<?php

class Service_model extends CI_Model
{
	public function __construct()
	{
		// Do nothing...
	}
	
	public function loadServiceList($filename)
	{
		$return_list = array();
		
		if ( false !== file_exists($filename) )
		{
			$return_list = json_decode(file_get_contents($filename), true);
		}
		
		return $return_list;
	}
	
}