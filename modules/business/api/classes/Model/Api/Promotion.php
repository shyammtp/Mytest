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
class Model_Api_Promotion extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/promotion');
	}
	
	public function getQueryData()
	{			
		$db = DB::select('de.offer_type','de.offer_value','de.offer_from_date','de.offer_to_date','de.created_date','de.offer_from_date','de.title','de.productid','de.promotion_id','de.promotion_product_id','de.delivery_charge')
					->from(array(App::model('core/promotion')->getTableName(),'de'))
					->where('de.place_id','=',$this->_params['place']);	
					
		if(isset($this->_params['title'])) {
			$db->where('de.title', 'ILIKE', '%'.$this->_params['title'].'%');	
		}
		if(isset($this->_params['offer_type']) && $this->_params['offer_type']!='') {
			$db->where('de.offer_type', '=', $this->_params['offer_type']);			
		}		
		if(isset($this->_params['offer_value'])) {
			$db->where('de.offer_value', '=', $this->_params['offer_value']);			
		}		
		if(isset($this->_params['offer_from_date']) && isset($this->_params['offer_to_date'])) {
			$db->where('de.offer_from_date', '>=', $this->_params['offer_from_date']);
			$db->where('de.offer_to_date', '<=', $this->_params['offer_to_date']);
		}
		return $db;				
	}
	
	public function get($params)
	{ 
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place',
			));
		}
		$id=(int)Request::current()->param('param');
		$this->_params = $params; 			 		
		$promotion = $this->_model->load($id);
		if($promotion->getPromotionId()) {			
			$this->_prepareList();		
			$resultant[] = $promotion->getData();	
			$this->_totalItems = 1;								
		} else {			
			$this->_prepareList();		
			$resultant = $this->as_array();
		}
		if(Arr::get($params,'language_id',Arr::get($params,'language'))) {
			$language = Arr::get($params,'language_id',Arr::get($params,'language'));	
		}else {
			$language = 1;
		}
		 $currency = App::model('core/currency')->getCurrencyById(App::getConfig('DEFAULT_CURRENCY',$params['place']));
		 if(!empty($resultant)) {
			foreach($resultant as $key => $item) {
				$names = array();
				$price = array();
				$arr = array();
				$productid = $item['productid'];
				$singleproductid = $item['promotion_product_id'];
				$productdata = $this->getProductdata($singleproductid,$language);
				$attributes1 = $productdata->getAttributeSet();
				$html1 = "";
				if(count($attributes1)){
					$html1 .= "(";
					$str1 = array();
					foreach($attributes1 as $atrid => $valid) {
						$str1[]= $productdata->getAttributeGroupsText($atrid).":".$productdata->getAttributeValuesText($valid);
					}
					$html1 .= implode(", ",$str1);
					$html1 .= ")";
				}
				$mainproductname=$productdata->getProductName().(($html1!="") ? "-".$html1  :""); 
				
				if(!empty($productid)){
					$proIDS = explode(',',$productid);
					$product = $this->getProduct($proIDS,$params['place'],$language);
					$pro = $product->loadCollection();
					foreach($pro as $m){						
							$attributes = $m->getAttributeSet();
							$html = "";
							if(count($attributes)){
								$html .= "(";
								$str = array();
								foreach($attributes as $atrid => $valid) {
									$str[]= $m->getAttributeGroupsText($atrid).":".$m->getAttributeValuesText($valid);
								}
								$html .= implode(", ",$str);
								$html .= ")";
							}
							$names[] = $m->getProductName().(($html!="") ? "-".$html  :""); 
							$price[] = $m->getSpecialPrice();
					}
				}elseif(!empty($singleproductid)){
					$arr[] =$singleproductid;
					$product = $this->getProduct($arr,$params['place'],$language);
					$pro = $product->loadCollection();
					foreach($pro as $m){
							$attributes = $m->getAttributeSet();
							$html = "";
							if(count($attributes)){
								$html .= "(";
								$str = array();
								foreach($attributes as $atrid => $valid) {
									$str[]= $m->getAttributeGroupsText($atrid).":".$m->getAttributeValuesText($valid);
								}
								$html .= implode(", ",$str);
								$html .= ")";
							}
							$names[] = $m->getProductName().(($html!="") ? "-".$html  :""); 
							$price[] = $m->getSpecialPrice();
					}
					
				}else{
					echo '--';
				}
				$resultant[$key]['delivery_charge_formated'] = App::helper('price')->setAsArray(true)->formatPrice($resultant[$key]['delivery_charge'],$params['place'],true);
				$resultant[$key]['offer_value_formated'] = App::helper('price')->setAsArray(true)->formatPrice($resultant[$key]['offer_value'],$params['place'],true);
				$resultant[$key]['currency'] = $currency->getData('currency_code');
				$resultant[$key]['currency_symbol_left'] = $currency->getData('currency_symbol_left');
				$resultant[$key]['currency_symbol_right'] = $currency->getData('currency_symbol_right');
				$resultant[$key]['total'] = array_sum($price);
				$resultant[$key]['product_price'] = implode(',',$price);
				//$resultant[$key]['product_name'] = implode(',',$names);
				$resultant[$key]['combo_product_name'] = implode(',',$names);
				$resultant[$key]['product_name'] = $mainproductname;
			}	
		} 
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	public function create($params)
	{
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place',
			));
		}
		if(isset($params['id']) && $params['id']!=''){
			$params['id']=$params['id'];
		}else {
			$params['id']='';
		}
		$data = array();
		$promotionmodel = clone $this->_model;
		$place=App::model('core/place')->load($params['place']);
		$placeid = $place->getData('parent_id');
        $childPlaces = App::model('core/place')->getChildIds($placeid); 
		$PromotionIDS = App::model('core/promotion',false)->getPromotionDetails($childPlaces);
		$CheckStoreSub = App::model('subscriptionplace',false)->load($placeid,'place_id');
		if(!$params['id']) {
			if($CheckStoreSub){
				$PromotionSubCount = $CheckStoreSub->getNoOfPromotionsSubscribe();
				if(count($PromotionIDS) >= $PromotionSubCount){
					throw HTTP_Exception::factory(401, array(
						'error' => __('Subscription for promotion limit is :productsub for your company . Contact admin for further.',array(':productsub'=>$PromotionSubCount)),
						'field' => 'promotion',
					));						
				}
			}
		}
		try{	
			$validate = $promotionmodel->Validate($params);
			if($params['offer_type'] == 1){	
					if($params['id']) {
						$promotionmodel->setPromotionId((int)$params['id']);
					}
					$promotionmodel->setOfferType($params['offer_type']);
					$promotionmodel->setOfferValue($params['offer_value_percentage']);
					$promotionmodel->setOfferFromDate($params['from_date']);
					$promotionmodel->setOfferToDate($params['to_date']);						
					$promotionmodel->setOfferApply($params['offer_apply']);						
					$promotionmodel->setPlaceId($params['place']);
					$promotionmodel->setTitle($params['title']);
					$promotionmodel->setDescription($params['description']);
					if(!$params['id']) {
						$promotionmodel->setPromotionProductId($params['products_lists']);
					}
					if($params['id']) {
						$promotionmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					}else{
						$promotionmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
					}					
					$promotionmodel->savepromotion();								
			}else if($params['offer_type'] == 2){
				
					if($params['id']) {
						$promotionmodel->setPromotionId((int)$params['id']);
					}	
					if($params['product_result_id']){
						$prod_res_id = array_unique(explode(',',$params['product_result_id']));
						$prod_res_id_sep = implode(',',$prod_res_id);
					}										
					$promotionmodel->setProductid($prod_res_id_sep);
					$promotionmodel->setOfferType($params['offer_type']);
					$promotionmodel->setOfferValue($params['offer_value']);
					if($params['quantity']){
						$promotionmodel->setQuantity($params['quantity']);
					}else{
						$promotionmodel->setQuantity(0);
					}
					$promotionmodel->setOfferFromDate($params['from_date']);
					$promotionmodel->setOfferToDate($params['to_date']);	
					$promotionmodel->setOfferApply(0);					
					$promotionmodel->setShippingType($params['shipping_type']);					
					$promotionmodel->setPlaceId($params['place']);
					$promotionmodel->setTitle($params['title']);
					if(!$params['id']) {
						$promotionmodel->setPromotionProductId($params['products_lists']);
					}
					$promotionmodel->setDeliveryCharge($params['delivery_charge']);
					$promotionmodel->setHandlingHours($params['handling_hours']);
					$promotionmodel->setDescription($params['description']);
					if($params['id']) {
						$promotionmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					}else {
						$promotionmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
					}			
					$promotionmodel->savepromotion();
			}
			$data['success'] = true;		
		}
		catch(Validation_Exception $ve) { 
			//print_r($ve); exit;
				$errors = $ve->array->errors('apivalidation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
			//print_r($ke); exit;
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			//print_r($e); exit;
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	} 	
	
	public function update($params)
	{		
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		$promotionmodel=$this->_model->load($params['id']);
		if(!$promotionmodel->getPromotionId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid id'),
				'field' => 'id',
			));
		}	
		return $this->create($params);
	}
	
	public function delete($params)
	{		
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		$deliverymodel = clone $this->_model;
		$deliverymodel->load($params['id']);
        $deliverymodel->deleterow();
		$data['success'] = true;
		return $data;
	}	
	
	
	
	public function getProduct($proIDS,$place,$language='')
	{  
		$product = App::model('product',false)->setConditionalLanguage(true)->setLanguage($language)->selectAttributes('product_name')
        ->filter('product_id',array('=', App::helper('db')->getInAlternate($proIDS)));
        $product->getSelect()->select('pp.price','pp.special_price','pp.special_price_fromdate','pp.special_price_todate','pp.max_quantity','pp.in_stock','pp.availability','main_table.reference');							   
		$product->getSelect()->join(array(App::model('product/price')->getTableName(),'pp'),'left')->on('main_table.product_id','=','pp.product_id')->where('pp.place_id','=',$place);                                                         
		return $product;
		
	}
	
	public function productAttribute() {		
        return $select = DB::select(array('attribute_id', 'attribute'))
					->from(array(App::model('entity/attributes_collection')->getTableName(),'attr'))
					->where('attr.attribute_code','=','product_name')->limit(1)->execute()->get('attribute');			
	}
	
	public function getProductdata($pid,$language='')
	{
		return App::model('product',false)->setConditionalLanguage(true)->setLanguage($language)->selectAttributes('product_name')->load($pid);
	}
}	
