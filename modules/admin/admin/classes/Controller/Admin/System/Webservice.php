<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_System_Webservice extends Controller_Core_Admin {

	private $_api;
	protected function _initApi()
	{
		if(!$this->_api) {
			$this->_api = App::model('core/api',false)->load($this->getRequest()->query('id'));
		}
        return $this->_api;
	}
	
	public function action_index()
	{ 
		$this->loadBlocks('system/webservice');
		$this->renderBlocks();
	}
	
	private function _getApi()
	{
		return $this->_api;
	}
 

	public function action_new()
	{
		$this->loadBlocks('system/permission/roles/edit');
		$this->renderBlocks();
	}

	public function action_edit()
	{
		$this->_initApi();
		$session = App::model('admin/session');
		$this->loadBlocks('system/webservice');
		if($session->getFormData()) {
			$this->_localSessionData();
			$this->_getApi()->addData($session->getFormData()); 
			$session->unsetData('form_data');
		}
		App::register('api',$this->_getApi());
		$this->renderBlocks();
	}
	
	public function _localSessionData()
	{
		$session = App::model('admin/session');
		$data = $session->getFormData();
		if(isset($data['resource'])) {
			$resources = array();
			foreach($data['resource'] as $key => $re) {
				foreach($re as $s => $g) {
					$resources[$key][] = $s;
				}
				
			}
			$data['resources'] = $resources;
		} 
		$session->setDatas('form_data',$data);
	}
 

	public function action_save()
	{ 
		$this->_initApi();
		$data = $this->getRequest()->post();		
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$model = $this->_getApi(); 
		$model->addData($data);
		$session = App::model('admin/session');
		$success = false;
		try {
			$model->validate();
			if(!$this->_getApi()->getAccountId())
				$model->setCreatedDate(date("Y-m-d H:i:s",time()));
			$model->setReferencePlaceId(App::instance()->getPlace()->getPlaceId());
			$model->saveApi();
			$success = true;
		} catch(Validation_Exception $ve) {
			$session->setDatas('form_data',$data);
            Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
            $errors = $ve->array->errors('validation',true);
        }
        catch(Kohana_Exception $ke) {
			
			Log::Instance()->add(Log::ERROR, $ke);
            Notice::add(Notice::ERROR, __('Problem on the server.'));

        } catch(Exception $e) { 
            Log::Instance()->add(Log::ERROR, $e);
            Notice::add(Notice::ERROR, __('Problem on the server.'));
        }
        if($model->getAccountId()) {
			$query['id'] = $model->getAccountId();
		}
		if($success) {
			Notice::add(Notice::SUCCESS, __('Information Updated'));
			if($backto){ 
				$this->_redirect('admin/system_webservice/edit',$query);
			}
			$this->_redirect('admin/system_webservice/index');
		}
		$this->_redirect('admin/system_webservice/edit',$this->getRequest()->query());
	}
	
	public function action_delete()
	{ 
		$accid = $this->getRequest()->query('id');
		$model = App::model('core/api')->deleterow($accid,'account_id');
		Notice::add(Notice::SUCCESS, __('Api been deleted successfully'));
		$this->_redirect('admin/system_webservice/index');
	
	}
	 
	
} // End Dashboard
