<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Order extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/delivery');
	}
	
	public function getQueryData()
	{					
		$languageId =1;
		if(isset($this->_params['languge_id'])){
			$languageId = $this->_params['languge_id'];	
		}
		$filterval='';
		if(isset($this->_params['searchorder'])){
			$filterval = $this->_params['searchorder'];
		}
		$itemlanguageSQL= '(case when (select count(item_id) as totalcount from '.App::model('sales/place_items_language')->getTableName().' as info where info.language_id = '.$languageId.' and item_id = main_table.item_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		$seperateQuery = DB::select('main_table.porder_id')
				->from(array(App::model('sales/place_items')->getTableName(),'main_table'))
				->join(array(App::model('sales/place_items_language')->getTableName(),'il'),'left')
				->on('main_table.item_id','=','il.item_id')
				->on('il.language_id','=',DB::expr($itemlanguageSQL));
		if(!empty($filterval)) {
			$seperateQuery->where_open()
				->where('main_table.place_item_reference','ilike','%'.$filterval.'%')
				->or_where('il.item_name','ilike', '%'.$filterval.'%') 
				->or_where_open() 
				->where('il.place_name','ilike', '%'.$filterval.'%')
				->where('il.place_name','!=', 'null')
				->or_where_close() 
				->where_close();
		}  
		$results = $seperateQuery->execute(); 
		$porderids = array();
		foreach($results as $r) {
			$porderids[] = $r['porder_id'];
		}
		$language_sql= '(case when (select count(*) as totalcount from '.App::model('core/place/info')->getTableName().' as info where info.language_id = '.$languageId.' and place_id = pinfo.place_id) > 0 THEN '.$languageId.' ELSE 1 END)';
		$db = DB::select('main_table.porder_id','main_table.porder_reference','main_table.place_id','pinfo.place_name','main_table.created_date','or.order_reference')
				->from(array(App::model('sales/place/orders')->getTableName(),'main_table'))
				->join(array(App::model('sales')->getTableName(),'or'),'inner')
				->on('or.order_id','=','main_table.order_id')
				->join(array(App::model('core/place/info')->getTableName(),'pinfo'),'left')
				->on('main_table.place_id','=','pinfo.place_id')
				->on('pinfo.language_id','=',DB::expr($language_sql));

		$db->where('main_table.place_id','=',$this->_params['place_id']);
		if(!empty($filterval)) {
			$db->where_open()
				->where('main_table.porder_reference','ilike','%'.$filterval.'%')
				->or_where('or.order_reference','ilike', '%'.$filterval.'%');
			if(count($porderids)) {
				$db->or_where('main_table.porder_id','in',$porderids);
			}
			$db->where_close();
		}	
		return $db;				
	}
	
	public function get($params)
	{ 
		if(!isset($params['place_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place_id',
			));
		}	
		$this->_params = $params; 			 			
		$this->_prepareList();		
		$resultant = $this->as_array();
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	
	
}	
