<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Dashboard_Dashboard extends Blocks_Admin_Abstract
{ 
	protected $_customer;
	protected $_customers;
	protected $_insurance;
	protected $_clinics;
	protected $_labs;
	protected $_hospitals;
	protected $_pharmacy;
	protected $_optics;
	protected $_departments;
	Protected $_user;
	protected $_doctors;
	protected $_patients;
	protected $_banners;
	protected $_country;
	protected $_city;
	protected $_area;
    public function __construct()
    { 
		 parent::__construct();
	}
	
	protected function _getTotalcustomer()
    {  
		if(!$this->_customer){
			$this->_customer = App::model('Adminmodel')->getAllCustomers($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_customer;
    }
    
    protected function _getcustomer()
    {  
		if(!$this->_customers){
			$this->_customers = App::model('Adminmodel')->getCustomers();
		}
		return $this->_customers;
    }
    
    protected function _getdepartments()
    {  
		if(!$this->_departments){
			$this->_departments = App::model('Adminmodel')->getdepartments($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_departments;
    }
    
    protected function _getInsurance()
    {  
		if(!$this->_insurance){
			$this->_insurance = App::model('Adminmodel')->getInsurance($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_insurance;
    }
    
    protected function _getClinics()
    {  
		if(!$this->_clinics){
			$this->_clinics = App::model('Adminmodel')->getClinics($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_clinics;
    }
    
    protected function _getLabs()
    {  
		if(!$this->_labs){
			$this->_labs = App::model('Adminmodel')->getLabs($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_labs;
    }
    
    protected function _getHospitals()
    {  
		if(!$this->_hospitals){
			$this->_hospitals = App::model('Adminmodel')->getHospitals($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_hospitals;
    }
    
    protected function _getPharmacy()
    {  
		if(!$this->_pharmacy){
			$this->_pharmacy = App::model('Adminmodel')->getPharmacys($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_pharmacy;
    }
    
    
    protected function _getOptics()
    {  
		if(!$this->_optics){
			$this->_optics = App::model('Adminmodel')->getOptics($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_optics;
    }
    
    
    protected function _getDoctors()
    {  
		if(!$this->_doctors){
			$this->_doctors = App::model('Adminmodel')->getDoctors($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_doctors;
    }
    
    protected function _getPatients()
    {  
		if(!$this->_patients){
			$this->_patients = App::model('Adminmodel')->getPatients($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_patients;
    }
    
    protected function _getBanners()
    {  
		if(!$this->_banners){
			$this->_banners = App::model('Adminmodel')->getBanners($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_banners;
    }
    
    protected function _getCountry()
    {  
		if(!$this->_country){
			$this->_country = App::model('Adminmodel')->getCountry($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_country;
    }
    
    
    protected function _getCity()
    {  
		if(!$this->_city){
			$this->_city = App::model('Adminmodel')->getCity($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_city;
    }
    
    
    protected function _getArea()
    {  
		if(!$this->_area){
			$this->_area = App::model('Adminmodel')->getArea($this->getRequest()->query('time'),$this->getRequest()->query('fromdate'),$this->getRequest()->query('todate'));
		}
		return $this->_area;
    }
    
    public function year_month($start_date, $end_date)
	{
		$begin = new DateTime( $start_date );
		$end = new DateTime( $end_date);
		$end->add(new DateInterval('P1D')); //Add 1 day to include the end date as a day
		$interval = new DateInterval('P1W'); //Add 1 week
		$period = new DatePeriod($begin, $interval, $end);
		$aResult = array();
		foreach ( $period as $dt ) {
			$aResult[$dt->format('Y')][] = $dt->format('W');
		}
		return $aResult;
	}

	public function getStartAndEndDate($week, $year,$totime = true)
	{
		$time = strtotime("1 January $year", time());
		$day = date('w', $time);
		if($totime) {
			$time += ((7*$week)+1-$day)*24*3600;
			$return[0] = strtotime(date('Y-n-j', $time));
			$time += 6*24*3600;
			$return[1] = strtotime(date('Y-n-j', $time));
		}
		else {
			$time += ((7*$week)+1-$day)*24*3600;
			$return[0] = date('d M Y', $time);
			$time += 6*24*3600;
			$return[1] = date('d M Y', $time);
		}
		return $return;
	}
	
	public function getActions($subject, $querystring,$msg_id,$action_placed)
	{ 
		$block = $this->getRootBlock()->createBlock('Core/Dashboard/Messages/Actions');
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
		return '';
	}

	public function getMessage()
	{
		$request = $this->getRequest();
		$query = $request->query();
		$customer = App::model('admin/session')->getCustomer();
		$message = array();
		$messages=App::model('core/message')->getDashboardMessages($customer->getId(),$query,Arr::get($this->getRequest()->query(),'limit',10),$this->getOffset());
		if(count($messages)>0){
			foreach($messages as $value)
			{ 
				$user_name = $this->_getUserName($value['from']);
				$message[] = Arr::merge($value,array('action'=>$this->getActions($value['subject_type'],$value['querystring'],$value['msg_id'],$value['action_placed']),'from'=>$user_name));
			}
		}
		return $message;
	}

	public function getNotificationSubjects()
	{ 
		$subject = App::model('core/subject')->getEmailsubjects(); 
		return $subject; 
	}
	
	protected function _getUserName($user_id)
	{
		if(!isset($this->_user[$user_id])){
			$usermodel = App::model('user',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($user_id);	
			$this->_user[$user_id]=$usermodel->getData('first_name');
		}
		return $this->_user[$user_id];
	}

	protected function getTotalMessages()
    {
		$customer = App::model('admin/session')->getCustomer();
		$messages=App::model('core/message')->getTotalDashboardMessages($customer->getId());
		return $messages;
	}
	
	
	public function CheckisLastmessage($primary_id,$message_id,$customer_id)
    {
		$customer = App::model('core/notification_users',false)->check_is_lastmessage($primary_id,$message_id,$customer_id);
		return $customer;
	}
}
