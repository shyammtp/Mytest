<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Email_Manage extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false;
        $this->_useScroll = true; 
		$this->_defaultSort = 'subject';
		$this->_defaultDir = 'asc';		
        $this->setId('email_subject');
        $this->_emptyText = 'No Email Subject Found';
        //$this->setFilterVisibility(false);
    } 
    
	protected function _prepareQuery()
    {	
		
		$languageId = App::getCurrentLanguageId();
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('admin/email_subject/info')->getTableName().' as info where info.language_id = '.$languageId.' and id = main_table.id) > 0 THEN '.$languageId.' ELSE 1 END)';
			
		$db = DB::select('*')->from(array(App::model('admin/email_subject')->getTableName(),'main_table'));
						//->join(array(App::model('admin/email_subject/info')->getTableName(),'info'))
						//->on('main_table.id','=','info.id')
						//->on('info.language_id','=',DB::expr($language_sql));
        $this->setQueryData($db);
        parent::_prepareQuery();
        return $this;
    }
        
    protected function _prepareColumns()
    {       
		$this->addColumn('subject_index',
             array(
                'header'=> __('Subject Type'), 
                'type'  => 'text',
                'index' => 'subject_index', 
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
		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
				'style' => 'width:10%',
                'sortable' => false, 
				'renderer' => 'Admin/Email/Renderer/Actions',
        ));
        return parent::_prepareColumns(); 
    }

	
	protected function _prepareButtonsBlock()
	{ 
		$url = App::helper('url')->getUrl('admin/settings/edit_email_subject');
		if(App::hasTask('admin/settings/edit_email_subject')){
			$this->addButtons('add_new', array(
				'label'   => __('Add New Subject'),
				'onclick' => "setLocation('".$url."')",
				'class'   => 'btn btn-primary tip',
				'title' => __("Add New Subject"),
			)); 
		}
		return parent::_prepareButtonsBlock(); 

	}
	
	public function getRowUrl($row)
    { 		
		if(App::hasTask('admin/settings/edit_email_subject')){
			return App::helper('url')->getUrl('admin/settings/edit_email_subject', array('id'=>$row->getData('id')));
		}
    }
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/settings/emailajaxlist',$this->getRequest()->query());
        }
		return false;
	} 

}
