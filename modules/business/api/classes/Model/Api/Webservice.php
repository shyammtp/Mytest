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
class Model_Api_Webservice extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/api');
	}
	
	public function get($params)
	{  
		if(!isset($params['api_key'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Api Key'),
				'field' => 'api_key',
			)); 
		}
		if(!isset($params['place_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Place Id'),
				'field' => 'place_id',
			)); 
		}
		$check_admin=App::model('core/customer_website')->checkAdmin($params['place_id'],$params['api_key']);
		if($check_admin){
			return array('details' => true,'total_rows' => true);
		}else {
			$api = $this->_model->load($params['api_key'],'app_key');	
			if(!$api->getAppKey()){
				throw HTTP_Exception::factory(400, array(
					'error' => __('Invalid Api Key'),
					'field' => 'api_key',
				)); 
			}
			$resultant = $this->_model->getModuleList($api->getAppKey());		 		
			return array('details' => $resultant,'total_rows' => count($resultant));
		}
	}
	
}	
