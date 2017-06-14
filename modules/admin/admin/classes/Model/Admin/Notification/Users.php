<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model 
*/
class Model_Admin_Notification_Users extends Model_Core_Notification_Users {
 	    
    public function validate($data)
    { 				
        $validate = Validation::factory($data);
        $validate->rule('user_id','not_empty')
                 ->rule('subject','not_empty')
                 ->rule('message','not_empty');                 
        $languageid = '';
        if(isset($data['id'])) { 
           $languageid = $data['id'];
        }
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
     public function getNotifyReadStatus($msgid,$userid) {
		$select = DB::select('*')->from(array(App::model('admin/notification/users')->getTableName(),'main_table'))->where('main_table.msg_id','=',$msgid)->and_where('main_table.receiver','=',$userid)->execute()->as_array();
		return $select;						
	}
	
	public function getNotifyDeleteStatus($msgid,$userid) {
		$select = DB::select('*')->from(array(App::model('admin/notification/users')->getTableName(),'main_table'))->where('main_table.msg_id','=',$msgid);
		//$select->and_where('main_table.receiver','=',$userid);
		$result = $select->execute()->as_array();
		return $result;						
	}
	
	public function getMessageValid($msgid,$userid,$type) {
		$db = DB::select(array(DB::expr('count(id)'),'total'))->from(array(App::model('admin/notification/users')->getTableName(),'main_table'))->where('main_table.msg_id','=',$msgid);
		if($type == 'inbox') {
			$db->and_where('main_table.receiver','=',$userid);	
		} else if($type == 'sent') {
			$db->and_where('main_table.sender','=',$userid);
		}		
		$db->and_where('main_table.d_status','=',false);		
		$select = $db->execute()->get('total');
        return $select > 0 ? true: false;        
	}
    
}
