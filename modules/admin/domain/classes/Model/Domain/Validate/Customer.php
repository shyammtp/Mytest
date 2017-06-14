<?php defined('SYSPATH') OR die('No direct script access.');

class Model_Domain_Validate_Customer extends Model_Abstract {
    
    public function checkCustomerValidate($data)
    {
        $validate = Validation::factory($data) 
                    ->rule('username','not_empty') 
                    ->rule('username','alpha_dash')
                    ->rule('firstname','not_empty')
                    ->rule('email','email') ; 
        $validate->rule('username',array($this,'_validateUsername'),array(":value"));
        $validate->rule('email',array($this,'_validateEmail'),array(":value"));
        return $validate;
    }
    
    public function _validateUsername($value)
    {
        $db = DB::select(array(DB::expr('count(customer_id)'),'total'))->from(App::model('core/customer')->getTableName())
                    ->where('username','=',$value)->where('website_id','=',0);
        /*if($storeid) {
            $db->where('store_id','!=',$storeid);
        }*/
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
            
    }
    
    public function _validateEmail($value)
    {
        $db = DB::select(array(DB::expr('count(customer_id)'),'total'))->from(App::model('core/customer')->getTableName())
                    ->where('email','=',$value)->where('website_id','=',0);
        /*if($storeid) {
            $db->where('store_id','!=',$storeid);
        }*/
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
            
    }
}