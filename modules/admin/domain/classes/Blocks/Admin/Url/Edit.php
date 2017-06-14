<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Url_Edit extends Blocks_Admin_Abstract
{
	protected $_url;
	protected $_website;
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getUrlRewrite()
    { 
		if(!$this->_url){
			$this->_url = App::registry('url');
		}
		return $this->_url;
    }
   
    protected function _getWebsite()
    {  
        if(!$this->_website){
			$this->_website = App::model('core/website')->getWebsiteId();
		}
		return $this->_website;
    } 
    
}
