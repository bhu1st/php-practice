<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PyroCMS - Module Hello World Example 
 * @exampleurl : http://github.com/bhu1st
 * @author : bhupal sapkota (http://bhu1st.blogspot.com)
 *
 */
 
/*
|-------------------------------------
| Admin Controller of our module
|-------------------------------------
| accessed from back end 
| extends Admin_Controller
|
*/
 
class Admin extends Admin_Controller
{
	public function __construct()
	{
		parent::Admin_Controller();        
		
		//load model 
		$this->load->model('helloworld_m');	
		
		//set views/admin/sidebar as 'sidebar' partial, that is to be shown on Sidebar section of backend
		$this->template->set_partial('sidebar', 'admin/sidebar');
	}
	
	//Show Helloworld message to admin
	function index()
	{			
		//function triggred when we click on the module name in backend in the menu
		
		//get message from model
		$message = $this->helloworld_m->getHelloMsg();
		
		//pass message and build template
		$this->data->msg = $message;			
		$this->template->build('admin/index', $this->data);
	}
	
}
?>