<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Email_Template extends Model_Core_Email_Template {
 
    public function validate()
    { 
        $validate = Validation::factory($this->getData());
        $validate->label('ref_name',__('Reference Name'))
                ->label('from_email',__('From Email')) 
                ->rule('ref_name','not_empty')
                ->rule('from_email','not_empty')
                ->rule('subject','not_empty')
                ->rule('content','not_empty')
                //->rule('mobile_content','not_empty')
                ->rule('ref_name',array($this,'_validateReferenceName'),array(":value"))
                ->rule('from_email','email',array(":value"));               
        
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function _validateReferenceName($value)
    { 
        $select = DB::select('template_id')->from(array($this->getTableName(),'main_table'))
                            ->where('main_table.ref_name','=',$value)
                            ->and_where('main_table.template_id','!=', $this->getTemplateId())
                            ->as_object()
                            ->execute();
        if(count($select)==0) {
            return true;
        }
        return false;
    }
    
    public function saveTemplate()
    {
        $request = Request::current();
        App::dispatchEvent('Admin_Email_Template_Save_Before',array('post'=> $request->post(),'template' => $this));
        $this->save();
        App::dispatchEvent('Admin_Email_Template_Save_After',array('post'=> $request->post(),'template' => $this));
        return $this;
    }
}
