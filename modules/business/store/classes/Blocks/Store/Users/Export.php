<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_Export extends Blocks_Core_Widget_List
{
    public function __construct()
    {    
        $this->_defaultSort = 'user_id';  
		$this->_defaultDir = 'desc';
        parent::__construct();
        $this->setId('departmentlist');     
		$this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';

    } 
	
	protected function _prepareExportQuery()
    {
		$session = App::model('store/session');
		//print_r($session->getData());exit;
		$sub_query = '(select entity_id from '.App::model('insurance/entity')->getTableName().' where entity_type_id = '.Model_User::ENTITY_TYPE_ID.' and insurance_id = '.(int)$session->getInsuranceId().')';
        $select = App::model('user',false)->selectAttributes(array('primary_email_address','first_name','created_date','updated_date','status','social_title','user_type'));
		 	$select->filter('user_id',array('in',DB::expr($sub_query)));

        $this->setQueryData($select);
        parent::_prepareExportQuery();
        return $this;
    }
	
	protected function _prepareExportColumns()
	{
		$this->addExportColumn('user_id',
             array(
                'header'=> __('ID'),
                'type'  => 'int',
                'index' => 'user_id',
				'style' => 'width:8%',
				'default_value' => '--',
        ));
        $this->addExportColumn('social_title',
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
		$this->addExportColumn('user_first_name',
             array(
                'header'=> __('First Name'),
                'type'  => 'text',
                'index' => 'first_name',
				'default_value' => '--',
				'style' => 'width:15%',
        ));

		$this->addExportColumn('email_address',
             array(
                'header'=> __('Email Address'),
                'type'  => 'text',
                'index' => 'primary_email_address',
				'style' => 'width:15%',
				'default_value' => '--',
        ));
		$this->addExportColumn('user_type',
             array(
                'header'=> __('User Type'),
                'type'  => 'select',
				'renderer' => 'Admin/Users/List/Renderer/Type',
                'index' => 'user_type',
                'default_value' => '--',
				'style' => 'width:15%',
				'options' => array(
					1 => __('Doctor'),
					2 => __('Patient'),
				),
        ));

		$this->addExportColumn('status',
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

		$this->addExportColumn('created_date',
             array(
                'header'=> __('Registered On'),
                'type'  => 'date',
                'index' => 'created_date',
				'style' => 'width:10%', 
				'default_value' => '--',
        ));
        
        $this->addExportColumn('updated_date',
             array(
                'header'=> __('Updated Date'),
                'type'  => 'date',
                'index' => 'updated_date',
				'style' => 'width:10%', 
				'default_value' => '--',
        ));
        
		return parent::_prepareExportColumns();
	}
  
}
