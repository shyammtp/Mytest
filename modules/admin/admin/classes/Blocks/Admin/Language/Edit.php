<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Language_Edit extends Blocks_Admin_Abstract
{
	protected $_language;
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getLanguageSettings()
    { 
		if(!$this->_language){
			$this->_language = App::model('admin/language_settings')->load($this->getRequest()->query('id'));
		}
		return $this->_language;
    }
    
}
