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
class Model_Api_Myrequirements extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/requirements');
	}
	
	public function getQueryData()
	{		
		if(isset($this->_params['fetch'])) {
            $q = $this->_params['fetch'];
        }	
        $db = DB::select('*')->from(array(DB::select(DB::expr("date_part('days', now() - created_date) AS days"),'*')->from(array(App::model('requirements')->getTableName(),'main_table'))->and_where('user_id','=',$this->_params['user_id'])->order_by('requirement_id','ASC'),'req')); 
        
        if(isset($q)) {
				$db->where('req.additional_info', 'ILIKE', '%'.$q.'%');
		}
        $requirement=$this->_model->load($this->_params['id']);
		if($requirement->getRequirementId()) {
				$db->where('req.requirement_id', '=', $requirement->getRequirementId());
		}	
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
		$id=(int)Request::current()->param('param');
		$params['id'] = $id;
		$this->_params = $params; 			 				
		$this->_prepareList();		
		$resultant = $this->as_array();
			
		foreach($resultant as $key => $value) {
			$resultant[$key]['price_from'] = number_format($value['price_from'],2);
			$resultant[$key]['price_to'] = number_format($value['price_to'],2);
		}
			
		if($id){
			$comment = array();
			$places =$this->getPlaces($id);
			$comments =$this->getComments($id);
			if(count($comments)>0){
				foreach($comments as $key => $value){
						$comment[$value['place_id']][]=$value;
				}
			}
			
			$resultant['places'] = $places;
			$resultant['comments'] = $comment;
		}
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	public function createRequirement($params) 
	{
		$data = array();
		$requirementmodel = App::model('requirements');
		$data = $params;
		$userid = $this->getUserid($data['user_token']);
		$data['created_by'] = $userid;
		
		try{			
			$requirementmodel->setData($data);
							
			$validateRequirement = $requirementmodel->requirementValidate();			
			$cityName = App::model('location/city')->getCityNameById($data['city_id']);
			$requirementmodel->setAdditionalInfo($data['additional_info']);
			$requirementmodel->setLocation($cityName);
			$requirementmodel->setCityId($data['city_id']);
			$requirementmodel->setCategory_id($data['category_id']);		
			$requirementmodel->setBrandId($data['brand_id']);	
			if($data['price_from'] != '') {	
				$requirementmodel->setPriceFrom($data['price_from']);
			}
			if($data['price_to'] != '') {	
				$requirementmodel->setPriceTo($data['price_to']);
			}
			$requirementmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
            $requirementmodel->setUserId($userid);										
			$requirementmodel->saveRequirementInfo($data);			
			$data['success'] = true;			
		}
		catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('validation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
			
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			
				Log::Instance()->add(Log::ERROR, $e);
		}						
		return $data;
	}
	public function create($params)
	{		
		$data = array();
		if(!isset($params['user_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing user_id'),
				'field' => 'user id',
			));
		}
		if(!isset($params['requirement_info_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing requirement_info_id'),
				'field' => 'info id',
			));
		}
		if(!isset($params['comments'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing comments'),
				'field' => 'comments',
			));
		}
		try{
			$requirementcommentmodel = App::model('requirements/comments');				
			$requirementcommentmodel->setRequirementInfoId($params['requirement_info_id']);
			$requirementcommentmodel->setComments($params['comments']);		
			$requirementcommentmodel->setCreatedDate(date("Y-m-d H:i:s",time()));		
			$requirementcommentmodel->setCreatedBy($params['user_id']);										
			$requirementcommentmodel->save();
			$data['success'] = true;		
		}
		catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('apivalidation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	}
	
	public function getPlaces($id) 
    {		
		$langId = 1;		
		return $this->_places = DB::select('main_table.requirement_info_id','pl.place_id','pl.place_index','plinfo.place_name')
								->from(array(App::model('requirements/info')->getTableName(),'main_table'))
								->join(array('place_entity','pl'),'left')
								->on('main_table.place_id','=','pl.place_id')
								->join(array('place_info','plinfo'),'left')
								->on('pl.place_id','=','plinfo.place_id')								
								->where('plinfo.language_id','=',$langId)													
								->where('main_table.requirement_id','=',$id)
								->execute()->as_array();
	}
	
	public function getComments($id) 
    {				
		$langId = 1;
		return $this->_comments = DB::select(array('user.value','comment_author'),'co.created_date','co.comments','main_table.place_id')
								->from(array(App::model('requirements/info')->getTableName(),'main_table'))
								->join(array(App::model('requirements/comments')->getTableName(),'co'),'left')
								->on('main_table.requirement_info_id','=','co.requirement_info_id')		
								->join(array(App::model('user/attribute')->getTableName(),'user'),'left')
								->on('co.created_by','=','user.user_id')														
								->where('main_table.requirement_id','=',$id)
								->where('user.language_id','=',$langId)
								->execute()->as_array();								
	}
	
	
	public function put($params)
	{		
		$data = array();
		if(!isset($params['user_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing user_id'),
				'field' => 'user id',
			));
		}
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		try{
			$requirementsmodel = App::model('requirements')->load($params['id']);		
			$requirementsmodel->setRequirementId($params['id']);
			$requirementsmodel->setStatus(false);
			$requirementsmodel->save();	
			$data['success'] = true;		
		}
		catch(Kohana_Exception $ke) {
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	}
	
	public function getUserid($token) {
		$select = DB::select('user_id')->from(App::model('user')->getTableName())->where('user_token','=',$token)->execute()->get('user_id');		
		return $select; 
	}
}	
