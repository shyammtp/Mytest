<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Managecategory extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        parent::__construct();
        $this->_useAjax = false;
        $this->_useScroll = true;
		$this->_defaultSort = 'title';
		$this->_defaultDir = 'asc';
		$this->massElementname = 'place_category_id';
        $this->setId('category_listing');
        $this->setFilterVisibility(false);
		$this->_dbconfig = 'gis'; 
    }

    public function getRootCatId()
    {
        if(!$this->hasData('root_category_id')) {
            $this->setData('root_category_id',App::instance()->getWebsite()->getRootCategoryid());
        }
        return $this->getData('root_category_id');
    }
    
	protected function _prepareQuery()
    { 
		$parentcat=0;
		if($this->getRequest()->query('id')){
			$parentcat = $this->getRequest()->query('id');
		}   
		$languageId = App::getCurrentLanguageId(); 
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('core/category_info')->getTableName().' as info where info.language_id = '.$languageId.' and place_category_id = main_table.place_category_id) > 0 THEN '.$languageId.' ELSE 1 END)';
        $db = DB::select('*')->from(array(App::model('core/category')->getTableName(),'main_table'))
							->join(array(App::model('core/category_info')->getTableName(),'info'))
							->on('info.place_category_id','=','main_table.place_category_id')
							->on('info.language_id','=',DB::expr($language_sql))
							->where('main_table.category_parent_id','=',$parentcat)
							->where('main_table.place_category_id','!=',0);					
        $this->setQueryData($db); 
        parent::_prepareQuery();
        return $this;
    }
    
    /** Manage rewards **/ 
    protected function _prepareColumns()
    {
		 $this->addColumn('title',
             array(
                'header'=> __('Title'), 
                'type'  => 'text',
                'index' => 'place_name',
                'filter' => false,
                'sortable'=>false,
                'style'=>'width:40%;',
                //'renderer' => 'Admin/Category/Renderer/Detaillink', 
        ));
        $this->addColumn('description',
             array(
                'header'=> __('Description'), 
                'type'  => 'text',
                'index' => 'place_description',
                'textlimit' => '15',
                'filter' => false,
                'sortable'=> false,
                'default_value'=>'--',
                //'renderer' => 'Admin/Category/Renderer/Textlimit',
                'style'=>'width:40%;',
        ));
       
        $this->addColumn('status',
             array(
                'header'=> __('Actions'), 
                'type'  => 'select',
                'index' => 'status',
                'sortable' => false,
                'filter' => false,
                'options' => array(
                    1 => __('Enabled'),
                    0 => __("Disabled"),
                ),
                'renderer' => 'Admin/Category/Renderer/Blockunblock',
        ));
        return parent::_prepareColumns(); 
    }

	
	protected function _prepareButtonsBlock()
	{
		$parentcat=$this->getRootCatId();
		if($this->getRequest()->query('id')){
			$parentcat=$this->getRequest()->query('id');
			$url= App::helper('url')->getUrl('admin/category/editcategory',array('id'=>$parentcat));
			if(App::hasTask('admin/category/editcategory')){
				$this->addButtons('add_new', array(
					'label'   => __('Add New Category'),
					'onclick' => "setLocation('".$url."')",
					'class'   => 'btn btn-primary tip',
					'title' => __("Add New Category"),
				));
			}
        }
		return parent::_prepareButtonsBlock(); 

	}

	public function getListUrl()
    {
        if($this->_useAjax) {
            return App::helper("url")->getUrl('admin/category/ajaxcategories',$this->getRequest()->query());
        }
        return parent::getListUrl();
    }
    
    public function getRowUrl($row)
    { 
		if(App::hasTask('admin/category/editcategory')){
			return App::helper('url')->getUrl('admin/category/editcategory', array( 'id'=>$this->getRequest()->query('id'),
				'category_id'=>$row->getPlaceCategoryId(),'sub'=>TRUE)
			);
		}
    } 
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("url")->getUrl('admin/category/ajaxcategories',$this->getRequest()->query());
        }
		return false;
	}

}
