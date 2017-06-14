<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Users_Subrolesusers extends Blocks_Core_Widget_List
{
    public function __construct()
    { 
        $this->_itemPerPage = 10;
        $this->_useAjax = false;
        $this->_defaultSort = 'ruid';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('subroleuserlist');
    }

    public function getRolesUsersList()
    {
        return App::model('core/role_users')->getSubUserRolesListObject();
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
                'type'  => 'text',
                'index' => 'ruid',
                'style' => 'width:20%;',

        ));
        $this->addColumn('email',
             array(
                'header'=> __('Email'),
                'type'  => 'text',
                'index' => 'primary_email_address',
                'style' => 'width:20%;',
                //'filter' => false
        ));
        
        $this->addColumn('place_name',
             array(
                'header'=> __('Place Name'), 
                'type'  => 'text',
                'index' => 'place_name',  
				'style' => 'width:15%;'
        ));
        
        $this->addColumn('role_name',
             array(
                'header'=> __('Role Name'), 
                'type'  => 'text',
                'index' => 'role_name',  
				'style' => 'width:15%;'
        ));
        
        $this->addColumn('created_date',
             array(
                'header'=> __('Created Date'),
                'type'  => 'date',
                'index' => 'created_date',
                'style' => 'width:20%;',
                'filter' => false,
                'sortable' => false,
        ));
        $this->addColumn('updated_date',
             array(
                'header'=> __('Updated Date'),
                'type'  => 'text',
                'index' => 'updated_date',
                'style' => 'width:20%;',
                'filter' => false,
                'sortable' => false,
        ));
        return parent::_prepareColumns();
    }


}
