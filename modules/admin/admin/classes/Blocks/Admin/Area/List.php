	<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Area_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = true;   
        $this->_massUpdate = true;       
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('arealist');        
        $this->massElementname = 'area_id';   		
		//$this->setFilterVisibility(false);
    }

    protected function _prepareQuery()
    {
		//$languageId = App::getCurrentLanguageId(); 
		//$language_sql= '(case when (select count(*) as totalcount from '.App::model('admin/city/info')->getTableName().' as info where info.language_id = '.$languageId.' and city_label_id = main_table.city_label_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $db = DB::select('main_table.area_id', 'main_table.created_date','main_table.updated_date','main_table.area_status')->from(array(App::model('admin/area/settings')->getTableName(),'main_table'))
		->joinLanguage(App::model('core/area'),'main_table','info_main_table',1,array(array('info_main_table.area_name','lang_area_name')))
		
			->join(array(App::model('core/city')->getTableName(),'city'))
			->on('city.city_id','=','main_table.city_id')
			->joinLanguage(App::model('core/city'),'city','info_city',App::getCurrentLanguageId(),array(array('info_city.city_name','lang_city_name')))
			
			
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
		$this->addColumn('area_id',
             array(
                'header'=> __('Area Id'), 
                'type'  => 'text',
                'filter' => false,
                'index' => 'area_id',                     
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
				'filter_index' => 'info_city.city_name',
        ));
        $this->addColumn('area',
             array(
                'header'=> __('Area'), 
                'type'  => 'text',
                'index' => 'lang_area_name',
				'filter_index' => 'info_main_table.area_name',
        ));
        $this->addColumn('area_status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'area_status',
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
                'renderer' => 'Admin/Area/Renderer/Actions',
        ));
       
        return parent::_prepareColumns();
    }

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add Area'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/settings/editarea')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Add Area"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('area_id');
		$this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete'),
             'url'      => App::helper('url')->getUrl('admin/settings/massdeletearea'),
             'confirm'  => __('Are you sure want to delete?')
        ));
		 
        return $this;
	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/settings/editarea', array('id'=>$row->getData('area_id')));
    } 
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/settings/ajaxarea',$this->getRequest()->query());
        }
		return false;
	}
}
