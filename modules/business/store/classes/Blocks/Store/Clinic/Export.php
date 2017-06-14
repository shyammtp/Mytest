<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Clinic_Export extends Blocks_Core_Widget_List
{
    public function __construct()
    {     
        $this->_defaultSort = 'clinic_id';  
		$this->_defaultDir = 'desc';
        parent::__construct();
        $this->setId('cliniclist');     
		$this->_emptyText = '<div class=""><h5>'.__('No records found.').'</h5>';

    } 
	
	protected function _prepareExportQuery()
    {
		$session = App::model('store/session');
        //$db = App::model('store/clinic',false)->selectAttributes('*');
        
        $sub_query = '(select entity_id from '.App::model('insurance/entity')->getTableName().' where entity_type_id = '.Model_Clinic::ENTITY_TYPE_ID.' and insurance_id = '.(int)$session->getInsuranceId().')';
        
        $result = App::model('clinic',false)->selectAttributes('*')->filter('clinic_status',array('=',1));
		if($this->getRequest()->query('type')) {
			$result->filter('type',array('=',$this->getRequest()->query('type')));	 
		}else{
			$result->filter('type',array('=',Model_clinic::CLINIC));	 
		}
		$result->filter('clinic_id',array('in',DB::expr($sub_query)));
		$this->setQueryData($result);
        parent::_prepareExportQuery();
        return $this;
    }
	
	protected function _prepareExportColumns()
	{
		$this->addExportColumn('clinic_id',
             array(
                'header'=> __('ID'),
                'type'  => 'range',
                'index' => 'clinic_id', 
        ));
        
		$this->addExportColumn('clinic_name',
             array(
                'header'=> __('Name'), 
                'type'  => 'text',
                'index' => 'clinic_name',                     
        ));
        
		$this->addExportColumn('sub_text',
             array(
                'header'=> __('Sub Text'), 
                'type'  => 'text',
                'index' => 'sub_text',                     
        ));
        
		$this->addExportColumn('address',
             array(
                'header'=> __('Address'), 
                'type'  => 'text',
                'index' => 'address',                     
        ));
        
		$this->addExportColumn('about',
             array(
                'header'=> __('About'), 
                'type'  => 'text',
                'index' => 'about',                     
        ));
        
		$this->addExportColumn('phone',
             array(
                'header'=> __('Phone'), 
                'type'  => 'text',
                'index' => 'phone',                     
        ));
        
		$this->addExportColumn('services',
             array(
                'header'=> __('Services'), 
                'type'  => 'text',
                'index' => 'services',                     
        ));
		      
		$this->addExportColumn('facilities',
             array(
                'header'=> __('Facilities'), 
                'type'  => 'text',
                'index' => 'facilities',                     
        ));
		      
        $this->addExportColumn('created_date',
             array(
                'header'=> __('Created Date'),
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
