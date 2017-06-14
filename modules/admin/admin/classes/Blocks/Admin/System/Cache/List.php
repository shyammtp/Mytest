<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Cache_List extends Blocks_Core_Widget_List
{
    public function __construct()
    { 
        $this->_useAjax = true;
        $this->_defaultSort = 'id';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('cachelist');
    }


    public function getCacheList()
    {
        return  DB::select('*')->from(array(App::model('core/cache')->getTableName(),'main_table'));
    }

    protected function _prepareQuery()
    {
        $this->setQueryData($this->getCacheList());
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id',
             array(
                'header'=> __('Cache ID'),
                'type'  => 'int',
                'index' => 'id',
        ));
        $this->addColumn('type',
             array(
                'header'=> __('Type'),
                'type'  => 'text',
                'index' => 'cache_id',
                //'filter' => false,
                //'sortable' => false,
                'renderer' => 'Admin/System/Cache/Renderer/Type',
        ));

        $this->addColumn('desc',
             array(
                'header'=> __('Description'),
                'type'  => 'text',
                'index' => 'cache_id',
                //'filter' => false,
                //'sortable' => false,
                'renderer' => 'Admin/System/Cache/Renderer/Description',
        ));

        $this->addColumn('status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
                'index' => 'status',
                'renderer' => 'Admin/System/Cache/Renderer/Status',
                'options' => array(
                    0 => __('Disabled'),
                    1 => __('Enabled')
                )
        ));

        return parent::_prepareColumns();
    }

    public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("admin")->getAdminUrl('admin/system/cacheajax',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
}
