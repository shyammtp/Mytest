<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Sendmessages_List extends Blocks_Core_Widget_List
{ 
    public function __construct()
    {
		parent::__construct();
		$this->_useAjax = false;   
        $this->_useScroll = true; 
        $this->setId('msg_listings');
        $this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';
    }
   
    protected function _prepareQuery()
    {
		$customer = App::model('admin/session')->getCustomer();
		$user_id = $customer->getUserId();
		$languageId = App::getCurrentLanguageId(); 	
		$language_sql_user= '(case when (select count(*) as totalcount from '.App::model('user/attribute')->getTableName().' as info where info.language_id = '.$languageId.' and user_id = d.user_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		$db = DB::select('main_table.msg_id','main_table.subject','main_table.message','main_table.priority','user.post_date',array(DB::Expr("array_to_string(array_agg(receiver),',')"),'to'),array(DB::Expr("array_to_string(array_agg(value),',')"),'value'))
						->from(array(App::model('admin/notification/message')->getTableName(),'main_table'))
						->join(array(App::model('admin/notification/users')->getTableName(),'user'))
						->on('main_table.msg_id','=','user.msg_id')
						->join(array(App::model('user/attribute')->getTableName(),'d'),'left')
						->on('user.receiver','=','d.user_id')
						->on('d.language_id','=',DB::expr($language_sql_user))
						->where('user.sender','=',$user_id)
						//->where('user.place_id','=',App::instance()->getPlace()->getPlaceId())
						->where('user.d_status','=',false)						
						->where('user.reply_id','=',false)
						->group_by('main_table.msg_id')
						//->group_by('d.value')
						->group_by('user.post_date')	
						->order_by('user.post_date', 'DESC');														
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
    
     protected function _prepareColumns()
    {
		$this->addColumn('value',
             array(
                'header'=> __('To'),
                'type'  => 'text',
                'index' => 'value',
                'width' => '50px',
                //'renderer' => 'Admin/System/Sendmessages/Renderer/Username'                                             
        )); 
        $this->addColumn('subject',
             array(
                'header'=> __('Subject'),
                'type'  => 'text',
                'index' => 'subject',
                'width' => '50px',                
        ));  
        $this->addColumn('message',
             array(
                'header'=> __('Message'),
                'type'  => 'text',
                'index' => 'message',
                'width' => '50px',
                'renderer' => 'Admin/System/Sendmessages/Renderer/Messagecontent',                
        ));       
        $this->addColumn('priority',
             array(
                'header'=> __('Priority'),
                'type'  => 'select',
                'index' => 'priority',
                'width' => '50px',                
                'textlimit' => '15',
                'options' => array(
					'error' => __('Error'),
					'urgent' => __('Urgent'),
					'important' => __('Important'),
					'normal' => __('Normal'),
				),
                'renderer' => 'Admin/System/Sendmessages/Renderer/Priority',
        )); 
        $this->addColumn('post_date',
             array(
                'header'=> __('Date'),
                'type'  => 'date',
                'index' => 'post_date',
				'style' => 'width:10%',				
				'renderer' => 'Admin/System/Sendmessages/Renderer/Date'				
        ));     
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'style' => 'width:15%',
                'sortable' => false,
                'renderer' => 'Admin/System/Sendmessages/Renderer/Actions'
        ));
        return parent::_prepareColumns();
    }
    
    protected function _prepareButtonsBlock()
	{
		if(App::hasTask('admin/system/message')){
			$this->addButtons('add_new', array(
				'label'   => __('Compose Message'),
				'onclick' => "setLocation('".App::helper('url')->getUrl('admin/system/message')."')",
				'class'   => 'btn btn-primary tip',
				'title' => __("Compose message"),
			));
		}
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 	
		if(App::hasTask('admin/system/message')){	
			return App::helper('url')->getUrl('admin/system/reply_message', array('id'=>$row->getData('msg_id'),'type' => 'sent'));
		}
    }
	    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
           return App::helper("url")->getUrl('admin/system/sendmessagesajaxlist',$this->getRequest()->query());         
        }
		return false;
	} 

}
