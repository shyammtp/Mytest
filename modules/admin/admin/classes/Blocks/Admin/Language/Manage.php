<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Language_Manage extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false;
        $this->_defaultSort = 'language_name';
		$this->_defaultDir = 'asc';
		$this->massElementname = 'language_id';
        $this->setId('language_setting_listings');
       //$this->setFilterVisibility(false);
		$this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';
    } 
    
    protected function _prepareQuery()
    {		
        $db = DB::select('*')->from(array(App::model('admin/language_settings')->getTableName(),'main_table'));
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
    
     protected function _prepareColumns()
    {
        $this->addColumn('language_name',
             array(
                'header'=> __('Language Name'),
                'type'  => 'text',
                'index' => 'name',
                'style'=>'width:20%;',
                'default_value' => '--',
        ));
        $this->addColumn('language_code',
             array(
                'header'=> __('Language Code'),
                'type'  => 'text',
                'index' => 'language_code',
                'default_value' => '--',
                'style'=>'width:15%;',

        ));
         $this->addColumn('date_format_short',
             array(
                'header'=> __('Short Date Format'),
                'type'  => 'text',
                'index' => 'date_format_short',
				'style'=>'width:15%;',
				'filter' => false,
				'default_value' => '--',
        ));
        $this->addColumn('date_format_full',
             array(
                'header'=> __('Full Date Format'),
                'type'  => 'text',
                'index' => 'date_format_full',
                'style'=>'width:15%;',
                'filter' => false,
                'default_value' => '--',
        ));
            
        $this->addColumn('status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'status',
				'style' => 'width:15%',
				'sortable' => false,
				'options' => array(
					0 => __('Disabled'),
					1 => __('Enabled'),
				),
        ));    
       /* $this->addColumn('created_date',
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
        ));  */
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'style' => 'width:10%',
                'sortable' => false,
                'renderer' => 'Admin/Language/Renderer/Actions'
        ));
        return parent::_prepareColumns();
    }
    
     protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add Language'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('admin/settings/edit_language')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __("Add language"),
        ));
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 		
        return App::helper('url')->getUrl('admin/settings/edit_language', array('id'=>$row->getData('language_id')));
    } 
    
}
