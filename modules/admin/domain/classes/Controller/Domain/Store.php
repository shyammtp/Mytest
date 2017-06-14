<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Domain_Store extends Controller_Core_Admin { 
	 
	public function preDispatch()
    { 
		parent::preDispatch();
	}
	
	public function action_edit()
	{
		$store = App::model('core/store')->load($this->getRequest()->query('id'));
		$website = App::model('core/website')->load($this->getRequest()->query('website_id'));
		$this->loadBlocks('store/edit');
		$this->getBlock('store_edit')->setStore($store)->setWebsite($website);
		if($store->getStoreId()) {
			$this->getBlock('breadcrumbs')
				->addCrumb('editstore',array('label' => __('Edit - :website',array(':website' => $store->getName())),
												'title' => __('Edit - :website',array(':website' => $store->getName()))
							));
		} else {
			$this->getBlock('breadcrumbs')
				->addCrumb('addnewstore',array('label' => __('Add New Store'),
												'title' => __('Add New Store')
							));
		}
		$this->renderBlocks();
	}
	
	public function action_save()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		if(!$this->_validateFormKey()) {
			if($request->post('website_id')) {
				$query['website_id'] = $request->post('website_id');
			}
			$this->_redirect('domain/store/edit',$query);
		}
		if($data) {
			$validate = App::model('domain/validate_store')->checkWebsiteValidate($data); 
			if($validate->check()) {
				$storemodel = App::model('core/store');
				if($request->post('store_id')) {
					$storemodel->setStoreId($request->post('store_id'));
					$storemodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
				} else { 
					$storemodel->setCreatedDate(date("Y-m-d H:i:s",time()));
				}
				if($request->post('website_id')) {
					$storemodel->setWebsiteId($request->post('website_id'));
				}
				$storemodel->setName($request->post('name')); 
				$storemodel->setStoreIndex(strtolower($request->post('store_index')));  
				$storemodel->save(); 
				Notice::add(Notice::SUCCESS, 'Store Information Updated');
			} else {
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $validate->errors('store')); 
				$this->_addErrors($validate->errors('store')); 
				if($request->post('website_id')) {
					$query['website_id'] = $request->post('website_id');
				}
				$this->_redirect('domain/store/edit',$query);
			}
		}
		if($request->post('website_id')) {
			$query['website_id'] = $request->post('website_id');
			if($this->getRequest()->query('popup')) {
				$query['saved'] = 'true';
			}
		}
		if($storemodel->getStoreId()) {
			$query['id'] = $storemodel->getStoreId();
		}
		$this->_redirect('domain/store/edit',$query);
	}
}