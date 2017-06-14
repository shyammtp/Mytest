<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Edit extends Blocks_Admin_Abstract
{
	protected $_block;
	protected function _helper()
    {
        return App::helper('admin');
    }
	
	protected function _getMessageBlock()
    { 		
		if(!$this->_block){
			$this->_block = App::registry('messageblock');
		}
		return $this->_block;
    }
    
    public function getRolesList()
    {
        $role = App::model('core/role')->toOptions();
        return $role;
    }

    public function getCustomerLists()
    {
        $customers =App::model('user');
        $customers->getCustomers();
        return $customers->toOptions();
    }

    public function loadDBData()
    {
        $user = App::model('core/role_users')->load($this->getRequest()->query('id'));
        $this->setData($user->getData());
        return $this;
    }

    public function getUser()
    {
        $user = App::model('user',false)->load($this->getUserId());
        return $user;
    }
    
     public function getActions($msg_id, $subject, $querystring, $action_placed)
	{ 		
		$block = $this->getRootBlock()->createBlock('Core/Notification/Actions');
		if($action_placed == 't') {
			return '';
		}		
		switch($subject)
		{ 
			case 'delivery_confirmation':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/delivery_confirmation')->setCommentAction(Arr::get($query,'comment_submit'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'order_pickup':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/order_pickup')->setConfirmAction(Arr::get($query,'confirm'))->setModifyAction(Arr::get($query,'modify'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'order_cancellation':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/order_cancellation')->setCommentAction(Arr::get($query,'comment_submit'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'order_receipt':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/order_receipt')->setConfirmAction(Arr::get($query,'confirm'))->setDenyAction(Arr::get($query,'deny'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'user_assignment':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/user_assignment');
			//return $block->toHtml();
			break;
			case 'payment_receipt':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/payment_receipt')->setCommentAction(Arr::get($query,'comment_submit'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'payment_transfer':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/payment_transfer')->setCommentAction(Arr::get($query,'comment_submit'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'goods_return':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/goods_return')->setConfirmAction(Arr::get($query,'confirm'))->setModifyAction(Arr::get($query,'modify'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'subscription_renewal':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/subscription_renewal')->setRenewAction(Arr::get($query,'renew'))->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'requirement_post':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/requirement_post')->setReplyAction(Arr::get($query,'reply'))->setMessageId($msg_id)->setActionPlaced($action_placed);
			return $block->toHtml();
			break;
			case 'product_review':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/product_review')->setReportabuseAction(Arr::get($query,'report'))->setMessageId($msg_id)->setActionPlaced($action_placed);
			return $block->toHtml();
			break;
			case 'place_review':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/place_review')->setReportabuseAction(Arr::get($query,'report'))->setMessageId($msg_id)->setActionPlaced($action_placed);
			return $block->toHtml();
			break;
			case 'people_review':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/people_review')->setReportabuseAction(Arr::get($query,'report'))->setMessageId($msg_id)->setActionPlaced($action_placed);
			return $block->toHtml();
			break;
			case 'product_service_add_confirmation':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/product_service_add_confirmation')->setAction(Arr::get($query,'link') )->setMessageId($msg_id);
			return $block->toHtml();
			break;
			case 'new_product_service':
			$query = json_decode($querystring,TRUE);
			$block ->setTemplate('messages/actions/new_product_service');
			return $block->toHtml();
			break;
		}	
	}
    
    protected function _getMessage()
    { 
		if(!$this->_message){
			$this->_message = App::model('admin/notification/message')->load($this->getRequest()->query('id'));					
			$notification = $this->_message->getData();			
			$notification['action'] = $this->getActions($notification['msg_id'], $notification['subject_type'],$notification['querystring'],$notification['action_placed']);									
		}
		return $notification;		
    }
    
    public function getMessageData($id) {		
		$langid = 1;
		return DB::select('sender',array(DB::Expr("array_to_string(array_agg(receiver),',')"),'receiver'),array(DB::Expr("array_to_string(array_agg(post_date),',')"),'post_date'))
						->from(App::model('admin/notification/users')->getTableName())->where('reply_id','=',false)
						->where('msg_id','=',$id)->group_by('sender')->execute()->current();						
	}
	
	public function getSubjectType($type) {
		return DB::select('subject_index','color_code')
						->from(App::model('admin/email/subject')->getTableName())
						->where('subject_type','=',$type)->limit(1)->execute()->current();
	}
	
	public function getProfileImageUrl($width = 80, $height = 80, $image)
    {		
        if($image) {
            $image = trim($image,"/");
            return App::getBaseUrl('uploads').'cache/uploads/cache/thumb_'.$width.'x'.$height.'/'.$image;
        }
        return false;
    }
    
    public function getReceiversList($receivers) {
		$customer = App::model('admin/session')->getCustomer();			
		$sessionid = $customer->getUserId();
		$receiversList = explode(",",$receivers);
		/*if(in_array($sessionid, $receiversList)) {
			if (($key = array_search($sessionid, $receiversList)) !== false) {
				unset($receiversList[$key]);
			}
		}*/		
		$select = App::model('user',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage('true')
					->selectAttributes(array('first_name'))					
					->filter('user_id',array('IN',$receiversList));
		$results = $select->loadCollection();
		foreach($results as $result) {						
			$receiversListResult[] = array('first_name'=>$result->getData('first_name'));													
		}
		return $receiversListResult;		
	}
    
}
