<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Orders_List extends Blocks_Front_Abstract
{
	protected $_search;
	protected $_totalOrder = 0;
    public function __construct()
    {
        
    }
    
    public function totalOrders()
    { 
        $select = DB::select(array(DB::expr('count(order_id)'),'total'))->from(App::model('sales')->getTableName())
                    ->where('user_id','=',App::model('user/session')->getId());
					
        $totalorder = $select->execute()->get('total');
        return $totalorder;
    }
    
    public function totalWithConditionOrders()
    { 
        $select = DB::select(array(DB::expr('count(order_id)'),'total'))->from(App::model('sales')->getTableName())
                    ->where('user_id','=',App::model('user/session')->getId());
         switch(trim($this->getRequest()->query('_of'))) {
            default:
            case "months-6":
                    $select->where('created_date','BETWEEN',array(Date::formatted_time('-6 months'), Date::formatted_time()));
                break;
            case "last30":
                    $select->where('created_date','BETWEEN',array(Date::formatted_time('-30 days'), Date::formatted_time()));
                break;
            case "all":
                    
                break;
        }
        $totalorder = $select->execute()->get('total');
        return $totalorder;
    }
    
    public function getSearchData()
	{
		$keyword = trim($this->getRequest()->query('searchorder')); 
		 
		$model = DB::select('order_id')->from(array(App::model('sales')->getTableName(),'main_table'))
						->where('main_table.order_reference','ilike','%'.$keyword.'%')
						->limit(5)
						->order_by('main_table.updated_date','desc')
						->__toString();
		 
		$itemreference = DB::select('or.order_id')->from(array(App::model('sales/place_items')->getTableName(),'main_table'))
						->join(array(App::model('sales/place_orders')->getTableName(),'po'),'inner')
						->on('po.porder_id','=','main_table.porder_id')
						->join(array(App::model('sales')->getTableName(),'or'),'inner')
						->on('or.order_id','=','po.order_id')
						->join(array(App::model('sales/place_items_language')->getTableName(),'il'),'left')
						->on('main_table.item_id','=','il.item_id')
						->on('il.language_id','=',DB::expr(App::getCurrentLanguageId()))
						->where_open()
						->where('main_table.place_item_reference','ilike','%'.$keyword.'%')
						->or_where('po.porder_reference','ilike','%'.$keyword.'%')
						->or_where('il.item_name','ilike', '%'.$keyword.'%') 
						->or_where_open() 
						->where('il.place_name','ilike', '%'.$keyword.'%')
						->where('il.place_name','!=', 'null')
						->or_where_close() 
						->where_close()
						->order_by('main_table.updated_date','desc')
						->__toString();
		$select = DB::query(Database::SELECT,'select order_id from (('.$model.') UNION ALL ('.$itemreference.')) as ods group by order_id');
		return $select;
		 
	}
    
    
    public function loadOrders()
    { 
		$searcharray = $this->getSearchData();
        $select = DB::select('order_id')->from(array(App::model('sales')->getTableName(),'o'))
                    ->where('o.user_id','=',App::model('user/session')->getId());
                    
        switch($this->getRequest()->query('_of')) {
            default:
            case "months-6":
                    $select->where('o.created_date','BETWEEN',array(Date::formatted_time('-6 months'), Date::formatted_time()));
                break;
            case "last30":
                    $select->where('o.created_date','BETWEEN',array(Date::formatted_time('-30 days'), Date::formatted_time()));
                break; 
            case "all":
                    
                break;
        }
		
		$failurestate = DB::select(array(DB::expr('count(order_history_id)'),'total'))
						->from(App::model('sales/history')->getTableName())
						->where('order_id','=',DB::expr("o.order_id"))
						->where_open()
						->where('order_state_id','=',Model_Sales_State::PAYMENT_ERROR_STATE)
						->and_where('order_state_id','!=',Model_Sales_State::ORDER_PROCESSING)
						->where_close();
        $select->where(DB::expr('('.$failurestate.')'),'<=',0);  
		$select->where('o.order_id','=',DB::expr('ANY('.$searcharray.')')); 
		return $select; 
    }
    
    public function getOrders()
    {
		if(!$this->hasData('listorders')) { 
			$orderids = $this->loadOrders();
			$orders = array();
			$order = App::model('sales',false)->getResource();
			$order->getSelect()->where('main_table.order_id','=',DB::expr('ANY('.$orderids.')'));		
			$order->getSelect()->order_by('main_table.order_id','desc');
			$totalorder = clone $order->getSelect();
			$this->_totalOrder = DB::select(DB::expr('COUNT(\'*\') AS mycount'))->from(array(DB::expr('('.$totalorder.')'),'t'))->execute()->get('mycount');
			 
			$offset = 0;
			$limit = 10;
			if($page = $this->getRequest()->query('_page'))
			{
				$offset = (int) ($page - 1) * 10;            
			} 
			$order->getSelect()->limit($limit)->offset($offset);  
			$result = $order->loadCollection(); 
			$this->setData('listorders',$result->getValues());
		}
		return $this->getData('listorders');
    }
	
	protected function getTotalOrder()
	{
		return $this->_totalOrder;
	}
	
	
}
