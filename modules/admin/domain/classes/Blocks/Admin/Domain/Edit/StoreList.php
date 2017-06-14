<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Domain_Edit_StoreList extends Blocks_Core_Widget_List
{
    public function __construct()
    { 
        $this->_itemPerPage = 10;
        $this->_useAjax = true; 
        parent::__construct();
        $this->setId('storelist');
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
                'header'=> __('Store ID'), 
                'type'  => 'text',
                'index' => 'store_id', 
        ));
        $this->addColumn('store_index',
             array(
                'header'=> __('Store Code'), 
                'type'  => 'text',
                'index' => 'store_index', 
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
                    array('link' => array( 'base_url' => App::helper('url')->getUrl('domain/store/edit',array('website_id' => $this->getRequest()->query('id'),'popup' => true,'tab' => 'stores'))),
                                        'label' => __('Edit'),
                                        'index' => array('id' => 'store_id'),
                                        'popup' => true
                        )
                )
        ));
       
        return parent::_prepareColumns();
    }
     
    public function getRowUrl($row)
    { 
        return App::helper('url')->getUrl('domain/store/edit', array( 
            'id'=>$row->getStoreId())
        );
    }
    
    public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("url")->getUrl('domain/list/storeajaxlist',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
}