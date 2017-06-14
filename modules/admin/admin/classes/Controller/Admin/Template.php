<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Template extends Controller_Core_Admin { 
	protected $_template = array();
	
	private function _initTemplate()
	{
		$this->_template = App::model('admin/email_template')->load($this->getRequest()->query('id'));
		return $this;
	}
	
	private function _initBlock()
	{
		$this->loadBlocks('template');
		$this->_initTemplate();
		return $this;
	}
	
	public function action_email()
	{
		$this->_initBlock();
		App::model('admin/session')->unsetData('form_data');
		$this->renderBlocks();
	}
	
	public function action_edit()
	{
		$this->_initBlock(); 
		$session = App::model('admin/session'); 
		$this->getEmailTemplate()->addData((array)$session->getFormData());
		$session->unsetData('form_data'); 
		if($this->getRequest()->query('id') && !$this->getEmailTemplate()->getTemplateId()) { 
            Notice::add(Notice::ERROR, __('Invalid template'));
            $this->_redirect('admin/template/email'); 
		}
		App::register('email_template',$this->_template);
		$this->renderBlocks();
	}
	
	private function getEmailTemplate()
	{
		return $this->_template;
	}
	
	public function action_save()
	{
		$this->_initTemplate();
        $request = $this->getRequest();
       
		$session = App::model('admin/session');  
        $success = false;
        $errors = array();
        try {
			$this->getEmailTemplate()->addData($request->post());
			$this->getEmailTemplate()->validate();
			$this->getEmailTemplate()->saveTemplate();
			$success = true;
			$session->unsetData('form_data');
		} catch(Validation_Exception $ve) {
			$session->setDatas('form_data',$request->post());
            Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
            $errors = $ve->array->errors('validation',true);
        } catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
            Notice::add(Notice::ERROR, __('Problem on the server.'));

        } catch(Exception $e) {
			
            Log::Instance()->add(Log::ERROR, $e);
            Notice::add(Notice::ERROR, __('Problem on the server.'));
        }
		if($success) {
            Notice::add(Notice::SUCCESS, __('Email Template Information Updated'));
			if($request->post('redirectto')) {
				$this->_redirectUrl($request->post('redirectto'));
				return $this;
			}
            $this->_redirect('admin/template/email');
        } 
		$this->_redirect('admin/template/edit',array('id' => $this->getEmailTemplate()->getTemplateId()));
        return $this;
	}
	
	public function action_delete()
	{
		$request = $this->getRequest();
		$id = $request->query('id');
        $success = false;
		$query = $request->query();
		unset($query['id']);
		if($id) {
			try {
				$template = App::model('admin/email_template',false)->load($id);
				if($template->getIsSystem() =='f') {
					$delete = App::model('admin/email_template')->deleterow($id,'template_id');
					$success = true;
				} else {
					Notice::add(Notice::ERROR, __('Access Denied: System template will not be deleted.'));
				}
			} catch(Exception $e) {
				
				Log::Instance()->add(Log::ERROR, $e);
				Notice::add(Notice::ERROR, __('Problem on the server.'));
			}
		}
		if($success) {
            Notice::add(Notice::SUCCESS, __('Template deleted successfully'));  
        }
		$this->_redirect('admin/template/email',$query); 
	}
	
	public function action_view()
	{
		$this->loadBlocks('template');
		$this->renderBlocks();
	}
	
	public function action_ajaxtemplatelist()
	{
		$this->loadBlocks('template');
		$output=$this->getBlock('listing')->toHtml();
		$this->getResponse()->body($output);
	}	
	
} // End of template
