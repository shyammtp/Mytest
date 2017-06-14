<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model 
*/
class Model_Admin_Advert extends Model_Abstract {
 	
	public function __construct()
    {
        $this->_table = 'adverts';
        $this->_primaryKey = 'adverts_id';
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
    
    public function validate($data)
    { 				
        $validate = Validation::factory($data);
        $validate->rule('title','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)))
                 ->rule('description','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)))
                 ->rule('place_type','not_empty')
                 ->rule('place_id','not_empty');                 
        $languageid = '';
        if(isset($data['adverts_id'])) { 
           $languageid = $data['adverts_id'];
        }
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function validateEdit($data)
    { 				
        $validate = Validation::factory($data);
        $validate->rule('title','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)))
                 ->rule('description','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)));                 
        $languageid = '';
        if(isset($data['adverts_id'])) { 
           $languageid = $data['adverts_id'];
        }
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function getplaces($id) {		
		return $query = DB::select('place_id','place_index')->from('place_entity')->where('place_category_id', '=', $id)->execute()->as_array();
	}
	
	public function save()
    {		
        $request = Request::current();  
        App::dispatchEvent('Adverts_Save_Before',array('post'=> $request->post(),'advert' => $this));
        parent::save();
        App::dispatchEvent('Adverts_Save_After',array('post'=> $request->post(),'advert' => $this));
        return $this;

    }
    
    public function getLabel($fieldname, $languageid = 1)
    { 
        $select = App::model('admin/advert_label')->getAdvertLabels($languageid,$this->getAdvertsId());
        return $select->getData($fieldname);
    }
    
    public function saveBlock() {
		parent::save();
	}
    
}
