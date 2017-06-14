<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Domain_Urlrewrite extends Model_Abstract {
 	
	public function __construct()
    {
        $this->_table = 'url_rewrite';
        $this->_primaryKey = 'id';
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
    
    public function validate($data)
    { 
        $validate = Validation::factory($data);
        $validate->rule('route_name','not_empty')
                 ->rule('request_path','not_empty')
                 ->rule('target_path','not_empty')
                 ->rule('website_id','not_empty')
                 ->rule('for','not_empty');
                 //->rule('additional_param','not_empty');
        $languageid = '';
        if(isset($data['id'])) { 
           $languageid = $data['id'];
        }
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
}
