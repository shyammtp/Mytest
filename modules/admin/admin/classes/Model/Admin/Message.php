<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model 
*/
class Model_Admin_Message extends Model_Core_Message {
    
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
    
    public function getMessages($id) {
		$langid = 1;		
		return $db = DB::select(array('main_table.id', 'msgid'),array('main_table.message', 'message'),'main_table.subject',array('main_table.created_date', 'date'),array('main_table.priority', 'priority'),array('co.value', 'user'),'main_table.reply_status')
								->from(array(App::model('admin/message')->getTableName(),'main_table'))
								->join(array(App::model('user/attribute')->getTableName(),'co'),'left')
								->on('main_table.from','=','co.user_id')
								->where('main_table.user_id','=',$id)
								->and_where('main_table.status','=',1)
								->and_where('main_table.read_status','=',0)
								->and_where('co.language_id','=',$langid)
								->order_by('main_table.id', 'DESC')	
								->limit(2)							
								->execute()->as_array();
	}
	
	public function getReplyMessages($id) {
		$langid = 1;	
				
		return $db = DB::select(array('main_table.email_message_id', 'msgid'),array('main_table.message', 'message'),'mainmessage.subject',array('main_table.updated_date', 'date'),array('mainmessage.priority', 'priority'),array('co.value', 'user'),'mainmessage.reply_status')
								->from(array(App::model('admin/reply')->getTableName(),'main_table'))
								->join(array(App::model('user/attribute')->getTableName(),'co'),'left')
								->on('main_table.from','=','co.user_id')
								->join(array(App::model('admin/message')->getTableName(),'mainmessage'),'left')
								->on('mainmessage.id','=','main_table.email_message_id')
								->where('main_table.user_id','=',$id)
								->and_where('main_table.status','=',1)
								->and_where('main_table.read_status','=',0)
								->and_where('co.language_id','=',$langid)
								->order_by('main_table.id', 'DESC')	
								->limit(3)							
								->execute()->as_array();
	}
    
    public function getUsername($id) {
		$langid = 1;
		$db = DB::select('value')->from(array(App::model('user/attribute')->getTableName(),'main_table'))
			->where('main_table.user_id','=',$id)->and_where('main_table.language_id','=',$langid)
			->limit(1)->execute()->as_array();
		foreach($db as $query) {
			return $query['value'];
		}	
	}	
   
}
