<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = true;
        $this->_massUpdate = true;
		$this->_defaultSort = 'user_id';
		$this->_defaultDir = 'desc';
        parent::__construct();
        $this->massElementname = 'user_id';
        $this->setId('usersslist');
		$this->setFilterVisibility(true);
    }


    protected function _prepareQuery()
    {
		$session = App::model('store/session');
		//print_r($session->getData());exit;
		$sub_query = '(select entity_id from '.App::model('insurance/entity')->getTableName().' where entity_type_id = '.Model_User::ENTITY_TYPE_ID.' and insurance_id = '.(int)$session->getInsuranceId().')';
        $select = App::model('user',false)->selectAttributes(array('primary_email_address','first_name','created_date','updated_date','status','social_title','user_type'));
		 	$select->filter('user_id',array('in',DB::expr($sub_query)));

        $this->setQueryData($select);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {

        $this->addColumn('user_id',
             array(
                'header'=> __('ID'),
                'type'  => 'int',
                'index' => 'user_id',
				'style' => 'width:8%',
				'default_value' => '--',
        ));
        $this->addColumn('social_title',
             array(
                'header'=> __('Social Title'),
                'type'  => 'select',
                'index' => 'social_title',
                'default_value' => '--',
				'default_value' => 'Mr.',
				'style' => 'width:5%',
				'options' => array(
					'Dr.' => 'Dr.',
					'Mr.' => 'Mr.',
					'Mrs.' => 'Mrs.',
					'Ms.' => 'Ms.',
				),

        ));
		$this->addColumn('user_first_name',
             array(
                'header'=> __('First Name'),
                'type'  => 'text',
                'index' => 'first_name',
				'default_value' => '--',
				'style' => 'width:15%',
        ));

		$this->addColumn('email_address',
             array(
                'header'=> __('Email Address'),
                'type'  => 'text',
                'index' => 'primary_email_address',
				'style' => 'width:15%',
				'default_value' => '--',
        ));
		$this->addColumn('user_type',
             array(
                'header'=> __('User Type'),
                'type'  => 'select',
                'filter' => false,
				'renderer' => 'Admin/Users/List/Renderer/Type',
                'index' => 'user_type',
                'default_value' => '--',
				'style' => 'width:15%',
				'options' => array(
					1 => __('Doctor'),
					2 => __('Patient'),
				),
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
					0 => __('Disabled'),
					1 => __('Enabled'),
				),
        ));

		$this->addColumn('created_date',
             array(
                'header'=> __('Registered On'),
                'type'  => 'date',
                'index' => 'created_date',
				'style' => 'width:10%', 
				'default_value' => '--',
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
                'actions' => array(
                    array('link' => array( 'base_url' => App::helper('store')->getStoreUrl('users/edit')),'label' => __('Edit'),'index' => array('id' => 'user_id'))
                ),
				'renderer' => 'Store/Users/List/Renderer/Actions',
        ));
        return parent::_prepareColumns();
    }


    public function getListUrl()
    {
        return App::helper("store")->getStoreUrl('users/index',$this->getRequest()->query());   
    }
   

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
			'label'   => __('Add Doctor'),
			 'onclick' => "setLocation('".App::helper("store")->getStoreUrl('users/edit',array('name' =>1))."')",
			'class'   => 'btn btn-primary tip',
			'title' => __("Add new Doctor"),
		));
		$this->addButtons('exports', array(
			'label'   => '<i class="fa fa-cloud-upload"></i>'." ". __('Export'),
			'class'   => 'btn btn-primary dropdown-toggle tip',
			'title' => __("Export as Excel"), 
			'onclick' => "setLocation('".App::helper("store")->getStoreUrl('users/exportexcel',$this->getRequest()->query())."')", 
			'href' => "javascript:;"
			
       ));
		return parent::_prepareButtonsBlock();
	}
	
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('user_id');
		$this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete'),
             'url'      => App::helper("store")->getStoreUrl('users/massdeleteuser'),
             'confirm'  => __('Are you sure want to delete?')
        ));
		 
        return $this;
	}
	
	public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("store")->getStoreUrl('users/ajaxlist',$this->getRequest()->query());
        }
		return false;
	}
}
