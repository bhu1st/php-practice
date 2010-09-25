<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* PyroCMS - Module Hello World Example 
* @exampleurl : http://github.com/bhu1st
* @author : bhupal sapkota (http://bhu1st.blogspot.com)
* 
*/

/*
|-------------------------------------
| Publich Controller of our module
|-------------------------------------
| accessed from front end 
|
| extends Public_Controller
*/

class Helloworld extends Public_Controller
{
	
	function __construct()
	{
		parent::Public_Controller();
		
	}

	function index()
	{
		//load model
		$this->load->model('helloworld_m');
		
		//get message from model
		$message = $this->helloworld_m->getHelloMsg();
		
		//pass message and build template
		$this->data->msg = $message;		
		$this->template->build('helloworld', $this->data);
	}


	
}