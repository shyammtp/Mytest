<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Url_List extends Blocks_Core_Widget_List
{ 
    public function __construct()
    {
		$this->_defaultSort = 'request_path';
		$this->_defaultDir = 'asc';
        $this->_useAjax = false;
        $this->_useScroll = true;
        parent::__construct();
        $this->setId('url_listings');
    }
   
    protected function _prepareQuery()
    {
        $db = DB::select('*')->from(array(App::model('domain/urlrewrite')->getTableName(),'main_table'));
        $this->setQueryData($db);
        parent::_prepareQuery();
		if($this->getRequest()->is_ajax()) {
			
		}
        return $this;
    }
    
     protected function _prepareColumns()
    {
        $this->addColumn('route_name',
             array(
                'header'=> __('Route Name'),
                'type'  => 'text',
                'index' => 'routename',
                'width' => '50px'
        ));
        $this->addColumn('request_path',
             array(
                'header'=> __('Request Path'),
                'type'  => 'text',
                'index' => 'request_path',
                'width' => '50px'
        ));
         $this->addColumn('target_path',
             array(
                'header'=> __('Target Path'),
                'type'  => 'text',
                'index' => 'target_path',
				'width' => '50px'
        ));
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'index' =>'status',
                'filter' => false,
                'style' => 'width:10%',
                'sortable' => false,
                'renderer' => 'Admin/Url/Renderer/Actions'
        ));
        return parent::_prepareColumns();
    }
    
     protected function _prepareButtonsBlock()
	{
		if(App::hasTask('domain/list/edit_url')){
			$this->addButtons('add_new', array(
				'label'   => __('Add URL Rewrite'),
				'onclick' => "setLocation('".App::helper('url')->getUrl('domain/list/edit_url')."')",
				'class'   => 'btn btn-primary tip',
				'title' => __("Add URL rewrite"),
			));
		}
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 
		if(App::hasTask('domain/list/edit_url')){
			return App::helper('url')->getUrl('domain/list/edit_url', array( 
				'id'=>$row->getData('id'))
			);
		}
    }
	public function getScrollUrl()
    { 
        return App::helper("url")->getUrl('domain/list/ajaxload',$this->getRequest()->query());         
    }
}
