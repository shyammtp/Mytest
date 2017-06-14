<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Domain_Customer extends Controller_Core_Admin { 
	 
	public function preDispatch()
    { 
		parent::preDispatch();
	} 
	
	public function action_save()
	{
		$request = $this->getRequest();
		$data = $request->post('customer');
		$query = $this->getRequest()->query();
		if(!$this->_validateFormKey()) {
			if($request->post('website_id')) {
				$query['id'] = $request->post('website_id');
			}
			$this->_redirect('domain/list/edit',$query);
		}
		if(!$request->post('website_id')) {
			Notice::add(Notice::ERROR, 'Add website first');
			$this->_redirect('domain/list/edit',$query);
		}
		if($data) { 
			$validate = App::model('domain/validate_customer')->checkCustomerValidate($request->post('customer')); 
			if($validate->check()) { 
				$customermodel = App::model('core/customer');
				$customerwebsitemodel = App::model('core/customer_website');
				if($request->post('customer_id')) {
					$customermodel->setCustomerId($request->post('customer_id'));
					$customermodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
				} else { 
					$customermodel->setCreatedDate(date("Y-m-d H:i:s",time()));
				} 
				$customermodel->setFirstname($data['firstname']); 
				$customermodel->setUsername($data['username']);  
				$customermodel->setEmail($data['email']);  
				$customermodel->setPassword(md5($data['password']));  
				$customermodel->save();
				if($request->post('website_id')) {
					$customerwebsitemodel->setWebsiteId($request->post('website_id')); 
					$customerwebsitemodel->setOwnerId($customermodel->getCustomerId())
									->setCreatedId($customermodel->getCustomerId())->save();
				}
				Notice::add(Notice::SUCCESS, 'Owner Information Updated');
			} else {
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $validate->errors('customer')); 
				$this->_addErrors($validate->errors('customer')); 
				if($request->post('website_id')) {
					$query['id'] = $request->post('website_id'); 
				} 
				$this->_redirect('domain/list/edit',$query);
			}
		}
		if($request->post('website_id')) {
			$query['id'] = $request->post('website_id');
			if($this->getRequest()->query('popup')) {
				$query['saved'] = 'true';
			}
		}
		if($customerwebsitemodel->getWebsiteId()) {
			$query['id'] = $customerwebsitemodel->getWebsiteId();
		}
		$this->_redirect('domain/list/edit',$query);
	}
}