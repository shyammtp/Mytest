<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Template_Email_Manage extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false;
        $this->_useScroll = true;  
		$this->_defaultSort = 'template_id';
		$this->_defaultDir = 'desc';
		$this->massElementname = 'template_id';
        $this->setId('category_listing');
        //$this->setFilterVisibility(false);
    } 
    
	protected function _prepareQuery()
    {
        $db = DB::select('*')->from(array(App::model('core/email_template')->getTableName(),'main_table'));
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
    
    /** Manage rewards **/ 
    protected function _prepareColumns()
    {
		 $this->addColumn('template_id',
             array(
                'header'=> __('ID'), 
                'type'  => 'int',
                'index' => 'template_id', 
                'style'=>'width:10%;', 
        ));
		 $this->addColumn('ref_name',
             array(
                'header'=> __('Name'), 
                'type'  => 'text',
                'index' => 'ref_name', 
                'style'=>'width:25%;',
        ));
		 $this->addColumn('from_email',
             array(
                'header'=> __('From Email'), 
                'type'  => 'text',
                'index' => 'from_email', 
                'style'=>'width:15%;',
        ));
		 $this->addColumn('is_system',
             array(
                'header'=> __('System'), 
                'type'  => 'select',
                'index' => 'is_system', 
                'options' => array('1' => 'System', '0' => 'Custom'), 
                'style'=>'width:10%;',
				'renderer' => 'Admin/Template/Email/Renderer/System',
        ));
        $this->addColumn('subject',
             array(
                'header'=> __('Subject'), 
                'type'  => 'text',
                'index' => 'subject', 
                'style'=>'width:25%;',
        ));
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
				'style' => 'width:12%',
                'sortable' => false, 
				'renderer' => 'Admin/Template/Email/Renderer/Actions',
        ));
        return parent::_prepareColumns(); 
    }

	
	protected function _prepareButtonsBlock()
	{ 
		$url = App::helper('url')->getUrl('admin/template/edit');
		if(App::hasTask('admin/template/edit')) {
			$this->addButtons('add_new', array(
				'label'   => __('Add New Template'),
				'onclick' => "setLocation('".$url."')",
				'class'   => 'btn btn-primary tip',
				'title' => __("Add new template"),
			));
		}
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
		if(App::hasTask('admin/template/edit')) {
			return App::helper('url')->getUrl('admin/template/edit', array('id'=>$row->getData('template_id')));
		}
    }
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/template/ajaxtemplatelist',$this->getRequest()->query());
        }
		return false;
	}  

}
