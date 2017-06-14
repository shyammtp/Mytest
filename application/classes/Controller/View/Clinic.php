<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_View_Clinic extends Controller_Core_Front {
	 
	private $_clinic;
	public function action_list()
	{
		$this->loadBlocks('view');
		$this->renderBlocks(); 
	}
	
	private function _initData()
	{
		$id = $this->getRequest()->param('_id');
		$this->_clinic = App::model('clinic',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->selectAttributes('*') 
					->filter('clinic_status',array('=',1)); 
		if($id) {
			$this->_clinic->filter('clinic_id',array('=',$id));  
		}
		$this->_clinic->getCurrent();
		if(!$this->_clinic->hasSubscribed()) {
			$this->page404();
		}
		App::register('clinic',$this->_clinic);
	}
	
	public function action_detail()
	{
		$this->_initData();  
		$this->loadBlocks('view');
		$breadcrumb = $this->getBlock('breadcrumbs');
		$head = $this->getBlock('head');
		$_clinic = $this->_getClinic();
		$title = $this->_getClinic()->getClinicName();
		$title .= " in ". $_clinic->getAreaText(); 
		$head->setTitle($title);
		$breadcrumb->addCrumb('title',array('title' => $this->_getClinic()->getClinicName(),'label' => $this->_getClinic()->getClinicName()));
		$this->renderBlocks(); 
	}
	
	private function _getClinic()
	{
		return $this->_clinic;
	}
}
