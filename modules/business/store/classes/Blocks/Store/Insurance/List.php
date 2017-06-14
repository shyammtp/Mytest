	<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Insurance_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = true;       
        $this->_defaultSort = 'created_date';  
		$this->_defaultDir = 'desc';
        parent::__construct();
        $this->setId('insurancelist');        		
		//$this->setFilterVisibility(false);
    }

    protected function _prepareQuery()
    {
		//$languageId = App::getCurrentLanguageId(); 
		//$language_sql= '(case when (select count(*) as totalcount from '.App::model('admin/city/info')->getTableName().' as info where info.language_id = '.$languageId.' and city_label_id = main_table.city_label_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $db = App::model('insurance',false)->selectAttributes('*');
			//->join(array(App::model('admin/city/info')->getTableName(),'info'))
			//->on('info.city_label_id','=','main_table.city_label_id')
			//->on('info.language_id','=',DB::expr($language_sql))
			//->where('main_table.country_status','=',true);		
		$this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('insurance_id',
             array(
                'header'=> __('Insurance Id'), 
                'type'  => 'text',
                'filter' => false,
                'index' => 'insurance_id',                     
        ));
        $this->addColumn('insurance',
             array(
                'header'=> __('Insurance'), 
                'type'  => 'text',
                'index' => 'insurance_name',                     
        ));
        $this->addColumn('insurance_status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'insurance_status',
				'style' => 'width:15%',
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
                'sortable' => false,
                'renderer' => 'Admin/Insurance/Renderer/Actions',
        ));
       
        return parent::_prepareColumns();
    }

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add Insurance'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/insurance/editinsurance')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Add Insurance"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/insurance/editinsurance', array('id'=>$row->getData('insurance_id')));
    } 
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/insurance/ajaxinsurance',$this->getRequest()->query());
        }
		return false;
	}
}
