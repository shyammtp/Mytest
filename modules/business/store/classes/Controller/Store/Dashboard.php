<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Store_Dashboard extends Controller_Core_Store { 
	 
	public function preDispatch()
	{
		$this->_noAccessCheckAction = array('index','search','loadnotificationajax');
		$this->_nonsubscriptionactions = array('index','search','loadnotificationajax','notifysubscription');
		parent::preDispatch();
	}
	
	public function action_index()
	{ 
		$this->loadBlocks('dashboard');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Dashboard'));
		$contentblock->setPageTitle(__('Dashboard'));
		$this->renderBlocks(); 
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
	    $this->loadBlocks('dashboard');
		$request = $this->getRequest();
		$query = $request->query();
		$page = $request->post('page');
		if(!$page || $page <= 0) {
			$page = 2;
		}
		$offset = ($page - 1) * Arr::get($this->getRequest()->query(),'limit',10) + 1;
	    $block=$this->getBlock('dashboard')->setPage($page)->setOffset($offset);
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
	
	
	public function action_notifysubscription()
    { 
		$request = $this->getRequest();
		$message = $request->post('subsciption_post');
		if(!empty($message)){
			$session = App::model('store/session')->getCustomer();
			$from = $session->getPrimaryEmailAddress(); 
			$to = App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN);
			$subtype = 'mail';
			$PlaceName = App::instance()->getPlace()->getPlaceIndex();
			$subject = '<b>'.ucfirst($PlaceName).'</b> - Subscription Renewal';
			$notification=App::helper('notification');
			$notification->setReceivers(array($to));
			$notification->setSenders(array($from,$to));
			$notification->setSubjectType($subtype);
			$notification->setSubject($subject);
			$notification->setMessage(array('MAIL'=>$message));
			$notification->setQueryString();
			$notification->setReplyStatus(TRUE);
			//$notification->setPlace(0);
			$notification->setPriority('important');
			//$notification->setNotifyType(TRUE);
			$notification->ForceStopPermissionCheck();						
			$notification->sendNotification();	
			Notice::add(Notice::SUCCESS, __('Request has been sent successfully'));
			$this->_redirect('admin/dashboard/index');
		}
		$this->_redirect('admin/dashboard/index');
    }
    
	public function action_import()
	{
		$this->loadBlocks('dashboard');
		$this->renderBlocks();
	}
	
	
} // End Dashboard
