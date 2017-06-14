<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Report extends Blocks_Front_Abstract
{
    public $_totalitem;
    protected $_currentPage;
    protected $_select;
    protected $_offset;
    protected $_itemPerPage = 20;
    
    protected $_firstPage = 1;
    protected $_lastPage;
    
    public function getOffset()
    {
        $this->_offset  = (int) (($this->getCurrentPage() - 1) * $this->getPerPage());
        if( $this->_offset < 0) {
             $this->_offset = 0;
        }
        return  $this->_offset;
    }
    
    public function getPerPage()
    {
        return $this->_itemPerPage;
    }
    
    public function getUsers()
    {
        return App::registry('users');
    }
    
    public function getCurrentPage()
    {
        $currentpage = $this->getRequest()->query('page');
        if(!$currentpage || $currentpage < 1) {
            return $this->_firstPage;
        }
        if($currentpage > $this->getLastPage()) {
            $currentpage = $this->getLastPage();
        }

        return $currentpage;
    }
    
    public function getLastPage()
    {
        $this->_lastPage = ceil($this->getTotalItem()/$this->getPerPage());
        return $this->_lastPage;
    }
    
    public function getReports()
    {
        if(!$this->getUsers()->getId()) {
            return array();
        }
        $select = DB::select('report_data','report_date','appointment_id','report_id','report_access','reported_id','patient_id',array('SD_first_name.value','patient_name'),array(DB::expr('( case when patient_id = '.$this->getUsers()->getId().' and report_access = 0 then 1 else 0 end )'),'access'))->from(array(App::model('core/report')->getTableName(),'udc'));
        if($this->getUsers()->isDoctor()){ 
            $select->where_open()->where('reported_id','=',$this->getUsers()->getId())						
						->or_where('patient_id','=',$this->getUsers()->getId())->where_close();						
        } else {
            $select->where('patient_id','=',$this->getUsers()->getId());
        }
        
        $select->join(array(App::model('user')->getTableName(),'u'),'left')
                    ->on('udc.patient_id','=','u.user_id') 
                    ->join(array(App::model('user/attribute_static')->getTableName(),'SD_first_name'),'left')
                    ->on('SD_first_name.user_id','=','u.user_id') 
                    ->on('SD_first_name.attribute_id','=',DB::expr('4'));
                   
        if($this->getRequest()->query('pt_name')) {
            //$select->where('SD_first_name.value','like','%'.$this->getRequest()->query('pt_name').'%');            
            $select->where('report_data','like','%'.$this->getRequest()->query('pt_name').'%');            
        }
        $select = DB::select('*')->from(array(DB::expr('('.$select.')'),'tab'));
       /* if($this->getUsers()->isDoctor()){
			$select->where('tab.access','=',0);
		}else{
			$select->where('tab.report_access','=',1);
		}*/
        $select->order_by('report_date','desc');
        $this->_select = $select;
        $this->getTotalItem();
        $this->_select->offset($this->getOffset())->limit($this->getPerPage());
		//print_r($this->_select->__toString());
        $result = $this->_select->execute()->as_array();
        $data = array();
        foreach($result as $r) {
            $data[] = App::model('core/report',false)->setData($r);
        }
        return $data;
                    
    }
    
    public function getTotalItem()
    {
        if(!$this->_totalItem) {
            $pagination_query = clone $this->_select;         
            $this->_totalItem = DB::select(DB::expr('COUNT(\'*\') AS mycount'))->from(array(DB::expr('('.$pagination_query.')'),'t'))->execute()->get('mycount');
        }
        return $this->_totalItem;
    }
}
