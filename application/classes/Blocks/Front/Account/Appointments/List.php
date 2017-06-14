<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Appointments_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;        
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('appointmentlist');            			
    }

    protected function _prepareQuery()
    {
		$session = App::model('user/session');
		$user = App::model('user',false)->setData($session->getFormData());
		$user_id = $session->getId();
		
        //$db = DB::select('*')->from(array(DB::select(DB::expr("date_part('days', now() - created_date) AS days"),'*')->from(array(App::model('core/usersearches')->getTableName(),'main_table'))->and_where('user_id','=',$user_id)->order_by('id','ASC'),'search'));        
        $languageId = App::getCurrentLanguageId(); 
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('core/place_info')->getTableName().' as info where info.language_id = '.$languageId.' and place_id = pinfo.place_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		
		$db = DB::select('people_name','place_name','booking_id','appointment_name','info','mobile_number',array(DB::expr('(case when accept_date != appointment_date then accept_date else appointment_date end)'),'appointment_date'),array('appointment_date','old_date'),'accept','comment','user_accept')->from(array(App::model('core/appointment/booking')->getTableName(),'a'))
					->join(array(App::model('core/peoples')->getTableName(),'b'),'left')
					->on('a.people_id','=','b.people_id')
					->join(array(App::model('core/place_info')->getTableName(),'pinfo'),'left')
					->on('b.place_id','=','pinfo.place_id')
					->on('pinfo.language_id','=',DB::expr($language_sql))
					->where('a.user_id','=',$user_id)
					->order_by('booking_id','desc');
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
		$this->addColumn('id',
             array(
                'header'=> __('S.No'), 
                'type'  => 'int',
                'index' => 'id',                            
                'sortable' => false,
                'filter' => false,                         
                'textbg' => 'bg',                                        
        ));
        $this->addColumn('people_name',
             array(
                'header'=> __('People Name'),
                'type'  => 'text',
                'index' => 'people_name',  
                'default_value' => '--', 
                'sortable' => false,                                                           
        ));
        $this->addColumn('place_name',
             array(
                'header'=> __('Place Name'),
                'type'  => 'text',
                'index' => 'place_name',  
                'default_value' => '--',      
                'sortable' => false,                                                        
        ));
        $this->addColumn('appointment_name',
             array(
                'header'=> __('Appointment Name'),
                'type'  => 'text',
                'index' => 'appointment_name',  
                'default_value' => '--',     
                'sortable' => false,                                                     
        ));
        $this->addColumn('info',
             array(
                'header'=> __('Info'),
                'type'  => 'text',
                'index' => 'info',      
                'default_value' => '--',  
                'truncate_length' => 250,
                'sortable' => false,                   
        ));
        $this->addColumn('mobile_number',
             array(
                'header'=> __('Mobile Number'),
                'type'  => 'text',
                'index' => 'mobile_number', 
                'default_value' => '--',    
                'sortable' => false,                            
        ));                       
        $this->addColumn('appointment_date',
             array(
                'header'=> __('Appointment Date'),
                'type'  => 'date',
                'index' => 'appointment_date',
				'style' => 'width:10%', 
				'default_value' => '--',
				'sortable' => false,
				 'renderer' => 'Front/Account/Appointments/Renderer/Appointmentdate'
        ));        
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action', 
                'filter' => false,
                'sortable' => false,
                'style' => 'width:15%;',                
                'renderer' => 'Front/Account/Appointments/Renderer/Actions'
        ));     
               
        return parent::_prepareColumns();
    }
	
}
