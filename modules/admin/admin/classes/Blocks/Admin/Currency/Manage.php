<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Currency_Manage extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false; 
		$this->_defaultSort = 'currency_name';
		$this->_defaultDir = 'asc';
		$this->massElementname = 'currency_setting_id';
        $this->setId('currency_setting_listing');
        //$this->setFilterVisibility(false);
    } 
    
	protected function _prepareQuery()
    {		
        $db = DB::select('*')->from(array(App::model('admin/currency_settings')->getTableName(),'main_table'));
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
    
    /** Manage rewards **/ 
    protected function _prepareColumns()
    {

        $this->addColumn('currency_name',
             array(
                'header'=> __('Currency Name'), 
                'type'  => 'text',
                'index' => 'currency_name', 
                'style'=>'width:20%;',
                'default_value' => '--',
        ));
		 $this->addColumn('currency_code',
             array(
                'header'=> __('ISO code'), 
                'type'  => 'text',
                'index' => 'currency_code', 
                'style'=>'width:15%;',
                'default_value' => '--',
        ));
         $this->addColumn('numeric_iso_code',
             array(
                'header'=> __('Numeric ISO Code'), 
                'type'  => 'text',
                'index' => 'numeric_iso_code', 
                'style'=>'width:15%;',
                'default_value' => '--',
        ));
		 $this->addColumn('currency_symbol_left',
             array(
                'header'=> __('Currency Symbol Left'), 
                'type'  => 'int',
                'index' => 'currency_symbol_left', 
                'style'=>'width:15%;',
                'filter'=>false,
                'default_value' => '--',
        ));
        $this->addColumn('currency_symbol_right',
             array(
                'header'=> __('Currency Symbol Right'), 
                'type'  => 'text',
                'index' => 'currency_symbol_right', 
                'style'=>'width:15%;',
                'filter'=>false,
                'default_value' => '--',
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
				'renderer' => 'Admin/Currency/Renderer/Actions',
        ));
        return parent::_prepareColumns(); 
    }

	
	protected function _prepareButtonsBlock()
	{ 
		$url = App::helper('url')->getUrl('admin/settings/edit_currency');
		$this->addButtons('add_new', array(
			'label'   => __('Add New Currency'),
			'onclick' => "setLocation('".$url."')",
			'class'   => 'btn btn-primary tip',
			'title' => __("Add new currency"),
		)); 
		return parent::_prepareButtonsBlock(); 

	}

	public function getListUrl()
    {
        if($this->_useAjax) {
            //return App::helper("url")->getUrl('admin/template/ajaxlist',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
    
    public function getRowUrl($row)
    { 
        return App::helper('url')->getUrl('admin/settings/edit_currency', array('id'=>$row->getData('currency_setting_id')));
    } 

}
