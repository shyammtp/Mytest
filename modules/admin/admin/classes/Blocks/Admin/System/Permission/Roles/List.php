<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Roles_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_itemPerPage = 10;
        $this->_useAjax = false;
        $this->_useScroll = true;
        $this->_defaultSort = 'role_id';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('roleslist');
        //$this->setFilterVisibility(false);
    }

    public function getRolesList()
    {
        return App::model('core/role')->getRolesListQuery();
    }

    protected function _prepareQuery()
    {
        $this->setQueryData($this->getRolesList());
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('role_id',
             array(
                'header'=> __('Role ID'),
                'type'  => 'int',
                'index' => 'role_id',
                'style' => 'width:10%;',
                //'sortable' => false,
        ));
        $this->addColumn('role_name',
             array(
                'header'=> __('Role Name'),
                'type'  => 'text',
                'index' => 'role_name',
                'style' => 'width:70%;',
                //'sortable' => false
        ));
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
                'style' => 'width:20%;',
                'sortable' => false,
                'actions' => array(
                    array('link' => array( 'base_url' => App::helper('admin')->getAdminUrl('admin/system_permission_roles/edit')),'label' => __('Edit'),'index' => array('id' => 'role_id'))
                ),
                'renderer' => 'Admin_System_Permission_Roles_List_Renderer_Actions',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
		if(App::hasTask('admin/system_permission_roles/edit')){
			return App::helper('admin')->getAdminUrl('admin/system_permission_roles/edit', array(
				'id'=>$row->getRoleId())
			);
		}
    }

    public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("admin")->getAdminUrl('admin/system_permission_roles/ajax',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
	
	public function getScrollUrl()
    { 
        return App::helper("url")->getUrl('admin/system_permission_roles/ajax',$this->getRequest()->query());         
    }
}
