<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Adverts_List extends Blocks_Core_Widget_List
{ 
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false;
        $this->_useScroll = true;  
        $this->setId('url_listings');
        //$this->setFilterVisibility(false);
        $this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';
    }
   
    protected function _prepareQuery()
    {		
		$languageId = App::getCurrentLanguageId(); 
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('admin/advert_info')->getTableName().' as info where info.language_id = '.$languageId.' and adverts_id = main_table.adverts_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $db = DB::select('*')->from(array(App::model('admin/advert')->getTableName(),'main_table'))
			->join(array(App::model('admin/advert_info')->getTableName(),'info'))
			->on('info.adverts_id','=','main_table.adverts_id')
			->on('info.language_id','=',DB::expr($language_sql))			
			->order_by('main_table.created_date','desc');		
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
    
     protected function _prepareColumns()
    {
        $this->addColumn('title',
             array(
                'header'=> __('Title'),
                'type'  => 'text',
                'index' => 'title',
                'width' => '50px',                
                'sortable' => false,                
        ));
        $this->addColumn('description',
             array(
                'header'=> __('Description'),
                'type'  => 'text',
                'index' => 'description',
                'width' => '50px',                
                'sortable' => false,
                'textlimit' => '15',                
        ));  
        $this->addColumn('status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'status',
				'style' => 'width:5%',
				'sortable' => false,
				'options' => array(
					0 => __('Disabled'),
					1 => __('Enabled'),
				),
        )); 
        $this->addColumn('created_date',
             array(
                'header'=> __('Created Date'),
                'type'  => 'date',
                'index' => 'created_date',
				'style' => 'width:10%', 
				'default_value' => '--',
        ));
        
        $this->addColumn('updated_date',
             array(
                'header'=> __('Updated Date'),
                'type'  => 'date',
                'index' => 'updated_date',
				'style' => 'width:10%', 
				'default_value' => '--',
        ));    
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'style' => 'width:10%',
                'sortable' => false,
                'renderer' => 'Admin/Adverts/Renderer/Actions'
        ));
        return parent::_prepareColumns();
    }
    
     protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add Advert'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/adverts/edit_advert')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Add advert"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 
        return App::helper('url')->getUrl('admin/adverts/edit_advert', array( 
            'adverts_id'=>$row->getData('adverts_id'))
        );
    }
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/adverts/ajaxlist',$this->getRequest()->query());
        }
		return false;
	}  
}
