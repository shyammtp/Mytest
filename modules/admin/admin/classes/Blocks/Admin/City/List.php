	<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_City_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = true;     
        $this->_massUpdate = true;   
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('citylist');  
        $this->massElementname = 'city_id';      		
		//$this->setFilterVisibility(false);
    }

    protected function _prepareQuery()
    {
		//$languageId = App::getCurrentLanguageId(); 
		//$language_sql= '(case when (select count(*) as totalcount from '.App::model('admin/city/info')->getTableName().' as info where info.language_id = '.$languageId.' and city_label_id = main_table.city_label_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $db = DB::select('main_table.city_id', 'main_table.created_date','main_table.updated_date','main_table.city_status')->from(array(App::model('admin/city/settings')->getTableName(),'main_table'))
			->joinLanguage(App::model('core/city'),'main_table','info_main_table',App::getCurrentLanguageId(),array(array('info_main_table.city_name','lang_city_name')))
			
			->join(array(App::model('core/country')->getTableName(),'country'))
			->on('country.country_id','=','main_table.country_id')
			->joinLanguage(App::model('core/country'),'country','info_country',App::getCurrentLanguageId(),array(array('info_country.country_name','lang_country_name')));
			
			
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
		$this->addColumn('city_id',
             array(
                'header'=> __('City Id'), 
                'type'  => 'text',
                'filter' => false,
                'index' => 'city_id',                     
        ));
        $this->addColumn('country',
             array(
                'header'=> __('Country'), 
                'type'  => 'text',
                'index' => 'lang_country_name',
				'filter_index' => 'info_country.country_name',
        ));
        $this->addColumn('city',
             array(
                'header'=> __('City'), 
                'type'  => 'text',
                'index' => 'lang_city_name',
				'filter_index' => 'info_main_table.city_name',
        ));
        $this->addColumn('city_status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'city_status',
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
                'renderer' => 'Admin/City/Renderer/Actions',
        ));
       
        return parent::_prepareColumns();
    }

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add City'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/settings/editcity')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Add City"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('city_id');
		$this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete'),
             'url'      => App::helper('url')->getUrl('admin/settings/massdeletecity'),
             'confirm'  => __('Are you sure want to delete?')
        ));
		 
        return $this;
	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/settings/editcity', array('id'=>$row->getData('city_id')));
    } 
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/settings/ajaxcity',$this->getRequest()->query());
        }
		return false;
	}
}
