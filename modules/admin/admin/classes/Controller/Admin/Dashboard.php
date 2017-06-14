<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Dashboard extends Controller_Core_Admin {

	public function preDispatch()
    {
		$this->_noAccessCheckAction = array('index','loadnotificationajax','search','getlocations');
		parent::preDispatch();
	}

	public function action_index()
	{ 
		$this->loadBlocks('main');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Admin Dashboard'));
		$contentblock->setPageTitle(__('Admin Dashboard'));
		$this->renderBlocks();
	}
	
	public function action_report()
	{
		$this->loadBlocks('dashboard');
		$contentblock = $this->getBlock('report');
		$this->getResponse()->body($contentblock->toHtml());
	}
	public function action_search()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$query['subject'] = $request->post('subject');   
		$query['skey'] = $request->post('skey'); 
		$this->_redirect('admin/dashboard/index',$query);
	}
	
	public function action_loadnotificationajax()
    { 
	    $this->loadBlocks('main');
		$request = $this->getRequest();
		$query = $request->query();
		$page = $request->post('page');
		if(!$page || $page <= 0) {
			$page = 2;
		}
		$offset = ($page - 1) * Arr::get($this->getRequest()->query(),'limit',10) + 1;
	    $block=$this->getBlock('ajax')->setPage($page)->setOffset($offset);	  
		$this->getResponse()->body($block->toHtml());
    }
	
	protected function _getUserName($user_id)
	{
		if(!isset($this->_user[$user_id])){
			$usermodel = App::model('user',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($user_id);	
			$this->_user[$user_id]=$usermodel->getData('first_name');
		}
		return $this->_user[$user_id];
	}
	
	/** Add and Edit floor **/ 
	public function action_reportabuse()
	{ 
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$json=array();
		$success = false;
        $errors = array();
			try { 
				
					
					if(isset($query['isajax'])){
						$success='report abuse has been success';
						$json['sucess']=$success;
					}	
				
			}catch(Kohana_Exception $ke) {
				
				//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) {
				
				Log::Instance()->add(Log::ERROR, $e);
			}
			if(isset($query['isajax'])){
				$this->getResponse()->body(json_encode($json));
			}	
		
	}
	
	public function action_getlocations()
	{
		$this->auto_render = false;
		$this->loadBlocks('main');
		$city_id = $this->getRequest()->query('city_id');
		$locations = $this->getRequest()->query('locations');
		$all = $this->getRequest()->query('all');
		$output = $this->getBlock('loc')->setCityId($city_id)->setLocationsset($locations)->setAll($all)->toHtml();
		$this->getResponse()->body($output); 
	}

} // End Dashboard
