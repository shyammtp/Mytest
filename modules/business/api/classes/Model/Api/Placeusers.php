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
class Model_Api_Placeusers extends Model_RestAPI {
	
	const USERS_ADD_TO_CONTACTS_EMAIL_TEMPLATE = 'USERS_ADD_TO_CONTACTS_EMAIL_TEMPLATE';
	public function __construct()
	{ 		
		$this->_model = App::model('core/place/contacts');
	}
	
	public function getQueryData()
	{		
		$select = DB::select('*')->from(array($this->_model->getTableName(),'pl'))
								->where('pl.place_id','=',$this->_params['place']);
		if(isset($this->_params['email'])) {
			$select->where('user_email','=',$this->_params['email']);
		}
		if(isset($this->_params['status'])) {
			if(is_numeric($this->_params['status'])) {
				$select->where('contact_status','=',$this->_params['status']);
			}
		}
		if(isset($this->_params['request_status'])) {
			if(is_numeric($this->_params['request_status'])) {
				$select->where('request_status','=',$this->_params['request_status']);
			}
		}
		return $select;						
	}
	
	public function get($params)
	{ 
		$id=(int)Request::current()->param('param');
		$params['id'] = $id;
		$this->_params = $params; 		
			
		if(isset($this->_params['place'])) {
			$placeusersmodel = $this->_model->load($id);
			if($placeusersmodel->getContactId()) {
				$resultant = $placeusersmodel->getData();
				$this->_totalItems = 1;
			} else {
				$this->_prepareList();		
				$resultant = $this->as_array();	
			}
			return array('details' => $resultant,'total_rows' => $this->_totalItems);
		} else {			
			return array('code' => 401,'error' => 'Place Id Missing');
		}		 		 		
	}
	
	public function create($params)
	{
		$data = array();
		$website = App::model('core/website',false)->load(App::FRONTEND);
		$siteUrl = $website->getWebUrl();		
		$placeusersmodel = clone $this->_model;
		try{			
			$data = $this->_initData($params);	
			$validate = $placeusersmodel->validate($data);	
			
			$template = App::model('core/email_template')->load(App::getConfig(self::USERS_ADD_TO_CONTACTS_EMAIL_TEMPLATE,Model_Core_Place::ADMIN));
			$from = $template->getFromEmail();
			$from_name=$template->getFrom();
			$subject = $template->getSubject();
			if(!$template->getTemplateId()) {
				$template = 'mail_template';
				$from=App::getConfig('CONTACT_EMAIL');
				$subject = __("You received a contact request from ").App::getConfig('SITE_NAME')." ".App::instance()->getPlace()->getPlaceName();
				$from_name="";
			}
			$placeid = $data['place_id'];
			$place_name=App::model('core/place')->getPlaceInfo($data['place_id']);
			$url ='<p><a style="color: #68696a; text-decoration: none; text-transform: uppercase;" href="'.$siteUrl.'signup?placeid='.$placeid.'&type=1"><strong>Join as Consumer in&nbsp;<span style="font-family: Verdana, Geneva, sans-serif; color: #666766; font-size: 13px; line-height: 21px;">'.App::getConfig('SITE_NAME').'</span> &amp; Add me in this store '.$place_name->getPlaceName().'</strong></a> <br /><br /> </p>';
			
			$url1 ='<p><a style="color: #68696a; text-decoration: none; text-transform: uppercase;" href="'.$siteUrl.'signup?type=2"><strong>Join as Consumer in <span style="font-family: Verdana, Geneva, sans-serif; color: #666766; font-size: 13px; line-height: 21px;">'.App::getConfig('SITE_NAME').'</span></strong></a></p>';
			
			$content =array("customer" => $data['user_email'],"message"=> $data['message'],"place"=>$place_name->getPlaceName(),"url"=>$url,"url1"=>$url1);
			$email=App::model('core/email')->smtp($from,$from_name,$data['user_email'],$subject,$content,$template);
					
			$exists=App::model('core/place/contacts')->getPlaceExistContacts($data['place_id'],$data['user_email']);			
			if(count(array_filter($exists->getData()))){	
				$placeusersmodel->setContactId($exists->getContactId());
			}			
			$placeusersmodel->setPlaceId($data['place_id'])->setUserEmail($data['user_email'])
					->setCreatedDate(date("Y-m-d H:i:s"))->setMessage($data['message'])->setRequestCount($exists->getRequestCount()+1);			
			$placeusersmodel->save(); 
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
		if(isset($data['user_email']) && $data['user_email']) {
			$data['user_email'] = $data['user_email'];
		}
		if(isset($data['id']) && $data['id']) {
			$data['contact_id'] = $data['id'];
		}
		if(isset($data['message']) && $data['message']){ 
			$data['message']=$data['message'];
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
		$placeusersmodel = clone $this->_model;
		try{			
			$data = $this->_initData($params);	
			$validate = $placeusersmodel->validateBlock($data);	
			$contactmodel = $placeusersmodel->load($data['contact_id']);
			$contactmodel->setContactId($data['contact_id']);
			$contactmodel->setContactStatus($data['status']);
			$contactmodel->save();
			
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
	
}	
