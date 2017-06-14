<?php defined('SYSPATH') OR die('No direct script access.');

class Model_Domain_Validate_Website extends Model_Abstract {
    
    public function checkWebsiteValidate($data)
    {
        $validate = Validation::factory($data) 
                    ->rule('web_index','not_empty')
                    ->rule('web_index','alpha_dash')
                    ->rule('name','not_empty')
                    ->rule('web_url','url');
        $websiteid = '';
        if(isset($data['website_id'])) { 
           $websiteid = $data['website_id'];
        }
        $validate->rule('web_index',array($this,'_validateWebIndex'),array(":value",$websiteid));
         if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function _validateWebIndex($value,$webid = '')
    {
        $db = DB::select(array(DB::expr('count(website_id)'),'total'))->from(App::model('core/website')->getTableName())
                    ->where('web_index','=',$value);
        if($webid) {
            $db->where('website_id','!=',$webid);
        }
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
            
    }
}
