<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model 
*/
class Model_Admin_Notification_Reply extends Model_Core_Notification_Reply {
 	
	public function __construct()
    {
        $this->_table = 'notification_reply';
        $this->_primaryKey = 'reply_id';
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
		$customer = App::model('admin/session')->getCustomer();			
		$userid = $customer->getUserId();
		$replyIds = array();
		$replytable = '(select co.message from "'.$this->getTableName().'" as co where co.reply_id = main_table.reply_id)';
		$deleteReply = DB::select('reply_id')->from(App::model('admin/notification/replydelete')->getTableName())
						->where('msg_id','=',$id)
						->where('user_id','=',$userid)
						->execute()->as_array();
		if(!empty($deleteReply)) {				
			foreach($deleteReply as $key => $item) {
				$replyIds[] = $item['reply_id'];
			}
		}		
		$db = DB::select('main_table.sender','main_table.post_date','main_table.reply_id',DB::Expr($replytable))
						->from(array(App::model('admin/notification/users')->getTableName(),'main_table'))
						->where('main_table.msg_id','=',$id)
						->where('main_table.reply_id','!=',false)
						->where('main_table.d_status','=',false);
		if(!empty($replyIds)) {
			$db->where('main_table.reply_id','NOT IN',$replyIds);	
		}		
		$db->group_by('main_table.reply_id');
		$db->group_by('main_table.sender');
		$db->group_by('main_table.post_date');
		//$db->group_by('main_table.d_status');
		$db->order_by('main_table.post_date', 'DESC');			
		return $db->execute()->as_array();
	}
	public function getRepliesResponse($id) {
		$responses = $this->getReplies($id);
		foreach($responses as $response) {
			$userreplymodel = App::model('user',false)->selectAttributes('*')->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($response['sender']);
			$html = '<div class="prd_dashbb notificat replyresponse-'.$response['reply_id'].'"><div class="prd_dash_top pad10 reply_details" data-id="'.$response['reply_id'].'"><div class="prod_dash_left widaut">';
            $html .= '<span class="margr5 clr6">'.$userreplymodel->getData('first_name').'</span></div><div class="prod_dash_right pull-right widaut"><span class="clr4 fnt10">'.App::helper('date')->timeAgo($response['post_date']).'</span><a title="Delete" class="delete" data-id="'.$response['reply_id'].'" class="color_chan margr5"><span class="glyphicon glyphicon-trash fnt15"></span></a></div></div><div class="prd_dash_bott pad10 marg10 show_details-'.$response['reply_id'].'"><div class="prd_dash_bott_left"><div class="displ">'.$response['message'].'</div></div></div></div>';
            return $html;
		}
				
	}
	public function getUserId($id) {
		print $db = DB::select('main_table.from')->from(array($this->getTableName(),'main_table'))
						->where('main_table.msg_id','=',$id)
						->order_by('main_table.msg_id', 'DESC')
						->limit(1); 
		foreach($db as $user) {
			return $user['sender'];
		}
	}
	
	public function getReplyDeleteItems($sender,$msgid,$replyid) {
		return $db = DB::select('*')->from(array(App::model('admin/notification/users')->getTableName(),'main_table'))
						->where('main_table.sender','=',$sender)
						->where('main_table.msg_id','=',$msgid)
						->where('main_table.reply_id','=',$replyid)
						->execute()->as_array();						
	}
    
}
