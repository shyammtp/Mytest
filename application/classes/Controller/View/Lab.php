<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_View_Lab extends Controller_Core_Front {
	
	
	public function action_list()
	{
		$this->loadBlocks('view');
		$this->renderBlocks(); 
	}
	
	
	public function action_detail()
	{
		
		$this->loadBlocks('view');
		$this->renderBlocks(); 
	}
}
