<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Cmspage extends Blocks_Front_Abstract
{ 
    public function getContent()
    {
		$id = $this->getRequest()->param('id');  
		$cms = App::model('cms/cms',false)->getCmsInfo($id,App::getCurrentLanguageId()); 
		return $cms->getContent();  
    }
	
	public function getCMS()
	{
		return App::registry('cms');
	}
}
