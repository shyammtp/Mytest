	<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Country_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = true;
		$this->_massUpdate = true;
		
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('countrylist');
		$this->massElementname = 'country_id';
		//$this->setFilterVisibility(false);
    }

    protected function _prepareQuery()
    {
		//$languageId = App::getCurrentLanguageId(); 
		//$language_sql= '(case when (select count(*) as totalcount from '.App::model('admin/city/info')->getTableName().' as info where info.language_id = '.$languageId.' and city_label_id = main_table.city_label_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $db = DB::select('main_table.country_id','country_code','created_date','updated_date','main_table.country_status')->from(array(App::model('admin/country/settings')->getTableName(),'main_table'))
					->joinLanguage(App::model('core/country'),'main_table','info_main_table',1,array(array('info_main_table.country_name','lang_country_name')));
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
		$this->addColumn('country_id',
             array(
                'header'=> __('Country Id'), 
                'type'  => 'text',
                'filter' => false,
                'index' => 'country_id',                     
        ));
        $this->addColumn('country',
             array(
                'header'=> __('Country'), 
                'type'  => 'text',
                'index' => 'lang_country_name',  
                'filter_index' => 'info_main_table.country_name',                   
        ));
        $this->addColumn('country_code',
             array(
                'header'=> __('Country Code'), 
                'type'  => 'text',
                'index' => 'country_code',                     
        ));
        $this->addColumn('country_status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'country_status',
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
                'renderer' => 'Admin/Country/Renderer/Actions',
        ));
       
        return parent::_prepareColumns();
    }

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add Country'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/settings/editcountry')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Add Country"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('country_id');
		$this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete'),
             'url'      => App::helper('url')->getUrl('admin/settings/massdeletecountry'),
             'confirm'  => __('Are you sure want to delete?')
        ));
		 
        return $this;
	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/settings/editcountry', array('id'=>$row->getData('country_id')));
    } 
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/settings/ajaxcountry',$this->getRequest()->query());
        }
		return false;
	}
}
