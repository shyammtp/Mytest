<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Searches_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;        
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('searchlist');        				
    }

    protected function _prepareQuery()
    {
		$session = App::model('user/session');
		$user = App::model('user',false)->setData($session->getFormData());
		$user_id = $session->getId();
		
        $db = DB::select('*')->from(array(DB::select(DB::expr("date_part('days', now() - created_date) AS days"),'*')->from(array(App::model('core/usersearches')->getTableName(),'main_table'))->and_where('user_id','=',$user_id)->order_by('id','ASC'),'search'));        
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
        $this->addColumn('search_name',
             array(
                'header'=> __('Search Name'), 
                'type'  => 'text',
                'index' => 'search_name',                            
                'sortable' => false,  
                'default_value' => '--',                                                
        ));
        $this->addColumn('search_url',
             array(
                'header'=> __('URL'), 
                'type'  => 'text',
                'index' => 'search_url',                    
                'sortable' => false,   
                'default_value' => '--',   
                'renderer' => 'Front/Account/Searches/Renderer/Url'                                                                                   
        )); 
        $this->addColumn('created_date',
             array(
                'header'=> __('Date'), 
                'type'  => 'date',
                'index' => 'created_date',                    
                'sortable' => false, 
                'style' => 'width:15%;',
                'default_value' => 0,                                                                                        
        ));         
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'sortable' => false,
                'style' => 'width:15%;',                
                'renderer' => 'Front/Account/Searches/Renderer/Actions'
        ));     
               
        return parent::_prepareColumns();
    }
	
}
