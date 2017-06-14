<?php defined('SYSPATH') OR die('No direct script access.');
class Model_Requirements_Comments extends Model_Core_Requirements_Comments {
 
  public function validate($data)
    { 				
        $validate = Validation::factory($data);
        $validate->label('requirement_info_id','Place')
				 ->rule('requirement_info_id','not_empty')                 
                 ->label('comments','Comments')
                 ->rule('comments','not_empty');                                         
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }      
	
}
