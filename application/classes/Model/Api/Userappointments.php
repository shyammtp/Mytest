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
class Model_Api_Userappointments extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/appointment_booking');
	}
	
	public function getQueryData()
	{			
        $languageId=1;
		if(isset($this->_params['language'])){
			$languageId=$this->_params['language'];
		}
		if(isset($this->_params['fetch'])) {
            $q = $this->_params['fetch'];
        }	
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('core/place_info')->getTableName().' as info where info.language_id = '.$languageId.' and place_id = pinfo.place_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		$db = DB::select('people_name','place_name','booking_id','appointment_name','info','mobile_number',array(DB::expr('(case when accept_date != appointment_date then accept_date else appointment_date end)'),'appointment_date'),array('appointment_date','old_date'),'accept','comment','user_accept')->from(array(App::model('core/appointment/booking')->getTableName(),'a'))
					->join(array(App::model('core/peoples')->getTableName(),'b'),'left')
					->on('a.people_id','=','b.people_id')
					->join(array(App::model('core/place_info')->getTableName(),'pinfo'),'left')
					->on('b.place_id','=','pinfo.place_id')
					->on('pinfo.language_id','=',DB::expr($language_sql))
					->where('a.user_id','=',$this->_params['user_id']);
		if(isset($q)) {
				$db->where('b.people_name', 'ILIKE', '%'.$q.'%');
		}
		if(isset($q)) {
				$db->or_where('pinfo.place_name', 'ILIKE', '%'.$q.'%');
		}
		if(isset($q)) {
				$db->or_where('a.appointment_name', 'ILIKE', '%'.$q.'%');
		}
		if(isset($q)) {
				$db->or_where('a.info', 'ILIKE', '%'.$q.'%');
		}
		if(isset($q)){
				$db->or_where('a.mobile_number', '=', $q);
		}
		$db->order_by('booking_id','desc');
		return $db;				
	}
	
	public function get($params)
	{ 
		if(!isset($params['user_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing User Id'),
				'field' => 'user_id',
			));
		}
		$this->_params = $params; 			 				
		$this->_prepareList();		
		$resultant = $this->as_array();
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	
	public function update($params)
	{ 
		$data = array();
		if(!isset($params['user_token'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing User Token'),
				'field' => 'user_token',
			));
		}
		if(!isset($params['user_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing User Id'),
				'field' => 'user_id',
			));
		}
		$user=App::model('user')->load($params['user_token'],'user_token');
		if(!$user->getUserId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid User'),
				'field' => 'id',
			));
		}
		try { 
			$appointmentmodel = App::model('core/appointment/booking',false)->load($params['id']);
			if($user->getId() != $appointmentmodel->getUserId()) {
				$data['success'] = 'false';
			}
			$appointmentmodel->setUserAccept(true)
							->save(); 
			$data['success'] = 'true';
		} catch(Kohana_Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
		return $data; 

	}
	
	
	public function delete($params)
	{		
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		if(!isset($params['user_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing user id'),
				'field' => 'user_id',
			));
		}
		$appointmentmodel = clone $this->_model;
		$user = App::model('user',false)->load($params['user_id']);
		$appointment = $appointmentmodel->load($params['id']);
		if($user->getId() != $appointment->getUserId()) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid Appointment'),
				'field' => 'id',
			));
		}
		$appointment->deleteRow();
		$data['success'] = true;
		return $data;
	}	
	
}	
