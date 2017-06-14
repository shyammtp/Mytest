<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Home extends Controller_Core_Front {
	  
	const CONTACTUS_EMAIL_TEMPLATE = 3;
	const CONTACTUS_ADMIN_EMAIL_TEMPLATE = 5;
	public function action_index()
	{  
		$this->loadBlocks('index');
		$this->getBlock('content')->unsetChild('breadcrumbs');
		$this->getBlock('head')->setMetaKeywords(App::getConfig('META_KEYWORDS',Model_Core_Place::ADMIN))
							->setMetaDescription(App::getConfig('META_DESCRIPTION',Model_Core_Place::ADMIN));
		$this->renderBlocks();
	}
	
	public function action_setcountry()
	{
		$this->auto_render = false;
		$req = $this->getRequest();
		$sql = 'SELECT name_eng, name_arb, gid, gid as country_id, status FROM '.App::model('location/country')->getTableName().' where st_contains(geom,st_setsrid(st_makepoint('.$req->query('lng').','.$req->query('lat').'),4326))= true'; 
		$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/country')->getDbConfig())->current();
		
		$csql = 'SELECT name_eng, name_arb, gid,  gid as city_id, status, st_asgeojson(geom) as geojson FROM '.App::model('location/city')->getTableName().' where st_contains(geom,st_setsrid(st_makepoint('.$req->query('lng').','.$req->query('lat').'),4326))= true'; 
		$city = DB::query(Database::SELECT,$csql)->execute(App::model('location/city')->getDbConfig())->current();
		
		if(!empty($select)) {			
			$country = $select;
			$select['country'] = $country;
			App::setCountry($country['gid']);			
		} else {
			$select['status'] = false;
		}
		if(!empty($city)) { 
			$select['city'] = $city;
			$select['city']['center_coordinate']['geojson'] = $city['geojson']; 
			App::setCity($city['gid']);
		} else {
			$select['status'] = false;
		}
		$this->getResponse()->body(json_encode($select));
	}
	
	public function action_setcity()
	{
		$this->auto_render = false;  
		App::setCity((int)$this->getRequest()->post('cid'));
		$this->getResponse()->body(json_encode(array('success' => true)));
	}
	
	public function action_setcurrentcountry()
	{
		$this->auto_render = false;  
		App::setCountry((int)$this->getRequest()->post('cid'));
		$this->getResponse()->body(json_encode(array('success' => true)));
	}
	
	public function action_choosecity()
	{
		App::setCountry($this->getRequest()->query('coid'));   
		App::setCity($this->getRequest()->query('cid'));
		$this->_redirectUrl($this->getRequest()->query('return'));
	}
	
	
	public function action_saveuserdrawn() 
	{
		$this->auto_render = false;
		$request = $this->getRequest();
		$cdata = $request->post('cdata');
		$session = session_id();
		$json = array();
		try {
		$model = App::model('core/usercdrawn')
					->load($session,'session_id');
		
		if(!$model->getUniqCode()) {
			$uniqcode = Text::random('alpha',13);
			$model->setUniqCode($uniqcode);
		} else {
			$uniqcode = $model->getUniqCode();
		}
		$model->setSessionId($session);
		if($request->post('rad')) {
			$model->setRadius($request->post('rad'));
			$model->setCenter(json_encode($request->post('center')));
			$json['cir'] = 1; 
		} else {
			$model->setStringData($cdata)
				->setFullGeojson($request->post('geojsonstring'));
		} 		
			$model->save();
			$json['session'] = $session;
			$json['uniqcode'] = $uniqcode;
			$json['success'] = true;
		} catch(Exception $e) {
			$json['success'] = false;
		}
		$this->getResponse()->body(json_encode($json));		
	}
	
	public function action_subscriptioncron()
	{
		return App::model('subscription')->mycustomcron();
	}
	
	public function action_anges()
	{
		//App::helper('notification')->sendAndroidNotification(array('1de28a2b9e92966333a20446d71370d98b785204ce9713caf525bd64f40a14ee'),'kandipa varum','varalina unn meala than tappu');
		
		App::helper('notification')->sendIphoneNotificationAPNS('1de28a2b9e92966333a20446d71370d98b785204ce9713caf525bd64f40a14ee','kandipa varum','varalina unn meala than tappu');
		
		exit;
		
	}
	
	public function action_cronrun()
	{ 
		Cron::run();
		exit(1);
	}
	
	public function action_aboutus()
	{
		$this->loadBlocks('contentpage');
		$this->renderBlocks(); 
	}
	
	public function action_contactus()
	{
		$session = App::model('user/session');
		$formdata = $session->getData('form_data');
		$session->unsetData('form_data');
		$this->loadBlocks('contentpage');
		if($session->getValidationErrors()){
			$this->getBlock('contactus')->setValidationErrors($session->getValidationErrors())->setFormData($formdata);
			$session->unsetData('validation_errors');
		}
		$this->renderBlocks(); 
	}
	
	public function action_savecontactus()
	{
		$session = App::model('user/session');
		$request = $this->getRequest();
		$data = $request->post();
		$errors = array();
		$query = $this->getRequest()->query();
		if($this->getRequest()->query('return_url')) {
			$query['return_url'] = urldecode($this->getRequest()->query('return_url'));
		}
		try {
			$customermodel = App::model('user');
			$validate = $customermodel->validatecontactus($data);
			$template = App::model('core/email_template',false)->load(self::CONTACTUS_EMAIL_TEMPLATE);
			$admintemplate = App::model('core/email_template',false)->load(self::CONTACTUS_ADMIN_EMAIL_TEMPLATE);
			$customer = App::model('login')->load($data['email'],'primary_email_address');
			$from = $template->getFromEmail();
			$from_name=$admintemplate->getFrom();
			$subject = $template->getSubject();
			$adminfrom = $admintemplate->getFromEmail();
			$adminfrom_name=$admintemplate->getFrom();
			$adminsubject = $admintemplate->getSubject();
			if(!$template->getTemplateId()) {
				$template = 'mail_template';
				$from=App::getConfig('CONTACT_EMAIL');
				$subject = __("Thank you for contact us.").App::getConfig('SITE_NAME');
				$from_name="";
			}
			if(!$admintemplate->getTemplateId()) {
				$admintemplate = 'mail_template';
				$adminfrom=App::getConfig('CONTACT_EMAIL');
				$adminsubject = __("Reg - User contact").App::getConfig('SITE_NAME');
				$adminfrom_name="";
			}
			$content = array("customer" => $customer,'name'=>$data['name']);
			$ContentForAdmin = array("customer" => $customer,'name'=>$data['name'],'email'=>$data['email'],'mobile'=>$data['mobile'],'message'=>$data['message']);
			$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);
			$email=App::model('core/email')->smtp($adminfrom,$adminfrom_name,$adminfrom,$adminsubject,$ContentForAdmin,$admintemplate);
			Notice::add(Notice::SUCCESS, __('Thank you for contact us.'));
			$this->_redirect('',$query);
			return $this;
			$session->unsetData('form_data');
		}
		catch(Validation_Exception $ve) {
				$session->setDatas('form_data',$request->post());
				$errors = $ve->array->errors('validation',true);
				$session->setDatas('validation_errors',$errors);
		} 
		$this->_redirect('contactus',$query);
		return $this;
	}
	
	public function action_howtobook()
	{
		$this->loadBlocks('contentpage');
		$this->renderBlocks(); 
	}
 
} 
