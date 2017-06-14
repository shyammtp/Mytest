<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Template_Email_Edit extends Blocks_Admin_Abstract
{ 
	protected $_template = array();
	public function getEmailTemplate()
	{		
		return App::registry('email_template');
	}
	
	protected function _geTemplate()
	{		
		return App::model('admin/email_template')->load($this->getRequest()->query('id'));
	}
}
