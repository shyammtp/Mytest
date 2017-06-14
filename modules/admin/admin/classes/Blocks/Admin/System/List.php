<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_List extends Blocks_Core_Widget_List
{ 
    public function __construct()
    {
		$this->_useScroll = true;  
		$this->_useAjax = false;  
        parent::__construct();
        $this->setId('msg_listings');   
        $this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';                
    }
   
    protected function _prepareQuery()
    {
		$customer = App::model('admin/session')->getCustomer();
		$user_id = $customer->getUserId();		
		/*$db = DB::select('*')->from(array(App::model('admin/message')->getTableName(),'main_table'))
						->join(array(App::model('user/attribute')->getTableName(),'user'))
						->on('main_table.from','=','user.user_id')
						->where('main_table.user_id','=',$user_id)
						->and_where('user.language_id','=',1)
						->and_where('main_table.status','=',1);		
						* */
		$db = DB::select('main_table.msg_id','main_table.subject','main_table.message','main_table.priority','user.post_date',array(DB::Expr("array_to_string(array_agg(sender),',')"),'from'))
						->from(array(App::model('admin/notification/message')->getTableName(),'main_table'))
						->join(array(App::model('admin/notification/users')->getTableName(),'user'))
						->on('main_table.msg_id','=','user.msg_id')
						->where('user.receiver','=',$user_id)												
						->where('user.d_status','=',false)
						->where('user.reply_id','=',false)
						->group_by('main_table.msg_id')
						->group_by('user.post_date');						        								
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
    
     protected function _prepareColumns()
    {
		$this->addColumn('from',
             array(
                'header'=> __('From'),
                'type'  => 'text',
                'index' => 'from',
                'width' => '50px',  
                 'renderer' => 'Admin/System/Renderer/Username'                                                              
        )); 
        $this->addColumn('subject',
             array(
                'header'=> __('Subject'),
                'type'  => 'text',
                'index' => 'subject',                
                'width' => '50px'                
        ));  
        $this->addColumn('message',
             array(
                'header'=> __('Message'),
                'type'  => 'text',
                'index' => 'message',
                'width' => '50px',                              
                'renderer' => 'Admin/System/Renderer/Messagecontent'
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
                'renderer' => 'Admin/System/Renderer/Priority'
        )); 
        $this->addColumn('post_date',
             array(
                'header'=> __('Date'),
                'type'  => 'date',
                'index' => 'post_date',
				'style' => 'width:10%',									
				'renderer' => 'Admin/System/Renderer/Date'				
        ));     
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'style' => 'width:15%',
                'sortable' => false,
                'renderer' => 'Admin/System/Renderer/Actions'
        ));
        return parent::_prepareColumns();
    }
    
     protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Compose Message'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/system/message')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Compose message"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/system/reply_message', array('id'=>$row->getData('msg_id')));
    }
	
	public function getScrollUrl()
    { 
        return App::helper("url")->getUrl('admin/system/inboxajax',$this->getRequest()->query());         
    }
}
