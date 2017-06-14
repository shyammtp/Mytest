<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Store_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_itemPerPage = 10;
        $this->_useAjax = true;
        parent::__construct();
        $this->setId('roleslist');
    }


    protected function _prepareQuery()
    {
        $select = DB::select()->from(array(App::model('core/store')->getTableName(),'main_table'))
                            ->where('website_id','=', $this->getRequest()->query('id'));
        $this->setQueryData($select);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('store_id',
             array(
                'header'=> __('Role ID'),
                'type'  => 'text',
                'index' => 'store_id',
        ));
        $this->addColumn('name',
             array(
                'header'=> __('Store Name'),
                'type'  => 'text',
                'index' => 'name',
        ));
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
                'sortable' => false,
                'actions' => array(
                    array('link' => array( 'base_url' => App::helper('url')->getUrl('admin/system_permission_roles/edit')),'label' => __('Edit'),'index' => array('id' => 'store_id'))
                )
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return App::helper('url')->getUrl('admin/system_permission_roles/edit', array(
            'id'=>$row->getStoreId())
        );
    }

    public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("url")->getUrl('admin/system_permission_roles/ajax',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
}