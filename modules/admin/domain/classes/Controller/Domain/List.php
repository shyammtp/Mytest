<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Domain_List extends Controller_Core_Admin { 
	 
	public function preDispatch()
    { 
		parent::preDispatch();
	}
	
	public function action_website()
	{ 
		$this->loadBlocks('website');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Website Domain Management'));
		$contentblock->setPageTitle('<i class="fa fa-globe" ></i>&nbsp;'.__('Website Domain Management'));
		$this->renderBlocks();
	}
	
	public function action_ajaxlist()
	{
		$this->loadBlocks('website');
		$output = $this->getBlock('website_list_grid')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_storeajaxlist()
	{
		$this->loadBlocks('website/edit');
		$output = $this->getBlock('store_list')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_edit()
	{
		$webmodel = App::model('core/website')->load($this->getRequest()->query('id'));
		$this->loadBlocks('website/edit');
		/** if($this->getRequest()->query('id')) { 
			if(!$webmodel->checkhasStore()) {
				Notice::add(Notice::WARNING, 'Warning: No default Store Associated with this website.'); 
			} 
			if(!$webmodel->checkhasOwner()) { 
				Notice::add(Notice::WARNING, 'Warning: No Owner assigned to this website.');
			}
		}	
		**/ 	
		//$this->getBlock('owner_form')->setWebsite($webmodel);
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($webmodel->getWebsiteId()) {
			$this->getBlock('head')->setTitle(__('Edit :website',array(':website' => $webmodel->getWebsiteName())));
			$contentblock->setPageTitle('<i class="fa fa-globe" ></i>&nbsp;'.__('Edit <span class="semi-bold">:website</span>',array(':website' => $webmodel->getWebsiteName())));
			$breadcrumb->addCrumb('editwebsite',array('label' => __('Edit - :website',array(':website' => $webmodel->getWebsiteName())),
												'title' => __('Edit - :website',array(':website' => $webmodel->getWebsiteName()))
							)); 
		} else {
			
			$this->getBlock('head')->setTitle(__('Add Website - Admin'));
			$contentblock->setPageTitle('<i class="fa fa-globe" ></i>&nbsp;'.__('Add Website'));
			$breadcrumb->addCrumb('editwebsite',array('label' => __('Add Website'),
												'title' => __('Add Website')
							)); 
		} 
		$this->renderBlocks();
	}
	
	public function action_managemods()
	{
		$this->auto_render = false;
		$json = array();
		$install = $this->getRequest()->post('install');
		$modid = $this->getRequest()->post('modid');
		$websiteid = $this->getRequest()->post('webid');
		if($modid) {
			
			$model = App::model('modules/access');
			if($install == 'true') {
				$model->installMod($modid,$websiteid);
			}
			if($install == 'false') { 
				$model->uninstallMod($modid,$websiteid);
			}
		}
		$json['status'] = true;
		$this->getResponse()->body(json_encode($json));
		
	}
	
	public function action_savewebsite()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$backto = isset($data['backto']);
		$query = $this->getRequest()->query();
		$success = false;
        $errors = array();
		if(!$this->_validateFormKey()) {
			$this->_redirect('domain/list/edit',array('id' => $request->post('website_id')));
		}
		try { 
			$validate = App::model('domain/validate_website')->checkWebsiteValidate($data); 
				$webmodel = App::model('core/website');
				if($request->post('website_id')) {
					$webmodel->setWebsiteId($request->post('website_id'));
					$webmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
				} else { 
					$webmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
				}
				$webmodel->setName($request->post('name'));
				$webmodel->setWebUrl($request->post('web_url'));
				$webmodel->setWebIndex(strtolower($request->post('web_index')));
				$status = $request->post('status') ? 1 : 0;
				$webmodel->setStatus($status);
				App::dispatchEvent('Admin_Website_Save_Before',array('post' => $request,'website' => $webmodel));
				$webmodel->save(); 
				App::dispatchEvent('Admin_Website_Save_After',array('post' => $request,'website' => $webmodel));
				Notice::add(Notice::SUCCESS, 'Website Information Updated');
			} catch(Validation_Exception $ve) {
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('website',true)); 
					$errors = $ve->array->errors('website',true);
				if($request->post('website_id')) {
					$query['id'] = $data['website_id'];
				}
				$this->_redirect('domain/list/edit',$query);
				return;
			}catch(Kohana_Exception $ke) {
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($request->post('website_id')) {
				$query['id'] = $data['website_id'];
			}
			if($backto) {
				$this->_redirect('domain/list/edit',$query);
			} elseif($webmodel->getWebsiteId()) {
				$this->_redirect('domain/list/website');
			}
	}
	
	/** URL Rewrite Menu**/
	public function action_urlrewrite(){
		$this->loadBlocks('urlrewrite');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('URL Rewrite Management'));
		$contentblock->setPageTitle('<i class="fa fa-link" ></i>&nbsp;'.__('URL Rewrite Management'));
		$this->renderBlocks();
	}
	
	public function action_edit_url()
	{
		
		$session = App::model('admin/session');
		$urlmodel = App::model('domain/urlrewrite')->load($this->getRequest()->query('id'));
		$this->loadBlocks('urlrewrite');
		if($this->getRequest()->query('id')!='' && $urlmodel->getId()!= $this->getRequest()->query('id')) {
			Notice::add(Notice::ERROR, __('Invalid Url'));
			$this->_redirect('domain/list/urlrewrite');
		}
		if($session->getFormData()) {
			$this->_localSessionData();
			$urlmodel->addData($session->getFormData()); 
			$session->unsetData('form_data');
		}
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		if($this->getRequest()->query('id')) {
			$this->getBlock('head')->setTitle(__('Edit :urlrewrite',array(':urlrewrite' => $urlmodel->getRequestPath())));
			$contentblock->setPageTitle('<i class="fa fa-link" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:urlrewrite</span>',array(':urlrewrite' =>$urlmodel->getRequestPath())));
			$breadcrumb->addCrumb('editUrlrewrite',array('label' => __('Edit - :urlrewrite',array(':urlrewrite' => $urlmodel->getRequestPath())),
												'title' => __('Edit - :urlrewrite',array(':urlrewrite' => $urlmodel->getRequestPath()))
							)); 
		} else {	
			$this->getBlock('head')->setTitle(__('Add URL Rewrite'));
			$contentblock->setPageTitle('<i class="fa fa-link" ></i>&nbsp;'.__('Add URL Rewrite'));
			$breadcrumb->addCrumb('editUrlrewrite',array('label' => __('Add URL Rewrite'),
												'title' => __('Add URL Rewrite')
							)); 
		}
		App::register('url',$urlmodel);
		$this->renderBlocks();
	}
	
	public function _localSessionData()
	{
		$session = App::model('admin/session');
		$data = $session->getFormData(); 
		if(isset($data['name'])) {
			$data['name'] = $data['name'];
		}
		if(isset($data['value'])) {
			$data['value'] = $data['value'];
		}
		$params=array_combine($data['name'],$data['value']); 
		if(!empty($params)){
			$value=json_encode($params);
			if($value=='{"":""}'){
				$data['additional_params'] = '';
			}else {
				$data['additional_params'] = $value;
			}
		}
		$session->setDatas('form_data',$data);
	}
	
	public function action_saveurl()
	{
		$request = $this->getRequest();
		$data = $request->post();
		
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
        $session = App::model('admin/session');
        try { 

					$urlmodel = App::model('domain/urlrewrite');
					$urlmodel->unsetData();
					$validate = $urlmodel->validate($data);					
					if($request->post('id')) {						
						$urlmodel->setId($request->post('id'));
						$urlmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$urlmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
					} 
					$urlmodel->setRoutename($request->post('route_name'));
					$urlmodel->setRequestPath($request->post('request_path'));
					$urlmodel->setTargetPath($request->post('target_path'));
					$urlmodel->setWebsiteId($request->post('website_id'));
					$urlmodel->setFor($request->post('for'));
					$name=array_filter($request->post('name'));
					$value=array_filter($request->post('value'));
						$values=array();
					if($name){
						foreach($name as $key => $val){
							$values[$val]=$value[$key];
						}	
					}	
					$additional_params = array_filter($values);
					if(count($additional_params)){
						$urlmodel->setAdditionalParams(json_encode($additional_params));
					}	
					if($request->post('name')){ 
						$data['name']=json_encode($request->post('name'));
					}

					if($request->post('value')){ 
						$data['value']=json_encode($request->post('value'));
					}
					$urlmodel->save(); 
					if($backto){ 
						$query['id'] = $urlmodel->getId();
					}
					$success = true;
			}catch(Validation_Exception $ve) {
					$session->setDatas('form_data',$request->post());
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation/url',true));
					$errors = $ve->array->errors('validation/url',true);
					if($request->post('id')) {
						$query['id'] = $request->post('id');
					}
					$this->_redirect('domain/list/edit_url',$query);
					return;
			}catch(Kohana_Exception $ke) {
			//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('id')) {
						Notice::add(Notice::SUCCESS, __('Url Rewrite Information  has been  updated'));
					}else{
						Notice::add(Notice::SUCCESS, __('Url Rewrite Information has been  added'));
					}
			}
			if($backto){ 
				
				$this->_redirect('domain/list/edit_url',$query);
			}else{
				$this->_redirect('domain/list/urlrewrite',$query);
			}	
	}
	
	/** Delete Url rewrite**/
	public function action_delete_url(){
		$id = $this->getRequest()->query('id');
		$urlmodel = App::model('domain/urlrewrite')->deleterow($id,'id');
		Notice::add(Notice::SUCCESS, __('Url rewrite information has been Deleted Successfully'));
		$this->_redirect('domain/list/urlrewrite');
	}
	
	public function action_ajaxload()
    {
        $this->loadBlocks('urlrewrite');
        $output = $this->getBlock('urlrewritelist')->toHtml();
        $this->getResponse()->body($output);
    }
	
} // End Domain
