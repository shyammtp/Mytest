<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model 
*/
class Model_Admin_Reply extends Model_Abstract {
 	
	public function __construct()
    {
        $this->_table = 'email_message_reply';
        $this->_primaryKey = 'id';
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
    
    public function validate($data)
    { 				
        $validate = Validation::factory($data);
        $validate->rule('message','not_empty');                 
        $languageid = '';
        if(isset($data['id'])) { 
           $languageid = $data['id'];
        }
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
	
    public function getReplies($id) {
		$langid = 1;	
					
		return $db = DB::select('main_table.id','user.primary_email_address','co.value','main_table.updated_date','main_table.message','user.profile_image')
						->from(array($this->getTableName(),'main_table'))
						->join(array(App::model('user/attribute')->getTableName(),'co'),'left')
						->on('main_table.from','=','co.user_id')
						->join(array(App::model('user')->getTableName(),'user'),'left')
						->on('user.user_id','=','co.user_id')
						->where('main_table.email_message_id','=',$id)
						->and_where('co.language_id','=',$langid)
						->order_by('main_table.id', 'DESC')						
						->execute()->as_array();
	}
	
	public function getUserId($id) {
		$db = DB::select('main_table.from')->from(array($this->getTableName(),'main_table'))
						->where('main_table.email_message_id','=',$id)
						->order_by('main_table.id', 'DESC')
						->limit(1)
						->execute()->as_array();		
		foreach($db as $user) {
			return $user['from'];
		}
	}
    
}
