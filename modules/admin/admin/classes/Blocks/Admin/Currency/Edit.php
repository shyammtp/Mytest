<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Currency_Edit extends Blocks_Admin_Abstract
{ 
	protected $_currency;
	protected $_country;
	protected function _getCurrencySettings()
    { 
		if(!$this->_currency){
			$this->_currency = App::model('admin/currency_settings')->load($this->getRequest()->query('id'));
		}
		return $this->_currency;
    }

    protected function _getCountryInfo()
    {
		if(!$this->_country){
			$this->_country = App::model('location/country')->getCountryInfoForOther(App::getCurrentLanguageId());
		}
		return $this->_country;
    }
}
