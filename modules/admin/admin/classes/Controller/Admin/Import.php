<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Import extends Controller_Core_Admin { 
	
	public function preDispatch()
	{  
		parent::preDispatch();
	}
	
	public function action_load()
	{
		$request = $this->getRequest();
		if(!Arr::get($request->post(),'type') || empty($_FILES['file'])) {
			Notice::add(Notice::ERROR,__('Invalid Data'));
			$this->_redirect('admin/settings/cache');
		}
		$data = Arr::merge($_FILES,$request->post());
		$session = App::model('admin/session');
		try {
			$file = Arr::get($data,'file');
			$ext = pathinfo(Arr::get($file,'name'),PATHINFO_EXTENSION); 
			$filename = Text::random('numeric',8).".".$ext;
			$uploadfile = Upload::save(Arr::get($data,'file'),$filename,DOCROOT.'uploads/import',0777);
			$importdata = $this->_importData($filename,$data);
			$errmsg = '';
			$successmsg = '';
			$successrows = Arr::get($importdata,'success_rows',array());
			if(count(Arr::get($importdata,'errors',array()))) {
				$errmsg .= 'Errors in rows: <br/>';
			}
			if(count($successrows)) {
				$successmsg .= '<b>Success Rows are :</b> '.implode(", ",$successrows);				 
			}
			foreach(Arr::get($importdata,'errors',array()) as $row => $error) {
				$errmsg .= 'Row No #'.$row.': '.$error;
				$errmsg .= '<br/>';
			}
			if($errmsg) {
				$session->setDatas('import_error_msg', $errmsg);
			}
			if($successmsg) {
				$session->setDatas('import_success_msg', $successmsg); 
			}
			if( count($successrows)) {
				Notice::add(Notice::SUCCESS,__(':totalrows Data Imported successfully',array(':totalrows' => count($successrows))));
			}
		} catch(Kohana_Exception $e) {
		} catch(Exception $e) {
		}
		$this->_redirect('admin/settings/cache');
	}
	
	private function _importData($file, $data)
	{

		$responses = array();  
		$type = explode("::",Arr::get($data,'type'));
		try {
			$model = App::model(strtolower(Arr::get($type,0)),false);
			if(method_exists($model, Arr::get($type,1))) { 
				call_user_func_array(array($model,Arr::get($type,1)),array($file,$data,&$responses)); 
			}
		} catch (Exception $e) {  
		}

		return $responses;
	}
}
