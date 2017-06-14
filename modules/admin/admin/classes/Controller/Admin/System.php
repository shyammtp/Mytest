<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_System extends Controller_Core_Admin {

	public function preDispatch()
    { 
		parent::preDispatch();
	} 
	
	public function action_cache()
	{
		$this->loadBlocks('main');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Cache Management'));
		$contentblock->setPageTitle('<i class="fa fa-cogs" ></i>&nbsp;'.__('Cache Management'));
		$this->renderBlocks();
	}

	public function action_cacheajax()
	{
		$this->loadBlocks('main');
		$output = $this->getBlock('cache_grid_list')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_message() {	
		$session = App::model('admin/session');	
		$message = App::model('core/notification/message');
		if($session->getFormData()) {
			$this->_localSessionData();
			$message->addData($session->getFormData()); 
			$session->unsetData('form_data');
		}
		$this->loadBlocks('system/message');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Message Management'));
		$contentblock->setPageTitle('<i class="fa fa-envelope" ></i>&nbsp;'.__('Message Management'));
		App::register('messageblock',$message);
		$this->renderBlocks();
	}
	
	public function _localSessionData()
	{
		$session = App::model('admin/session');
		$data = $session->getFormData();
		$email = array();		
		if(isset($data['user_id']) && $data['user_id'] != '') {
			$users = explode(',',$data['user_id']);
			foreach($users as $user) {
				$email[$user] = App::model('user')->load($user)->getData('primary_email_address');	
			}			
			$data['email'] = $email;
		}	
		$session->setDatas('form_data',$data);
	}
	
	public function action_inbox() {		
		$this->loadBlocks('system/message');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Message Management'));
		$contentblock->setPageTitle('<i class="fa fa-envelope" ></i>&nbsp;'.__('Message Management'));
		$this->renderBlocks();
	}
	
	public function action_sendmessages() {		
		$this->loadBlocks('system/message');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Message Management'));
		$contentblock->setPageTitle('<i class="fa fa-envelope" ></i>&nbsp;'.__('Message Management'));
		$this->renderBlocks();
	}
	
	public function action_mailsend() 
	{
		$session = App::model('admin/session');
		$request = $this->getRequest();
		$data = $request->post();	
		$to = explode(",",$request->post('user_id'));		
		$query = $this->getRequest()->query();
		$customer = App::model('admin/session')->getCustomer();			
		$data['created_by'] = $customer->getUserId();	
		$subtype = 'mail';
		$querystring = '';
		$place  = App::instance()->getPlace()->getPlaceId();	
		try { 			
			$messagemodel = App::model('admin/notification/message', false);	
			$validate = $messagemodel->validate($data);			
			$notification=App::helper('notification');
			$notification->setReceivers($to);
			$notification->setSenders(array($data['created_by'],App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)));
			//$notification->setSubjectType('mail');
			$notification->setSubject($request->post('subject'));
			$notification->setMessage(array('MAIL'=>$request->post('message')));
			//$notification->setQueryString();
			$notification->setReplyStatus(true);
			//$notification->setPlace(0);
			$notification->setPriority($request->post('priority'));
			$notification->setNotifyType(true);
			$notification->ForceStopPermissionCheck();						
			$notification->sendNotification();
			
			$success = true;
		}catch(Validation_Exception $ve) {	
			$session->setDatas('form_data',$request->post());			
			Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validate/message',true));
			$errors = $ve->array->errors('validate/message',true);			
			$this->_redirect('admin/system/message',$query);
			return;
		}catch(Kohana_Exception $ke) {
		//Log::Instance()->add(Log::ERROR, $ke);

		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
			if($success) {	
				Notice::add(Notice::SUCCESS, __('Notification send successfully'));					
			}			
			$this->_redirect('admin/system/sendmessages');
	}
	
	public function action_reply_message()
	{
		$id = $this->getRequest()->query('id');
		$type = $this->getRequest()->query('type');
		$message = App::model('admin/notification/message')->load($id);
		$customer = App::model('admin/session')->getCustomer();			
		$user_id = $customer->getUserId();
		
		if($message->getData('msg_id')) {
			$reply = App::model('admin/notification/users');	
			$msgValid = $reply->getMessageValid($id,$user_id,$type);
			//if($msgValid == true) {
				$readStatus = $reply->getNotifyReadStatus($id,$user_id);				
				foreach($readStatus as $read) {
					$replymodel = App::model('admin/notification/users', false);
					$replyid = $read['id'];		
					$notifyReadStatus = $replymodel->load($replyid);	
					if($notifyReadStatus->getReadStatus() == false) {
						$replymodel->setId((int)$replyid);
						$replymodel->setReadStatus(true);
					}	
					$replymodel->save();
				}			
				$this->loadBlocks('system/message');
				$contentblock = $this->getBlock('content');
				$breadcrumb = $this->getBlock('breadcrumbs');
				$breadcrumb->addCrumb('editReply',array('label' => __(':reply',array(':reply' => $message->getData('subject'))),'replyname' => __(' :reply',array(':reply' => $message->getData('subject')))));
				$this->getBlock('head')->setTitle(__('Notification'.' - '.$message->getData('subject')));
				$contentblock->setPageTitle(__('Notification'.' - '.$message->getData('subject')));
				$this->renderBlocks();
			//} else {
				//$this->page404();
			//}
		} else {
			$this->page404();
		}
	}
	
	public function action_mailreply() {
		$request = $this->getRequest();
		$data = $request->post();		
		
		$customer = App::model('admin/session')->getCustomer();			
		$data['created_by'] = $customer->getUserId();
		$place  = App::instance()->getPlace()->getPlaceId();
		try { 		
			$replymodel = App::model('admin/notification/reply', false);			
			$validate = $replymodel->validate($data);
			$receiver = explode(',',$data['user_id']);			
			$message=App::helper('notification')->sendNotificationReply($receiver,$data['message'],array($data['created_by'],App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)),$data['message_id'],$place);					
			$success = true;
		}catch(Validation_Exception $ve) {				
			Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validate/message',true));
			$errors = $ve->array->errors('validate/message',true);			
			$this->_redirect('admin/system/message',$query);
			return;
		}catch(Kohana_Exception $ke) {
		//Log::Instance()->add(Log::ERROR, $ke);
		

		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
			
		}		
		$reply_result = App::model('admin/notification/reply')->getRepliesResponse($request->post('message_id'));
		$this->getResponse()->body($reply_result);		
	}
		
	public function action_deletereply() {		
		$request = $this->getRequest();
		$data = $request->post();		
		$customer = App::model('admin/session')->getCustomer();			
		$sender = $customer->getUserId();		
		/*$response = App::model('admin/notification/reply')->getReplyDeleteItems($sender,$data['msg_id'],$data['reply_id']);
		if(!empty($response)) {
			foreach($response as $res) {
				if($res['id']) {
					$model = App::model('admin/notification/users', false);	
					$model->setId((int)$res['id']);
					$model->setDStatus(true);			
					$model->save();			
				}
			}
		}
		* */		
		$replyDeleteModel = App::model('admin/notification/replydelete');	
		$replyDeleteModel->setUserId((int)$sender);
		$replyDeleteModel->setMsgId($data['msg_id']);
		$replyDeleteModel->setReplyId($data['reply_id']);			
		$replyDeleteModel->save();						
		$this->getResponse()->body('Reply has been deleted successfully');			
	}
	
	public function action_delete_message()
	{
		$id = $this->getRequest()->query('id');
		$customer = App::model('admin/session')->getCustomer();			
		$user_id = $customer->getUserId();		
		$messagemodel = App::model('admin/notification/message');
		$reply = App::model('admin/notification/users', false);	
		$deleteStatus = $reply->getNotifyDeleteStatus($id,$user_id);				
		foreach($deleteStatus as $status) {
			if($status['id']) {
				$replyModel = App::model('admin/notification/users', false);	
				$replyModel->setId((int)$status['id']);
				$replyModel->setDStatus(true);			
				$replyModel->save();			
			}		
		}
		Notice::add(Notice::SUCCESS, __('Notification has been Deleted Successfully'));
		$this->getResponse()->body('success');
	}
	
	public function action_delete_sendmessage()
	{ 
		$id = $this->getRequest()->query('id');
		$customer = App::model('admin/session')->getCustomer();			
		$user_id = $customer->getUserId();		
		$messagemodel = App::model('admin/notification/message');
		$reply = App::model('admin/notification/users', false);	
		$deleteStatus = $reply->getNotifyDeleteStatus($id,$user_id);						
		foreach($deleteStatus as $status) {
			if($status['id']) {
				$replyModel = App::model('admin/notification/users',false);	
				$replyModel->setId((int)$status['id']);
				$replyModel->setDStatus(true);			
				$replyModel->save();			
			}		
		}
		Notice::add(Notice::SUCCESS, __('Message information has been Deleted Successfully'));
		$this->_redirect('admin/system/sendmessages');
	}

	public function action_sendmessagesajaxlist()
    {
        $this->loadBlocks('system/message');
        $output = $this->getBlock('listing')->toHtml();        
        $this->getResponse()->body($output);
    }
    
	public function action_inboxajax()
    {
        $this->loadBlocks('system/message');
        $output = $this->getBlock('inbox_list')->toHtml();
        $this->getResponse()->body($output);
    }
}
