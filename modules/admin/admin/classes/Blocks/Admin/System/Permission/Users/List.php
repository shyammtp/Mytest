<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Users_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;         
        $this->_useScroll = true;
        $this->_defaultSort = 'ruid';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('rolesuser_list');
    }

    public function getRolesUsersList()
    {
        return App::model('core/role_users')->getUserRolesListObject();
    }

    protected function _prepareQuery()
    { 
        $this->setQueryData($this->getRolesUsersList());
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('ruid',
             array(
                'header'=> __('User ID'),
                'type'  => 'int',
                'index' => 'ruid',
        ));
        $this->addColumn('email',
             array(
                'header'=> __('Email'),
                'type'  => 'text',
                'index' => 'primary_email_address'
        ));

        $this->addColumn('role_name',
             array(
                'header'=> __('Role'),
                'type'  => 'select',
                'options' => App::model('core/role')->adminlistoptions(),
                'index' => 'role_name',
                //'renderer' => '',
        ));
        /*$this->addColumn('store_name',
             array(
                'header'=> __('Store Name'),
                'type'  => 'text',
                'index' => 'name'
        ));*/
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
                'sortable' => false,
                'actions' => array(
                    array('link' => array( 'base_url' => App::helper('url')->getUrl('admin/system_permission_users/edit')),'label' => __('Edit'),'index' => array('id' => 'ruid'))
                ),
                'renderer' => 'Admin/System/Permission/Users/List/Renderer/Actions',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
		if(App::hasTask('admin/system_permission_users/edit')){
			return App::helper('url')->getUrl('admin/system_permission_users/edit', array(
				'id'=>$row->getRuid())
			);
		}
    }

    public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("url")->getUrl('admin/system_permission_users/ajax',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
	public function getScrollUrl()
    { 
        return App::helper("url")->getUrl('admin/system_permission_users/ajax',$this->getRequest()->query());         
    }

}
