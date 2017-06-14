<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Banner_Manage extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false; 
		$this->_defaultSort = 'banner_title';
		$this->_defaultDir = 'asc';
		$this->massElementname = 'banner_setting_id';
        $this->setId('banner_setting_listing');
        //$this->_emptyText = 'No banner found';
        //$this->setFilterVisibility(false);
    } 
    
	protected function _prepareQuery()
    {		
        $db = DB::select('main_table.banner_setting_id','banner_link','created_date','updated_date','status')->from(array(App::model('admin/banner_settings')->getTableName(),'main_table'))
				->joinLanguage(App::model('core/banner'),'main_table','info_main_table',App::getCurrentLanguageId(),array(array('info_main_table.banner_title','info_banner_title'), array('info_main_table.banner_subtitle','info_banner_subtitle')));
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
        
    protected function _prepareColumns()
    {

        $this->addColumn('banner_title',
             array(
                'header'=> __('Banner Title'), 
                'type'  => 'text',
                'index' => 'info_banner_title', 
                'style'=>'width:20%;',
				'filter_index' => 'info_main_table.banner_title',
        ));
		 $this->addColumn('banner_subtitle',
             array(
                'header'=> __('Banner Subtitle'), 
                'type'  => 'text',
                'index' => 'info_banner_subtitle', 
                'style'=>'width:15%;',                
                'default_value' => '--',
				'filter_index' => 'info_main_table.banner_subtitle',
        ));
         $this->addColumn('banner_link',
             array(
                'header'=> __('Banner Link'), 
                'type'  => 'text',
                'index' => 'banner_link', 
                'style'=>'width:15%;',
                'default_value' => '--',
        ));
        $this->addColumn('status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'status',
				'style' => 'width:10%',
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
                'filter' => false,
				'style' => 'width:10%',
                'sortable' => false, 
				'renderer' => 'Admin/Banner/Renderer/Actions',
        ));
        return parent::_prepareColumns(); 
    }

	
	protected function _prepareButtonsBlock()
	{ 
		$url = App::helper('url')->getUrl('admin/settings/edit_banner');
		$this->addButtons('add_new', array(
			'label'   => __('Add New Banner'),
			'onclick' => "setLocation('".$url."')",
			'class'   => 'btn btn-primary tip',
			'title' => __("Add new banner"),
		)); 
		return parent::_prepareButtonsBlock(); 

	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/settings/edit_banner', array('id'=>$row->getData('banner_setting_id')));
    } 

}
