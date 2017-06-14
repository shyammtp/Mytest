<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Banner_Settings extends Model_Core_Banner {

    public function validate($data)
    { 		
        $validate = Validation::factory($data);
        $validate->label('banner_title',__('Main Title'))
                ->rule('banner_title','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)))                
                //->rule('banner_title','regex', array(':value', '/^[-\pL\pN_. ]++$/uD'))
                ->label('banner_link',__('Link'))
                ->rule('banner_link','url')                                 
                //->rule('banner_image', 'Upload::not_empty')                                             
                ->rule('banner_image', 'Upload::type', array(':value', array('jpg', 'jpeg', 'png', 'gif')))                
                ->rule('banner_image', 'Upload::size', array(':value', '1M'));                                          
              
        $bannerid = '';
        if(isset($data['banner_setting_id'])) { 
           $bannerid = $data['banner_setting_id'];
        }        
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        if(isset($data['banner_image'])) {
			$image = $data['banner_image']['name'];
			if($image) {
				$directory = '../uploads/banner/';						
				$upload = Upload::save($data['banner_image'],$image,$directory);								
			}
		}        
        return $this;
    }
    
	public function getOptions($QueryId)
    {
        if(!$QueryId) {
            return array();
        }
        if(!$this->_options) {
            $select = DB::select('*')->from(array($this->getTableName(),'main_table'))
                        ->where('main_table.banner_setting_id','=',$QueryId)
                        ->execute($this->getDbConfig())->as_array();
            $this->_options = $select;
        }
        return $this->_options;
    }

}
