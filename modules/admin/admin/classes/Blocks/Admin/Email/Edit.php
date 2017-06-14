<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Email_Edit extends Blocks_Admin_Abstract
{ 
	protected $_subject;
	
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getSubjectSettings()
    { 
		if(!$this->_subject){
			$this->_subject = App::model('admin/email_subject')->load($this->getRequest()->query('id'));
		}
		return $this->_subject;
    }
    
    protected function _getTemplates()
    { 		
		$this->_template = DB::select('template_id','ref_name')
							->from(array(App::model('admin/email_template')->getTableName(),'main_table'))
							->execute()->as_array();
		
		return $this->_template;
    }
    
    public function _getSubjectTypes() {		
		return $this->_subject_type = App::model('admin/email_subject')->getSubjectType();		
	}

    
}
