<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* PyroCMS - Module Hello World Example 
* @exampleurl : http://github.com/bhu1st
* @author : bhupal sapkota (http://bhu1st.blogspot.com)
* 
*/

/*
|-------------------------------------
| Model Class of our module
|-------------------------------------
| for database access
|
*/

class Helloworld_m extends Model
{
	
	
	function __construct()
	{
		parent::Model();
	}
	
	function getHelloMsg()
	{	
		//get hello_world table
		$query = $this->db->get('hello_world');
		
		//if module successfully installed and data exists in table, grab it, return it
		if($query->num_rows() > 0){
			$result = $query->row_array();
			return $result['msg'];	
		}else { //otherwise return simple hello message		
			return "Hello world from PyroCMS Module!";
		}
		
	}
	
	
}
?>