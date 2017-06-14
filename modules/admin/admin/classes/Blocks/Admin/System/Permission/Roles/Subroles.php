<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Roles_Subroles extends Blocks_Core_Widget_List
{
    public function __construct()
    { 
        $this->_itemPerPage = 10;
        $this->_useAjax = false;
        $this->_defaultSort = 'role_id';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('subrolelist');
    }

    public function getRolesList()
    {
        return App::model('core/role')->getSubRolesListQuery();
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
                'style' => 'width:20%;',

        ));
        $this->addColumn('role_name',
             array(
                'header'=> __('Role Name'),
                'type'  => 'text',
                'index' => 'role_name',
                'style' => 'width:20%;',
                //'filter' => false
        ));
        $this->addColumn('place_name',
             array(
                'header'=> __('Place Name'),
                'type'  => 'text',
                'index' => 'place_name',
                'style' => 'width:25%;',
                //'filter' => false
        ));
        $this->addColumn('created_date',
             array(
                'header'=> __('Created Date'),
                'type'  => 'date',
                'index' => 'created_date',
                'style' => 'width:20%;',
                'filter' => false,
                
        ));
        $this->addColumn('updated_date',
             array(
                'header'=> __('Updated Date'),
                'type'  => 'text',
                'index' => 'updated_date',
                'style' => 'width:20%;',
                'filter' => false
        ));
        return parent::_prepareColumns();
    }


}
