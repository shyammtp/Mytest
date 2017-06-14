<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_City_Edit extends Blocks_Admin_Abstract
{
	protected $_city;
	
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getCity()
    { 
		if(!$this->_city){
			$this->_city = App::model('admin/city/settings',false)->loadAllLanguages($this->getRequest()->query('id'));
		}
		return $this->_city;
    }
    
	protected function _getCountryInfo()
    { 
		$c = App::model('core/country',false)->setLanguage(App::getCurrentLanguageId())->getResource()->joinLanguageTable();
		$country = $c->getAttributeValues();
		foreach($country as $sel) {
            $options[$sel->getCountryId()] = $sel->getCountryName();
        }
		return $options;
    }
    
}
