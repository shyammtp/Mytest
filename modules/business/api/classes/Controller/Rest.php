<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Rest extends Kohana_Controller_Rest {
    
    protected $_resourceIndex;
    protected $_needApikey = true;
    protected $_needUserToken = false;
	
	
    public function before()
    {  
        parent::before();
        try { 
			$langugeid = Arr::get($this->_params,'language',Arr::get($this->_params,'language_id',1));  
			if($langugeid == 1) {
				I18n::lang('en-us');
			}
			if($langugeid == 2) {
				I18n::lang('ar-ae');
			}
			App::$_language = $langugeid;
            $this->_checkApiKeyResources();
            $this->_needAccessToken();
            $this->_checkFieldDatas();
        }
        catch (Kohana_HTTP_Exception $khe) { 
			$this->_error($khe);
			return;
		}
        catch (Kohana_Exception $e)
		{
			$this->_error('An internal error has occurred', 500);
			throw $e;
		}
    }
    
    
    protected function _checkApiKeyResources()
    {
        if($this->_needApiKey()) {  
			          
            $apikey = $this->_params['api_key'];
            $webapimodel = App::model('core/customer_website')->load($apikey,'api_key');
            if($apikey && $webapimodel->getApiKey()){
				if($apikey==$webapimodel->getApiKey()){
					return true;
				}
			}
            $apimodel = App::model('core/api')->load($apikey,'app_key');
            if(!$apimodel->getAccountId()) {  

                throw HTTP_Exception::factory(401, __('Invalid Api Key')); 
                return false;
            }
            
            if($apimodel->getRoleId()){
				if(Arr::get($this->_params,'user_token')){
					$user=App::model('user')->load($this->_params['user_token'],'user_token');
					if($user->getId()){
						$role=App::model('core/role_users')->getRoleuser($apimodel->getRoleId(),$user->getId());
						if(!$role){
							throw HTTP_Exception::factory(401, __('Invalid Api Key'));
							return false;
						}
	
					}
				}	
			}
            $resources = $apimodel->getResources();
            if(!array_key_exists($this->_resourceIndex,$resources)
                || !in_array($this->getRequest()->method(),$resources[$this->_resourceIndex])) {
                
                throw HTTP_Exception::factory(401, __('Access Denied'));  
                return false;
            } 
        }
    }
    
    protected function _needAccessToken()
    {
        if(!$this->_needUserToken) {
            return true;
        }
        $usertoken = isset($this->_params['user_token']) ? $this->_params['user_token'] : false;
        if($usertoken) {
            $user = App::model('user')->load($usertoken,'user_token');
            if(!$user->getUserId()) {
                throw HTTP_Exception::factory(401, __('Invalid User token')); 
                return false;
            }
        } else {
            throw HTTP_Exception::factory(400, __('Missing Parameter: user_token')); 
            return false;
        } 
    }
    
    protected function _checkFieldDatas()
    {
        if($this->getRequest()->param('param')) {
            $this->_params = Arr::merge($this->_params,array('id' => $this->getRequest()->param('param')));
        }
        switch ($this->request->method())
		{
            case HTTP_Request::PUT:
                if(!$this->getRequest()->param('param')) {
                     throw HTTP_Exception::factory(401, 'Missing ID'); 
                    return false;
                }
            break;
			case HTTP_Request::OPTIONS:
				throw HTTP_Exception::factory(401, 'Checking Options'); 
                return false;
            break;
        }
    }
    
    protected function _needApiKey()
    {
        if(!$this->_needApikey) {
            return false;
        } 
        if(!isset($this->_params['api_key'])) {            
            throw HTTP_Exception::factory(400, __('Missing Parameter: api_key'));  
            return false;
        }
        return true;
    }
	
	protected function getRequest()
	{
		return $this->request;
	}
}
