	<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Clinic_List extends Blocks_Core_Widget_List
{
    public function __construct()
    {
        $this->_useAjax = false;
        $this->_useScroll = true;   
        $this->_massUpdate = true;
        $this->_defaultSort = 'created_date';      
		$this->_defaultDir = 'desc';
        parent::__construct();
        $this->massElementname = 'clinic_id';
        $this->setId('cliniclist');        		
		//$this->setFilterVisibility(false);
    }

    protected function _prepareQuery()
    {
		$session = App::model('store/session');
        
        $sub_query = '(select entity_id from '.App::model('insurance/entity')->getTableName().' where entity_type_id = '.Model_Clinic::ENTITY_TYPE_ID.' and insurance_id = '.(int)$session->getInsuranceId().')';
        
        $result = App::model('clinic',false)->selectAttributes('*')->filter('clinic_status',array('=',1));
		if($this->getRequest()->query('type')) {
			$result->filter('type',array('=',$this->getRequest()->query('type')));	 
		}else{
			$result->filter('type',array('=',Model_clinic::CLINIC));	 
		}
		$result->filter('clinic_id',array('in',DB::expr($sub_query)));
 		$this->setQueryData($result);
        parent::_prepareQuery();
        return $this;
    }

    protected function _prepareColumns()
    {
		
		$this->addColumn('clinic_id',
             array(
                'header'=> App::registry('place_name').' '.__('Id'), 
                'type'  => 'text',
                'filter' => false,
                'index' => 'clinic_id',                     
        ));
        $this->addColumn('clinic',
             array(
                'header'=> App::registry('place_name'), 
                'type'  => 'text',
                'index' => 'clinic_name',                     
        ));
        $this->addColumn('clinic_status',
             array(
                'header'=> __('Status'),
                'type'  => 'select',
				'renderer' => 'Core/Widget/List/Column/Renderer/Status',
                'index' => 'clinic_status',
				'style' => 'width:15%',
				'sortable' => false,
				'options' => array(
					0 => __('Disabled'),
					1 => __('Enabled'),
				),
        ));       
        $this->addColumn('created_date',
             array(
                'header'=> __('Created Date'),
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
                'index' =>'status',
                'filter' => false,
                'sortable' => false,
                'renderer' => 'Store/Clinic/Renderer/Actions',
        ));
       
        return parent::_prepareColumns();
    }

    protected function _prepareButtonsBlock()
	{
		$this->addButtons('add_new', array(
            'label'   => __('Add :place_name',array(':place_name' => App::registry('place_name'))),
            'onclick' => "setLocation('".App::helper('store')->getStoreUrl('clinic/editclinic',array('type' => $this->getRequest()->query('type')))."')",
            'class'   => 'btn btn-primary tip',
			'title' => __('Add :place_name',array(':place_name' => App::registry('place_name'))),
        ));
        $this->addButtons('exports', array(
			'label'   => '<i class="fa fa-cloud-upload"></i>'." ". __('Export'),
			'class'   => 'btn btn-primary dropdown-toggle tip',
			'title' => __("Export as Excel"), 
			'onclick' => "setLocation('".App::helper('store')->getStoreUrl('clinic/exportexcel',$this->getRequest()->query())."')", 
			'href' => "javascript:;"
			
       ));
		return parent::_prepareButtonsBlock();
	}
	
	public function getRowUrl($row)
    { 		
        //return App::helper('url')->getUrl('admin/clinic/editclinic', array('id'=>$row->getData('clinic_id')));
    } 
    
    protected function _prepareMassaction()
	{
		$this->setMassactionIdField('clinic_id');
		$this->getMassactionBlock()->addItem('delete', array(
             'label'    => __('Delete'),
             'url'      => App::helper('store')->getStoreUrl('clinic/massdeleteclinic',$this->getRequest()->query()),
             'confirm'  => __('Are you sure want to delete?')
        ));
		 
        return $this;
	}
    
    public function getScrollUrl()
	{ 
		if($this->_useScroll) {
            return App::helper("store")->getStoreUrl('clinic/ajaxclinic',$this->getRequest()->query());
        }
		return false;
	}
	
	public function getListUrl()
	{   
        return App::helper("store")->getStoreUrl('clinic/index',$this->getRequest()->query());         
	} 
}
