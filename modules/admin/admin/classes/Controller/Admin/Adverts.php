<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_Admin_Adverts extends Controller_Core_Admin { 
	 
	public function preDispatch()
    { 
		parent::preDispatch();
	}

	public function action_advert(){			
		$this->loadBlocks('advert');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Adverts Management'));
		$contentblock->setPageTitle('<i class="fa fa-bullhorn" ></i>&nbsp;'.__('Adverts Management'));
		$this->renderBlocks();
	}
	
	public function action_edit_advert(){
		$advertmodel = App::model('admin/advert')->load($this->getRequest()->query('adverts_id'));
		$this->loadBlocks('advert');
		if($this->getRequest()->query('adverts_id')!='' && $advertmodel->getAdvertsId()!= $this->getRequest()->query('adverts_id')) {
			Notice::add(Notice::ERROR, __('Invalid Advert'));
			$this->_redirect('admin/adverts/advert');
		}
		$advertinfomodel = App::model('admin/advert/info')->load($this->getRequest()->query('adverts_id'),"adverts_id");		
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('adverts_id')) {
			$this->getBlock('head')->setTitle(__('Edit :advert',array(':advert' => $advertinfomodel->getTitle())));
			$contentblock->setPageTitle('<i class="fa fa-bullhorn" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:advert</span>',array(':advert' =>$advertinfomodel->getTitle())));
			$breadcrumb->addCrumb('editAdvert',array('label' => __('Edit - :advert',array(':advert' => $advertinfomodel->getTitle())),
												'title' => __('Edit - :advert',array(':advert' => $advertinfomodel->getTitle()))
							)); 
		} else {	
			$this->getBlock('head')->setTitle(__('Add Advert'));
			$contentblock->setPageTitle('<i class="fa fa-bullhorn" ></i>&nbsp;'.__('Add Advert'));
			$breadcrumb->addCrumb('editAdvert',array('label' => __('Add Advert'),
												'title' => __('Add Advert')
							)); 
		}
		$this->renderBlocks();
	}
	
	public function action_saveadvert(){		
		$request = $this->getRequest();
		$data = $request->post();
		
		if(is_array($request->post('place_id'))) {
			$place_id = implode(",", $request->post('place_id'));
		}	
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();       
		$session = App::model('admin_session');		
		$sessiondata = $session->getData();
		$data['created_by'] = $sessiondata['id'];
        try { 
			$advertmodel = App::model('admin/advert');
			if($this->getRequest()->query('adverts_id') == '') {
				$validate = $advertmodel->validate($data);					
			} else {
				$validate = $advertmodel->validateEdit($data);
			}					
			if($request->post('adverts_id')) {						
				$advertmodel->setAdvertsId((int)$request->post('adverts_id'));
				$advertmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
			} else { 
				$advertmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
			} 
			if($this->getRequest()->query('adverts_id') == '') {
				$advertmodel->setPlaceType($request->post('place_type'));
				$advertmodel->setPlaceId($place_id);
			}
			$advertmodel->setTitle($request->post('title'));
			$advertmodel->setDescription($request->post('description'));
			if($request->post('status')) {
				$advertmodel->setStatus($request->post('status'));
			} else {
				$advertmodel->setStatus(0);
			}
			$advertmodel->setCreatedBy($data['created_by']);
			if($request->post('category_image') != '') {
				$advertmodel->setCategoryImage($request->post('category_image'));
			}			
			$advertmodel->save(); 			
			if($backto){ 
					$query['adverts_id'] = $advertmodel->getAdvertsId();
			}	
			$success = true;
		}catch(Validation_Exception $ve) {				
			Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validate/advert',true));
			$errors = $ve->array->errors('validate/advert',true);
			if($request->post('adverts_id')) {
				$query['adverts_id'] = $request->post('adverts_id');
			}
			$this->_redirect('admin/adverts/edit_advert',$query);
			return;
		}catch(Kohana_Exception $ke) {
		//Log::Instance()->add(Log::ERROR, $ke);

		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
		if($success) {
				if($request->post('adverts_id')) {
					Notice::add(Notice::SUCCESS, __('Advert Information  has been  updated'));
				}else{
					Notice::add(Notice::SUCCESS, __('Advert Information has been  added'));
				}
		}
		if($backto){ 
			$this->_redirect('admin/adverts/edit_advert',$query);
		}
		$this->_redirect('admin/adverts/advert',$query);				
	}

	public function action_delete_advert(){
		$id = $this->getRequest()->query('adverts_id');
		$advertmodel = App::model('admin/advert')->deleterow($id,'adverts_id');
		Notice::add(Notice::SUCCESS, __('Advert information has been Deleted Successfully'));
		$this->_redirect('admin/adverts/advert');
	}
		
	public function action_place() {
		$data = $this->getRequest()->post();
		if(isset($data['query'])) {
			$places = App::model('admin/advert')->getplaces($data['query']);
			$this->getResponse()->body(json_encode($places));			
		}		
	}
	public function action_blockunblockadvertsblock()
	{ 
		$request = $this->getRequest();		
		$advertsid=$this->getRequest()->query('adverts_id');		
		$adverts=App::model('admin/advert/info')->load($advertsid,'adverts_id');		
		$blockstatus=$this->getRequest()->query('status');
		$advertmodel = App::model('admin/advert')->load($advertsid);
		$advertmodel->setAdvertsId($advertsid);
		$advertmodel->setStatus($blockstatus);			
		$advertmodel->saveBlock();
		if($blockstatus==0){				
			Notice::add(Notice::SUCCESS, __('Advert has been blocked successfully'));
		}else{				
			Notice::add(Notice::SUCCESS, __('Advert has been unblocked successfully'));
		}			
		$this->_redirect('admin/adverts/advert');
	}
	
	public function action_ajaxlist()
	{
		$this->loadBlocks('advert');
		$output=$this->getBlock('listing')->toHtml();
		$this->getResponse()->body($output);
	}	

} 
