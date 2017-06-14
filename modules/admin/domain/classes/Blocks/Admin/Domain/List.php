<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Domain_List extends Blocks_Core_Widget_List
{ 
    public function __construct()
    {
        $this->_itemPerPage = 10;
        $this->_useAjax = true; 
        $this->_defaultSort = 'website_id';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('website_listing');
        $this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';
    }
    
    protected function _prepareQuery()
    {
        $select = DB::select('*')->from(array(App::model('core/website')->getTableName(),'main_table'))
                            ->where('main_table.website_id','!=',0);
        $this->setQueryData($select);
        parent::_prepareQuery();
        return $this;
    }
     
    protected function _prepareColumns()
    {
        $this->addColumn('website_id',
             array(
                'header'=> __('Website ID'), 
                'type'  => 'int',
                'index' => 'website_id',
                'width' => '50px'
        ));
        $this->addColumn('website_name',
             array(
                'header'=> __('Website Name'), 
                'type'  => 'text',
                'index' => 'website_name', 
        ));
        $this->addColumn('web_url',
             array(
                'header'=> __('Website URL'), 
                'type'  => 'text',
                'index' => 'web_url', 
        ));
        $this->addColumn('status',
             array(
                'header'=> __('Status'), 
                'type'  => 'select',
                'index' => 'status',
                'sortable' => false,
                'options' => array(
                    1 => __('Enabled'),
                    0 => __("Disabled"),
                ),
                'renderer' => 'Core/Widget/List/Column/Renderer/Status'
        ));
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'), 
                'type'  => 'action', 
                'filter' => false,
                'sortable' => false,
                'actions' => array(
                    array('link' => array( 'base_url' => App::helper('admin')->getAdminUrl('domain/list/edit')),'label' => __('Edit'),'index' => array('id' => 'website_id'))
                ),
                'renderer' => 'Admin/Domain/Renderer/Actions'
        ));
       
        return parent::_prepareColumns();
    }
     
    public function getRowUrl($row)
    { 
        return App::helper('url')->getUrl('domain/list/edit', array( 
            'id'=>$row->getWebsiteId())
        );
    }
    
    public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("url")->getUrl('domain/list/ajaxlist',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
    
   /** protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add new website'),
            'onclick' => "setLocation('".App::helper('url')->getUrl('domain/list/edit')."')",
            'class'   => 'btn btn-primary tip',
			'title' => __('Add new website'),
        ));
		return parent::_prepareButtonsBlock();
	}
	*/
}
