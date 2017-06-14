<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Language_Settings extends Model_Core_Language {
 
	/*public function __construct()
    {
        $this->_table = 'language';
        $this->_primaryKey = 'language_id';
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }*/
    
    public function validate($data)
    { 
        $validate = Validation::factory($data);
        $validate->label('language','Language')
                ->rule('language_name','not_empty')
                ->rule('language_code','not_empty');
        $languageid = '';
        if(isset($data['language_id'])) { 
           $languageid = $data['language_id'];
        }
        $validate->rule('language_code',array($this,'_validateLanguage'),array(':value',$languageid));
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    

    
    public function _validateLanguage($value,$languageid = '')
    { 
        $db = DB::select(array(DB::expr('count(language_id)'),'total'))->from($this->getTableName())
                    ->where('language_code','=',$value);
        if($languageid) {
            $db->where('language_id','!=',$languageid);
        }
        $select = $db->execute()->get('total');
        return $select > 0 ? false: true;
    }
    
	

}
