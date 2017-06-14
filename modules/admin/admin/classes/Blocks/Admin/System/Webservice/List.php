<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Webservice_List extends Blocks_Core_Widget_List
{
    public function __construct()
    { 
        $this->_useAjax = false;
        $this->_defaultSort = 'app_key';
		$this->_defaultDir = 'asc';
        parent::__construct();
        $this->setId('webservicelist');
    }


    public function getCacheList()
    { 
       $subsql = '(case when (select count(*) as totalcount from place_info as pinfo where language_id = 2 and place_id = pi.place_id) > 0 THEN 2 ELSE 1 END)';
        return  DB::select('ap.*')
                            ->from(array(App::model('core/api')->getTableName(),'ap'))->where('ap.reference_place_id','=',App::instance()->getPlace()->getPlaceId());
     
    }

    protected function _prepareQuery()
    {
        $this->setQueryData($this->getCacheList());
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('app_key',
             array(
                'header'=> __('API Key'),
                'type'  => 'text',
                'index' => 'app_key',
        )); 
        
       /* $this->addColumn('user_email',
             array(
                'header'=> __('Email'),
                'type'  => 'text',
                'index' => 'email',
                'default_value' => '--',
        ));
        
        $this->addColumn('place_name',
             array(
                'header'=> __('Place'),
                'type'  => 'text',
                'index' => 'place_name', 
        ));
        */

        $this->addColumn('created_date',
             array(
                'header'=> __('Added Date'),
                'type'  => 'date',
                'index' => 'created_date',
                'style' => 'width:25%',
                'sortable' => false,
        )); 
        
        $this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
                'sortable' => false,
                'renderer' => 'Admin/System/Webservice/List/Renderer/Actions',
        ));
 

        return parent::_prepareColumns();
    }
    
    protected function _prepareButtonsBlock()
	{ 
        $url= App::helper('url')->getUrl('admin/system_webservice/edit');
        $this->addButtons('add_new', array(
            'label'   => __('Add New'),
            'onclick' => "setLocation('".$url."')",
            'class'   => 'btn btn-primary tip',
            'title' => __("Add new"),
        ));
		return parent::_prepareButtonsBlock(); 

	}
	
	public function getRowUrl($row)
    {
        return App::helper('url')->getUrl('admin/system_webservice/edit', array(
            'id'=>$row->getAccountId())
        );
    }

   /* public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("admin")->getAdminUrl('admin/system/cacheajax',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }*/
}
