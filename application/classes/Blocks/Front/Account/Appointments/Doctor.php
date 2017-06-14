<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Account_Appointments_Doctor extends Blocks_Front_Abstract
{
	private $_rcollection;
	private $_totalItem = 0;
	private $_firstPage = 1;
	private $_lastPage;
	private $_offset;
	public function getUsers()
	{
		return App::registry('users');
	}
	
	
	public function getReceivedAppointments()
	{
		$select = DB::select("*")->from(App::model('core/appointments')->getTableName())
						->where('doctor_id','=',$this->getUsers()->getId());
		switch($this->getRequest()->query('rtype')) {
			case "tomorrow":
				$select->where('appt_time','>=',date("Y-m-d 00:00:01",strtotime('+1 day')))
				->where('appt_time','<=',date("Y-m-d 23:59:59",strtotime('+1 day')));
				break;
			case "yesterday":
				$select->where('appt_time','>=',date("Y-m-d 00:00:01",strtotime('-1 day')))
				->where('appt_time','<=',date("Y-m-d 23:59:59",strtotime('-1 day')));
				break;
			case "date":
					$date = Arr::get($this->getRequest()->query(),'dt',date("Y-m-d"));
					$date = date("Y-m-d",strtotime($date));
					if($date) {
						$select->where('appt_time','>=',$date." 00:00:01")
							->where('appt_time','<=',$date." 23:59:59");
					}
				break;
			case "today":
			default:
				$select->where('appt_time','>=',date("Y-m-d 00:00:01",time()))
				->where('appt_time','<=',date("Y-m-d 23:59:59",time()));	
				break;
		}
		$this->_rcollection = $select;
		$this->_getTotalItem();
		$select->order_by('appointment_id','desc')->limit($this->getPerPage())
				->offset($this->getOffset()); 	
		$result = $select->execute()->as_array();
		$data = array();
		foreach($result as $r) {
			$data[] = App::model('core/appointments',false)->setData($r);
		}
		return $data;
	}
	
	public function getTotal()
	{
		return $this->_totalItem;
	}
	
	public function getPerPage()
	{
		return Arr::get($this->getRequest()->query(),'limit',10);
	}
	
	public function getCurrentPage()
    {
        $currentpage = Arr::get($this->getRequest()->query(),'page',1);
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
        $this->_lastPage = ceil($this->getTotal()/$this->getPerPage());
        return $this->_lastPage;
    }
	
	public function _getTotalItem()
    { 
        if(!$this->_totalItem) { 
			$pagination_query = clone $this->_rcollection;
            $q =  $pagination_query->resetSelect()->resetSelect('order')->resetSelect('limit')->resetSelect('offset')->select(DB::expr('COUNT(*) AS mycount'))->execute()->current(); 
			$this->_totalItem = Arr::get($q,'mycount',0); 
        }
        return $this->_totalItem;
        
    }
	
	public function getPaging()
	{
		$block = $this->getRootBlock()->createBlock('Front/Paging','receivedpagination');	 
		$block->setCollection($this->_rcollection)
			->setTotalItem($this->getTotal())
			->setPerPage($this->getPerPage());
		return $block->toHtml();
	}
	
	private function getOffset()
    { 
        $this->_offset  = (int) (($this->getCurrentPage() - 1) * $this->getPerPage());
        if( $this->_offset < 0) {
             $this->_offset = 0;
        }
        return  $this->_offset;
    }

}
