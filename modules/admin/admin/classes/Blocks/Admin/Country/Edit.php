<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Country_Edit extends Blocks_Admin_Abstract
{
	protected $_country;
	
	public function getLanguage()
	{ 
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getCountry()
    { 
		if(!$this->_country){
			$this->_country = App::model('admin/country/settings',false)->loadAllLanguages($this->getRequest()->query('id'));			
		}
		return $this->_country;
    }
    
}
