<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Requirements_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_defaultSort = 'rate';        
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('requirementlist');        				
    }

    protected function _prepareQuery()
    {
		$session = App::model('user/session');
		$user = App::model('user',false)->setData($session->getFormData());
		$user_id = $session->getId();
		
        $db = DB::select('*')->from(array(DB::select(DB::expr("date_part('days', now() - created_date) AS days"),'*')->from(array(App::model('requirements')->getTableName(),'main_table'))->and_where('user_id','=',$user_id)->order_by('requirement_id','ASC'),'req'));        
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
		$this->addColumn('requirement_id',
             array(
                'header'=> __('S.No'), 
                'type'  => 'int',
                'index' => 'requirement_id',                            
                'sortable' => false,   
                'filter' => false,       
                'textbg' => 'bg',                                        
        ));
        $this->addColumn('additional_info',
             array(
                'header'=> __('Product / Service'), 
                'type'  => 'text',
                'index' => 'additional_info',                            
                'sortable' => false,  
                'default_value' => '--',                                                
        ));
        $this->addColumn('location',
             array(
                'header'=> __('Location'), 
                'type'  => 'text',
                'index' => 'location',                    
                'sortable' => false,   
                'default_value' => '--',                                                                                      
        )); 
        $this->addColumn('days',
             array(
                'header'=> __('No of Days Posted'), 
                'type'  => 'int',
                'index' => 'days',                    
                'sortable' => false, 
                'style' => 'width:15%;',
                'default_value' => 0,                                                                                        
        ));
        $this->addColumn('price_from',
             array(
                'header'=> __('Price From'), 
                'type'  => 'int',
                'index' => 'price_from',                    
                'sortable' => false,    
                'default_value' => '--',  
                'renderer' => 'Front/Account/Requirements/Renderer/Price',                                                                                
        ));
        $this->addColumn('price_to',
             array(
                'header'=> __('Price To'), 
                'type'  => 'int',
                'index' => 'price_to',                    
                'sortable' => false,    
                'default_value' => '--',  
                'renderer' => 'Front/Account/Requirements/Renderer/Price',                                                                                
        ));
        $this->addColumn('no_of_forwards',
             array(
                'header'=> __('No of Forwards'), 
                'type'  => 'int',
                'index' => 'no_of_forwards',                    
                'sortable' => false,  
                'default_value' => 0,
                'renderer' => 'Front/Account/Requirements/Renderer/Places',                                                                                      
        ));   
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'sortable' => false,
                'style' => 'width:15%;',
                'actions' => array(
                    array('link' => array( 'base_url' => App::helper('front')->getUrl('account/blockrequirement')),'label' => __('Fulfilled'),'index' => array('id' => 'requirement_id'))
                ),
                'renderer' => 'Front/Account/Requirements/Renderer/Actions'
        ));     
               
        return parent::_prepareColumns();
    }
	
}
