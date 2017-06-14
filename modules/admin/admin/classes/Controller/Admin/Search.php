<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Search extends Controller_Core_Admin {
	public function preDispatch()
    { 
		$this->_noAccessCheckAction = array('keyword');
		parent::preDispatch();
	}
	
    /**
	 * Handle GET requests.
	 */
	public function action_keyword()
	{  
		$this->loadBlocks('main'); 
		$this->renderBlocks(); 
	}
 
}