<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Api_Blockbak extends Controller_Core_Front {
	 
	
	public function action_api()
	{
		exit('asdasd');
		$this->loadBlocks('cms');
		$id = $this->getRequest()->query('page');
		$cms = App::model('cms/cms',false)->load($id,'index'); 
		$cms = App::model('cms/cms',false)->getCmsInfo($cms->getId(),App::getCurrentLanguageId());
		App::register('cms',$cms);
		$this->getBlock('head')->setTitle($cms->getMetaTitle())
								->setMetaKeywords($cms->getMetaKeywords())
								->setMetaDescription($cms->getMetaDescription());
		$this->renderBlocks();
	}
} 
