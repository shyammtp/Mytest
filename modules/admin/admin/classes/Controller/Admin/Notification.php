<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Notification extends Controller_Core_Admin {
	protected $_fields = array();
	
	public function preDispatch()
	{ 
		$this->_noAccessCheckAction = array('addquickacess');
		parent::preDispatch();
	} 
	
}
