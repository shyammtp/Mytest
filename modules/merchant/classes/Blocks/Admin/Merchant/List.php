<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Merchant_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = false;
        $this->_massUpdate = false;
		$this->_defaultSort = 'user_id';
		$this->_defaultDir = 'desc';
        parent::__construct();
        $this->setId('usersslist');
        $this->massElementname = 'user_id';
		$this->setFilterVisibility(true);
    }


    protected function _prepareQuery()
    {

        $languageId = App::getCurrentLanguageId();
        $language_sql= '(case when (select count(place_id) as totalcount from '.App::model('core/place_info')->getTableName().' as info where info.language_id = '.$languageId.' and place_id = pe.place_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $select = DB::select('info.place_name',array(DB::expr('case when pe.status then 1 else 0 end'),'status'),'pe.created_date','pe.updated_date','pe.place_index')->from(array(App::model('core/place')->getTableName(),'pe'))
                        ->join(array(App::model('core/place_info')->getTableName(),'info'),'inner')
                        ->on('pe.place_id','=','info.place_id')
                        ->on('info.language_id','=',DB::expr($language_sql)); 
		 		
        $this->setQueryData($select);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {

        $this->addColumn('place_name',
             array(
                'header'=> __('Name'),
                'type'  => 'text',
                'index' => 'place_name',
				'style' => 'width:20%',
				'default_value' => '--',
        )); 

		$this->addColumn('status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'status',
                'default_value' => '--',
				'style' => 'width:15%',
				'options' => array(
					false => __('Disabled'),
					true => __('Enabled'),
				),
        ));
 
        
        $this->addColumn('updated_date',
             array(
                'header'=> __('Updated Date'),
                'type'  => 'date',
                'index' => 'updated_date',
				'style' => 'width:10%', 
				'default_value' => '--',
        ));

		$this->addColumn('edit_action',
             array(
                'header'=> __('Actions'),
                'type'  => 'action',
                'filter' => false,
				'style' => 'width:12%',
                'sortable' => false, 
				'renderer' => 'Admin_Merchant_Renderer_Actions',
        ));
        return parent::_prepareColumns();
    }

    public function getListUrl()
    {
        return App::helper("admin")->getAdminUrl('admin/merchant/index',$this->getRequest()->query());        
    }
    
    public function getRowUrl($row)
    {  
		return App::helper('url')->getUrl('admin/merchant/view', array( 
			'id'=>$row->getPlaceIndex())
		); 
    }

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
			'label'   => __('Add New'),
			'onclick' => "setLocation('".App::helper('url')->getUrl('admin/merchant/edit')."')",
			'class'   => 'btn btn-primary tip',
			'title' => __("Add New"),
		));
		/*$this->addButtons('exports', array(
			'label'   => '<i class="fa fa-cloud-upload"></i>'." ". __('Export'),
			'class'   => 'btn btn-primary dropdown-toggle tip',
			'title' => __("Export as Excel"), 
			'onclick' => "setLocation('".App::helper('url')->getUrl('admin/users/exportexcel',$this->getRequest()->query())."')", 
			'href' => "javascript:;"
			
       ));*/
		return parent::_prepareButtonsBlock();
	}
	
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('user_id');
		$this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete'),
             'url'      => App::helper('url')->getUrl('admin/users/massdeleteuser'),
             'confirm'  => __('Are you sure want to delete?')
        ));
		 
        return $this;
	}
	
	public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/users/ajaxlist',$this->getRequest()->query());
        }
		return false;
	}
}
