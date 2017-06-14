<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Store_Insurance extends Controller_Core_Store { 
	 
	 public function action_index()
	{ 
		$this->loadBlocks('insurance');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Insurance'));
		$contentblock->setPageTitle(__('Insurance'));
		$this->renderBlocks(); 
	}
	
} // End Insurance
