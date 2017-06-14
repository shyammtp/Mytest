<?php defined('SYSPATH') OR die('No direct script access.');

class Model_Domain_Validate_Store extends Model_Abstract {
    
    public function checkWebsiteValidate($data)
    {
        $validate = Validation::factory($data) 
                    ->rule('store_index','not_empty')
                    ->rule('store_index','alpha_dash')
                    ->rule('name','not_empty');
        $storeid = '';
        if(isset($data['store_id'])) { 
           $storeid = $data['store_id'];
        } 
         $validate->rule('store_index',array($this,'_validateStoreIndex'),array(":value",$storeid));
        return $validate;
    }
    
    public function _validateStoreIndex($value,$storeid = '')
    {
        $db = DB::select(array(DB::expr('count(store_id)'),'total'))->from(App::model('core/store')->getTableName())
                    ->where('store_index','=',$value);
        if($storeid) {
            $db->where('store_id','!=',$storeid);
        }
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
            
    }
}