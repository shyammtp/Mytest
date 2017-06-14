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
class Model_Api_Searchproducts extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('product/price');
	}
	
	public function getQueryData()
	{					
		$productsResult = array();
		$select = DB::select('p.product_id')->from(array($this->_model->getTableName(), 'p'))
					->where('place_id','=',$this->_params['place'])->execute()->as_array();	
								
		if(!empty($select)) {
			foreach($select as $product) {
				$product_id[] = $product['product_id'];
			}			
			$item= $product_id;			
			$this->model = App::model('product');
			if(!empty($product_id)) {
				$language = App::getCurrentLanguageId();
				$currentdate = Date::formatted_time(); 
				$subsql = "(select t1.product_id as pid,t1.place_id,t1.old_price,t1.price from  (select (case when (pps.special_price_fromdate <= '".$currentdate."' and pps.special_price_todate >= '".$currentdate."' and pps.special_price > 0) then pps.special_price else pps.price end) as price, pps.product_id,pps.price as old_price, pps.place_id from ".App::model('product/price')->getTableName()." pps where pps.in_stock > 0) t1 inner join (select min(price) price, product_id from (select (case when (special_price_fromdate <= '".$currentdate."' and special_price_todate >= '".$currentdate."' and special_price > 0) then special_price else price end) as price,  product_id, place_id from ".App::model('product/price')->getTableName()." where in_stock > 0) as myt group by product_id) t2 on t1.price = t2.price and t1.product_id = t2.product_id)";
		
				$result = $this->model->setConditionalLanguage(true)->selectAttributes('*')
								->filter('product_id',array('IN',$item))
								->filter('type_id', array('=','product'))
								->filter('product_name', array('ilike',$this->_params['search'].'%'));
								
				$result->getSelect()->select('*')->join(array(DB::expr($subsql),'pp'),'inner')->on('pp.pid','=', 'main_table.product_id');							
				$products = $result->loadCollection(); 
									
				foreach($products as $pr) {	
					$product = $this->getProduct($pr);
					$attrset = $this->getProduct($pr)->getAttributeSet();
					$html = ''; 
					foreach($attrset as $atrid => $valid) {
						$html  .= $product->getAttributeGroupsText($atrid).' '.$product->getAttributeValuesText($valid);
					}				
					$productsResult[] = array('product_id'=>$pr->getData('product_id'),'product_name'=>$pr->getData('product_name'),'attributes' => $html);						
				}											
			}
		}		
		return $productsResult;				
	}
	
	public function get($params)
	{ 
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place',
			));
		}
		if(!isset($params['search'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Search Key'),
				'field' => 'search',
			));
		}				
		$this->_params = $params; 			 		
		$resultant = $this->getQueryData();
		return array('details' => $resultant,'total_rows' => count($resultant));	 		 		
	}
	
	public function getProduct($pr)
	{		
		return App::model('product',false)->load($pr->getData('product_id'));
	}
	
}	
