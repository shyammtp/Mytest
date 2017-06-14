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
class Model_Api_Registermobile extends Model_RestAPI {
	
	private function _getUser()
	{
		if(!$this->hasData("current_user")) {
			$model = App::model('user',false);
			if(Arr::get($this->params,'user_id')) {
				$model->load(Arr::get($this->params,'user_id'));
			}
			$this->setData("current_user",$model);
		}
		return $this->getData("current_user");
	} 
	
	public function addActivity()
	{
		if(!$this->_getUser()->getId()) {
			throw new Kohana_Exception(__('Invalid User'),NULL,ERROR_INVALID_USER);
		}
		$mobile_device = App::model('core/mobile_device',false)->load(Arr::get($this->params,'push_device_token'),'device_token');
		if(!$mobile_device->getId()) {
			$mobile_device->setCreatedDate(Date::formatted_time()); 
		}
		$mobile_device->setDeviceToken(Arr::get($this->params,'push_device_token'));
		$mobile_device->setUserId(Arr::get($this->params,'user_id'));
		$mobile_device->setUpdatedDate(Date::formatted_time());
		$mobile_device->setDeviceType(Arr::get($this->params,'device_type'))->setUserId($this->_getUser()->getId())->save();
		return array('success' => true);
	}
	
	public function delete()
	{
		if(!Arr::get($this->params,'push_device_token')) {
			throw new Kohana_Exception(__('Need device token'));
		}
		if(!$this->_getUser()->getId()) {
			throw new Kohana_Exception(__('Invalid user'),NULL,ERROR_INVALID_USER);
		}
		$result = array();
		$result['success'] = false;
		$user = $this->_getUser();
		if($user->getId()) {
			$deviceid = DB::select("device_id")->from(App::model('core/mobile_device')->getTableName())
										->where('device_token','=',Arr::get($this->params,'push_device_token'))
										->where('user_id','=',$user->getId())
										->execute()->get('device_id'); 
			if($deviceid) {
				$delete = App::model('core/mobile_device',false)->load($deviceid);		 
				$delete->deleterow();    
				$result['success'] = true;
			}
		} 
		return $result;
	}
}	
