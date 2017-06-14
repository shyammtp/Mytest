<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cms_Page extends Controller_Core_Front {

	public function action_index()
	{
		$this->loadBlocks('cms');
		$id = $this->getRequest()->param('id');  
		$cms = App::model('cms/cms',false)->getCmsInfo($id,App::getCurrentLanguageId()); 
		$this->getBlock('head')->setTitle($cms->getMetaTitle())
								->setMetaKeywords($cms->getMetaKeywords())
								->setMetaDescription($cms->getMetaDescription());
		$this->renderBlocks();
	}
	
	public function action_api()
	{
		$this->loadBlocks('cms');
		$id = $this->getRequest()->query('page');
		$langid = $this->getRequest()->query('language_id');
		App::$_language = $langid;
		$cms = App::model('cms/cms',false)->load($id,'index'); 
		$cms = App::model('cms/cms',false)->getCmsInfo($cms->getId(),App::getCurrentLanguageId());
		App::register('cms',$cms);
		$this->getBlock('head')->setTitle($cms->getMetaTitle())
								->setMetaKeywords($cms->getMetaKeywords())
								->setMetaDescription($cms->getMetaDescription());
		$this->renderBlocks();
	}

	public function action_move()
	{
		$model = App::model('company')->selectAttributes('*')->filter('company_id',array('=',2));
		$model->groupByAttribute('company_id');
		$s = $model->loadCollection();
		print_r($s);
		echo View::factory('profiler/stats');
	}

} // End Welcome
