<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Appointments extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/appointment/booking');
	}
	
	public function getQueryData()
	{		
        $responce=array();
		$languageId = App::getCurrentLanguageId(); 
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('core/place_info')->getTableName().' as info where info.language_id = '.$languageId.' and place_id = pinfo.place_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		if(isset($this->_params['place'])) {
			$db = DB::select('*')->from(array(App::model('core/appointment/booking')->getTableName(),'a'))
					->join(array(App::model('core/peoples')->getTableName(),'b'),'left')
					->on('a.people_id','=','b.people_id')
					->join(array(App::model('core/place_info')->getTableName(),'pinfo'),'left')
					->on('b.place_id','=','pinfo.place_id')
					->on('pinfo.language_id','=',DB::expr($language_sql));		
			if(isset($this->_params['pn'])) {
				$db->where('b.people_name', 'ILIKE', '%'.$this->_params['pn'].'%');	
			}
			if($this->_params['place']){			
			$childPlaces = App::model('core/place')->getChildIds($this->_params['place']);
			if(!empty($childPlaces)) {
				$db->where('b.place_id','IN',$childPlaces);
			} else {
				$db->where('b.place_id','=',$this->_params['place']);
			}
			} else {
				$db->where('b.place_id','=',$this->_params['place']);
			}	
			if(isset($this->_params['rn']) &&  $this->_params['rn']!="") {
				$db->where('a.reference', '=', $this->_params['rn']);			
			}	
			if(isset($this->_params['mn'])) {
				$db->where('a.mobile_number', 'ILIKE', '%'.$this->_params['mn'].'%');			
			}		
			if(isset($this->_params['an'])) {
				$db->where('a.appointment_name', 'ILIKE', '%'.$this->_params['an'].'%');			
			}		
			if(isset($this->_params['in'])) {
				$db->where('a.info', 'ILIKE', '%'.$this->_params['in'].'%');			
			}	
			if(isset($this->_params['fd']) && $this->_params['fd']!='') {
				$db->where('a.appointment_date', '>=', $this->_params['fd']);
			}
			if(isset($this->_params['td']) && $this->_params['td']!='') {
				$db->where('a.appointment_date', '<=', $this->_params['td']);
			}
			$appointment=$this->_model->load($this->_params['id']);
			if($appointment->getBookingId()) {
				$db->where('a.booking_id', '=', $appointment->getBookingId());
			}				
			return $db;
		}
	}
	
	public function get($params)
	{ 
		$id=(int)Request::current()->param('param');
		$params['id'] = $id;
		$this->_params = $params; 				
		if(isset($this->_params['place'])) {
			$this->_prepareList();		
			$resultant = $this->as_array();	
			return array('details' => $resultant,'total_rows' => $this->_totalItems);
		} else {			
			return array('code' => 401,'error' => 'Place Id Missing');
		}		 		 		
	}
	
	public function create($params)
	{
		$data = array();
		$model = clone $this->_model;
		$appointmentmodel = $model->load($params['id'],'booking_id');
		$data = $params;	
		$user = App::model('user',false)->load($appointmentmodel->getUserId());
		$notification = App::helper('notification')->setUseTemplateData(true)->ForceStopAdmin()->ForceStopPermissionCheck()->ForceStopSystemNotification()->setCustomTemplateId(31);
		$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN))); 
		$notification->setReceivers(array($user->getPrimaryEmailAddress()));
		$content = '';
		if(!isset($data['type']) || $data['type']==''){
			throw new Kohana_Exception(__('Select any one schedule type'));
		}
		if($data['type'] == 'accept') {
			$data['accept'] = 't';
			$subject = "Your Appointment request has been fixed on the same date (".Date::formatted_time($appointmentmodel->getAppointmentDate(),'d, M Y h:i A').")";
			$content = '';
			$appointmentmodel->setAccept(true)
							->setAcceptDate($appointmentmodel->getAppointmentDate())
							->save();
			$data['success'] = true;
		}
		if($data['type'] == 'modify') {
			$data['accept'] = 't'; 
			if(!isset($data['date'])) {
				throw new Kohana_Exception(__('Invalid Date'));
			}
			
			$date = Date::formatted_time($data['date'],'Y-m-d H:i:s');
			
			if(isset($data['date'])) {
				if($date <= Date::formatted_time()) {
					throw new Kohana_Exception(__('Date is lesser than current time'));
				}
			}
			$subject = "Your Appointment request has been modified on this date (".Date::formatted_time($data['date'],'d, M Y h:i A').")";
			$content = $data['comments'];
			$appointmentmodel->setAccept(true)
							->setAcceptDate($date)
							->setComment($data['comments'])
							->save();
			$data['success'] = true;
		}
		if($data['type'] == 'reject') {
			$data['accept'] = 'f'; 
			$content = '';
			if(!isset($data['comments'])) {
				throw new Kohana_Exception(__('Add some comments'));
			} 
			$subject = "Your Appointment request has been rejected";
			$content = $data['comments'];
			$appointmentmodel->setAccept(false)
							->setComment($data['comments'])
							->setUserAccept(false)
							->save();
			$data['success'] = true;
		}
		
		$notification->setSubject($subject);
		
		$notification->setVariables(array('notification' => new Kohana_Core_Object(array('CONTENT' => $content)), 'customer' => $user)); 
		if($subject) {
			$notification->sendNotification();
			if($user->getId()) {				
				//Only Push Notification
				$pushmessage = $subject. "(Reference : #".$appointmentmodel->getReference().")"; 
				$notification = App::helper('notification')->ForceStopAdmin()
								->ForceStopPermissionCheck()->ForceStopSystemNotification()
								->ForceStopEmailNotification()->addToQueue('iphone');
				$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN))); 
				$notification->setReceivers(array($user->getId()))
								->setArea('frontend')
								->setPushMessage($pushmessage)
								->setSubject($pushmessage)
								->setPlace(array())
								->setPushMessageData(array('order_id' => $user->getId()));
				$notification->sendNotification();
			}
		}
		return $data;
	} 	
	
	public function update($params)
	{		
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		$appointment=$this->_model->load($params['id']);
		if(!$appointment->getBookingId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid id'),
				'field' => 'id',
			));
		}	
		return $this->create($params);
	}
}	
