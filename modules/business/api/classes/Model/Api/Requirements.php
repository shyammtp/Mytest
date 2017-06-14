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
class Model_Api_Requirements extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/requirements');
	}
	
	public function getQueryData()
	{			
		if(isset($this->_params['fetch']) && isset($this->_params['ps'])) {
            $q = $this->_params['ps'];
        }
        if(isset($this->_params['fetch']) && isset($this->_params['l'])) {
            $ql = $this->_params['l'];
        }
        if(isset($this->_params['fetch']) && isset($this->_params['pf'])) {
            $qpf = $this->_params['pf'];
        }
        if(isset($this->_params['fetch']) && isset($this->_params['pt'])) {
            $qpt = $this->_params['pt'];
        }
        if(isset($this->_params['fetch']) && isset($this->_params['res'])) {
            $qres = $this->_params['res'];
        }	
        $responce=array();
		$languageId = App::getCurrentLanguageId(); 
		$language_sql_user= '(case when (select count(*) as totalcount from '.App::model('user/attribute')->getTableName().' as info where info.language_id = '.$languageId.' and user_id = user_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		if(isset($this->_params['place'])) {
			$select = DB::select('main_table.*','ri.*',array('user.value','username'),array('ri.status','store_status'))
								->from(array($this->_model->getTableName(),'main_table'))
								->join(array(App::model('core/requirements/info')->getTableName(),'ri'),'left')
								->on('main_table.requirement_id','=','ri.requirement_id')
								->join(array(App::model('user/attribute')->getTableName(),'user'),'left')
								->on('main_table.user_id','=','user.user_id')
								->on('user.language_id','=',DB::expr($language_sql_user))
								->order_by('main_table.requirement_id','ASC')
								->where('ri.status','=',true)
								->where('main_table.status','=',true)
								->where('ri.place_id','=',$this->_params['place']);		
			if(isset($q)) {
				$select->where('main_table.additional_info', 'ILIKE', '%'.$q.'%');
			}
			if(isset($ql)) {
				$select->where('main_table.location', 'ILIKE', '%'.$ql.'%');
			}
			$contitions = '';
			
			if(!empty($qpf) && !empty($qpt)) {
				if(is_numeric($qpf) && is_numeric($qpt)) {
					$select->where_open();
					$select->where('main_table.price_from','=',$qpf);
					$select->or_where('main_table.price_to','<=',$qpt);
					$select->where_close();
				}
			} elseif(!empty($qpf)) {
				if(is_numeric($qpf)) {
					$select->where('main_table.price_from','=',$qpf);				
				}
			}elseif(!empty($qpt)) {
				if(is_numeric($qpt)) {
					$select->where('main_table.price_to','=',$qpt);
				}
			}			
			if(isset($qres) && is_numeric($qres)) {
				$select->where('ri.store_response', '=', $qres);
			}
			$requirement=$this->_model->load($this->_params['id']);
			if($requirement->getRequirementId()) {
				$select->where('main_table.requirement_id', '=', $requirement->getRequirementId());
			}						
			return $select;
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
			$total_values =array();
			foreach($resultant as $key => $value){
				$value['formatted_price_from'] = App::helper('price')->setAsArray(true)->formatPrice($value['price_from'],Arr::get($params,'place'),true);
				$value['formatted_price_to'] = App::helper('price')->setAsArray(true)->formatPrice($value['price_to'],Arr::get($params,'place'),true);
				$total_values[] = $value;
			}
			return array('details' => $total_values,'total_rows' => $this->_totalItems);
		} else {			
			return array('code' => 401,'error' => 'Place Id Missing');
		}		 		 		
	}
	
	public function create($params)
	{
		$data = array();
		$requirementmodel = clone $this->_model;
		try{			
			$data = $this->_initData($params);		
			$validate = $requirementmodel->validate($data);								
			$requirementmodel->setData($data);			
			$requirementmodel->save(); 
			
			$requirementsinfomodel = App::model('core/requirements/info');	
			$requirement_info_id = $requirementsinfomodel->getInfoId($data['requirement_id'],$data['place_id']);			
			if($requirement_info_id) {				
				$requirementsinfomodel->setRequirementInfoId($requirement_info_id);
				$requirementsinfomodel->setPlace($data['place_id']);
				if(isset($data['store_response'])) {
					$requirementsinfomodel->setStoreResponse($data['store_response']);						
				}
				$requirementsinfomodel->save();
			}			
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
	
	protected function _initData($post = array())
	{		
		$data = $post;	
		if(isset($data['additional_info']) && $data['additional_info']) {
			$data['additional_info'] = $data['additional_info'];
		}
		if(isset($data['id']) && $data['id']) {
			$data['requirement_id'] = $data['id'];
		}
		if(isset($data['place']) && $data['place']){ 
			$data['place_id']=$data['place'];
		}		
		if(isset($data['status']) && $data['status']){ 
			$data['status']=$data['status'];
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
		$requirement=$this->_model->load($params['id']);
		if(!$requirement->getRequirementId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid id'),
				'field' => 'id',
			));
		}	
		return $this->create($params);
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
		$requirementinfoid=$params['id'];
		$requirementsinfomodel = App::model('core/requirements/info');	
		$requirement_info_id = $requirementsinfomodel->getInfoId($params['id'],$params['place']);
			
		$requirementinfomodel = App::model('core/requirements/info');
		if($requirementinfoid) {
			$requirementinfomodel->setRequirementInfoId($requirement_info_id);
			$requirementinfomodel->setStatus(false);
			$requirementinfomodel->save();
		}
		$data['success'] = true;
		return $data;
	}
	
	public function getComments($params) 
    {		
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		if(!isset($params['place_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing place id'),
				'field' => 'place_id',
			));
		}
		$language =1;
		if(isset($params['language_id'])){
			$language = $params['language_id'];	
		}
		$requirement= App::model('core/requirements')->getComments($params,$language);
		return $requirement;
							
	}
	
	public function postcoments($params)
	{
		$data = array();
		$requirementcommentmodel = App::model('core/requirements/comments');
		$user = App::model('user')->load($params['user_token'],'user_token');
		if(!$user->getId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid User Token'),
				'field' => 'user_token',
			));
		}
		if(!isset($params['requirement_info_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Info Id'),
				'field' => 'requirement_info_id',
			));
		}
		if(!$params['requirement_info_id']) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Info Id'),
				'field' => 'requirement_info_id',
			));
		}
		$reqirementinfomodel = App::model('requirements/info',false)->load($params['requirement_info_id']);
		if(!$reqirementinfomodel->getRequirementInfoId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid Info Id'),
				'field' => 'requirement_info_id',
			));
		}
		try{			
			$validate = $requirementcommentmodel->Validate($params);
			$requirementcommentmodel->setRequirementInfoId($params['requirement_info_id']);
			$requirementcommentmodel->setComments($params['comments']);		
			$requirementcommentmodel->setCreatedDate(date("Y-m-d H:i:s",time()));		
			$requirementcommentmodel->setCreatedBy($user->getId());										
			$requirementcommentmodel->save();
			$reqirementinfomodel->setStoreResponse(1)->save();
			$data['success'] = true;
		}
		catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('validation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
			print_r($ke); exit;
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			print_r($e); exit;
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	}
	
}	
