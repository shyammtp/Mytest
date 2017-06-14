<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Store_Configuration extends Controller_Core_Store {  
	 
	public function action_save()
	{
		$data = $this->getRequest()->post();
		$data = Arr::merge($_FILES,$data);
		$model = App::model('configuration'); 
		$validate = App::model('configuration/validate');
		$removeFields = array('return_url','_wysihtml5_mode','config_fields','hour','minute','meridian');
		$configfields = array();
		if(isset($data['config_fields'])) {
			$configfields = $this->singletonFields(unserialize(Encrypt::instance()->decode($data['config_fields'])));
		}

		if($data) {
	
			try {
				if($validation = $validate->setData($data)->validate()) {
					$dbconfig = $model->getConfigurationSet();
					foreach($data as $name => $value) {
						$modifiedvalue = $value;
						if(in_array($name,$removeFields)) {
							continue;
						} 
						if(is_array($value)) {
							$modifiedvalue = json_encode($value);
							if(count($value) == 1) {
								$modifiedvalue = Arr::get($value,0);
							}
							if($this->_checkisFile($value)) {
								if($value['error']!=4) {
									$modifiedvalue = $model->uploadFile($value);
								} else {
									$modifiedvalue = Arr::get($value,'value',NULL);
								}
								if(isset($value['delete']) && $value['delete']==1) {
									$modifiedvalue = $model->delete($modifiedvalue);
								}
							}
						}
						if(array_key_exists($name,$dbconfig)) {
							$model->setConfigId($dbconfig[$name]->config_id);
						}
						if(isset($configfields[$name])){
							$model->setConfigFields($configfields[$name]);
						}
						$model->setWebsiteId(App::instance()->getWebsite()->getWebsiteId());
						$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
						$model->setName($name);
						$model->setValue($modifiedvalue);

						if(isset($configfields[$name]) && isset($configfields[$name]['source_model'])) {
						
							$sourcemodel = App::model($configfields[$name]['source_model'])->setConfigModel($model)->setRequest($this->getRequest())->saveConfig();
							continue;
						}
						App::dispatchEvent('Configuration_Admin_Save_Before',array('config' => $model));
						$model->save();
						App::dispatchEvent('Configuration_Admin_Save_After',array('config' => $model));
						$model->unsetData();
					} 
					Notice::add(Notice::SUCCESS, __('Configuration Updated'));
					
				} else {
					App::model('store/session')->setDatas('errors',$validate->getErrors());
					Notice::add(Notice::ERROR, __('Problem in update'));
				}

			} catch(Kohana_Exception $e) {
				Kohana_Exception::log($e);
				Notice::add(Notice::ERROR, $e->getMessage());
			}
		}
		$return = 'settings/general';
		if($return_url = trim($this->getRequest()->post('return_url'),"/")) {
			$return = $return_url;
		}  
		$this->_redirect($return);

	}

	private function _checkisFile($array)
	{
		if(Upload::valid($array)) {
			return true;
		}
		return false;
	}

	private function singletonFields($array = array())
	{
		$result = array();
		foreach($array as $fields)
		{
			if(isset($fields['fields'])) {
				$result = array_merge($result,$fields['fields']); 
			}
		}
		return $result;
	}
	

} // End Dashboard
