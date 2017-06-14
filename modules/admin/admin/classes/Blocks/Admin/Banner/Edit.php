<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Banner_Edit extends Blocks_Admin_Abstract
{ 
	protected $_banner;
	
	protected function _getBannerSettings()
    { 
		if(!$this->_banner){
			$this->_banner = App::model('admin/banner_settings',false)->loadAllLanguages($this->getRequest()->query('id'));
		}
		return $this->_banner;
    }

    
}
