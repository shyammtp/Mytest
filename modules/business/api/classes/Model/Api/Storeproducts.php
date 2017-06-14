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
class Model_Api_Storeproducts extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/products/price', false);
		
	}
	
	public function getCompanyAssociationPids($place_id)
    { 
        $model = App::model('company/association')->getCompanyAssociationByPlace($place_id);
        if($model->getId() && $model->getProductIds()) {
            return explode(',',$model->getProductIds());
        }        
        return array();
    }
	
	public function getQueryData()
	{	
		$q  = false;
        if(isset($this->_params['term'])) {
            $q = $this->_params['term'];
        }	
        $language = 1;
         if(isset($this->_params['language'])) {
            $language = $this->_params['language'];
		 }	
		 $user=App::model('user')->load($this->_params['user_token'],'user_token');
		 $isowner=$user->checkOwner($user->getId(),false);
		 if($isowner == 0){
			$role  = App::model('core/role')->setCustomer($user)->checkOnAdminRolesApi(Arr::get($this->_params,'place'))->getCustomerRoles();
			$placeID = Arr::get($this->_params,'place');
			$roleIDS = Arr::get($role,$placeID,array());
			$select = DB::select()->from(array(App::model('core/role_users')->getTableName(),'main_table'))
									->where('role_id','=',App::helper('db')->getInAlternate($roleIDS))
									->where('user_id','=',$user->getId())
									->execute();
			$product_ids = array();
			foreach($select as $sel){
				if($sel['product_ids']){
					$product_ids[] = $sel['product_ids'];
				}
			}
			if(count($product_ids)<=0){
				$product_ids =array(-5);
			}
			$product_ids = implode(',',$product_ids);
			$product_ids = array_filter(explode(',',$product_ids));
		}

		$languageId = $language;		
		$subsql = '(case when (select count(*) as totalcount from '.App::model('core/productcategory/info')->getTableName().' as info where info.language_id = '.$languageId.' and info.category_id = cat.category_id) > 0 THEN '.$languageId.' ELSE 1 END)';		 	
		$visibility = App::model('product/visibility');
		$casesql  = 'Case';
		foreach($visibility->toOptionArray() as $id => $v) {
			$casesql .= ' when visibility = '.$id.' then \''.$v.'\' ';
		}
		$casesql .= 'end';
		
		$selectsql1 = '(select array_to_string(array_agg(category_id),\',\') as catids from category_product where product_id = main_table.product_id)';
        $db = App::model('product')->selectAttributes('*') 
				->filter('has_parent',array('>=',Model_Product::PARENT_ID))
				//->filter('has_parent',array('<=',0))
				->filter('type_id',array('=',Model_Product::PRODUCT_TYPE))
                ->filter('status',array('=',1))
				->filter('deleted',array('=',false));
		if($q) {		
			$db->filter('product_name', array('ilike',$q.'%'));
		}
		$category= DB::select(array(DB::Expr("array_to_string(array_agg(catinfo.category_name),',')"),'category_names'))->from(array(App::model('core/category/product')->getTableName(),'cat'))
					->join(array(App::model('core/productcategory/info')->getTableName(),'catinfo'),'left')
					->on('cat.category_id','=','catinfo.category_id')
					->on('catinfo.language_id','=',DB::expr($subsql))
					->where('cat.product_id','=',DB::expr('main_table.product_id'));
					
		$db->getSelect()->select(array(DB::Expr('('.$category.')'),'category_names'),'pp.price','pp.special_price','pp.special_price_fromdate','pp.special_price_todate','pp.max_quantity','pp.in_stock','pp.availability','main_table.reference');  
		$db->getSelect()->join(array(App::model('product/price')->getTableName(),'pp'),'left')
					->on('main_table.product_id','=','pp.product_id')
					->on('pp.place_id','=',DB::expr($this->_params['place']));
					
		if($isowner == 0){
			if(!empty($product_ids)){
				//$db->getSelect()->where('pp.product_id','IN',$product_ids);
				$db->getSelect()->where('main_table.product_id','IN',$product_ids);
			}
		}			
					
		if(isset($this->_params['id'])) {
			$db->getSelect()->where('main_table.product_id','=',$this->_params['id']);
		}
		if(isset($this->_params['in_stock'])) {
			$db->getSelect()->where('pp.in_stock','=',$this->_params['in_stock']);
		}		
		$masscheckedvalues=$this->getCompanyAssociationPids($this->_params['place']);
		if(!empty($masscheckedvalues)) {
			$db->getSelect()->where('main_table.product_id','=',App::helper('db')->getInAlternate($masscheckedvalues));
		}else {
			$db->getSelect()->where('main_table.product_id','in',array(-1));
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
		
		$storeproducts = $this->getIdValid($id);
		$this->_prepareList(); 
        $resultant = $this->as_array();
		if($storeproducts['product_id']) {					
			$this->_totalItems = 1;							
		}
		$language = 1;
        if(isset($this->_params['language'])) {
            $language = $this->_params['language'];
		}
		
		if(!empty($resultant)) {
			$resultPcollection = array();
			$scol = Arr::pluck($resultant,'product_id');
			$ps = App::model('product',false)->setLanguage($language)->setConditionalLanguage(true)->selectAttributes('*');
			$ps->filter('product_id',array('=',App::helper('db')->getInAlternate($scol)));
			$result = $ps->loadCollection();
			foreach($result as $item) {
				$resultPcollection[$item->getId()] = $item;  
			}
			foreach($resultant as $key => $item) {
				$product = Arr::get($resultPcollection,$item['product_id']);
				$product_image=$product->getProductThumbnail();		
				$attrset = $product->getAttributeSet();
				$attr = '';
				if(count($attrset)) {
					$attr = "(";
					$str = array();
					foreach($attrset as $atrid => $valid) {
						$str[]= $product->getAttributeGroupsText($atrid).":".$product->getAttributeValuesText($valid);
					}
					$attr .= implode(", ",$str);
					$attr .= ")";						
				}
				$resultant[$key]['formatted_price'] = App::helper('price')->setAsArray(true)->formatPrice($item['price'],Arr::get($params,'place'),true);
				$resultant[$key]['formatted_special_price'] = App::helper('price')->setAsArray(true)->formatPrice($item['special_price'],Arr::get($params,'place'),true);
				$resultant[$key]['product_image'] = $product_image;
				$resultant[$key]['product_name'] = $product->getProductName().' '.$attr;
				//$resultant[$key]['product_name'] = $resultant[$key]['product_name'].' '.$attr;
				
			}		
		}		
		if(isset($params['fetch'])) { 			
            return $resultant;
        }        
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	public function getIdValid($pid) {
		return $select = DB::select('*')->from(array($this->_model->getTableName(),'main_table'))					
					->where('main_table.product_id','=',$pid)
					->where('main_table.place_id','=',$this->_params['place'])
					->execute()->current();
	}
	public function create($params)
	{
		
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place',
			));
		}
		if(!isset($params['product'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Product'),
				'field' => 'product',
			));
		}
		$product = App::model('product',false)->load($params['product'],'reference');
		if(!$product->getId()) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Invalid Product'),
				'field' => 'product',
			));
		}
		if($product->isService()) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Invalid Product'),
				'field' => 'product',
			));
		}
		
		$data = array();
		$pprice = clone $this->_model;
		try{						
			$data = $this->_initData($params);		
			$validate = $pprice->validate($data);											
			
			$select = $pprice->getStorePriceSetOld($product->getId(),$data['place']); 			
			$pprice->setOldData($select);
			$pprice->deleteStorePriceSet($product->getId(),$data['place']);
			if(isset($data['availability'])) {
				$pprice->setAvailability(implode(",",$data['availability']));
			}
			if(isset($data['specical_price_fromdate'])) {
				$pprice->setSpecialPriceFromdate(date("Y-m-d 00:00:01",strtotime($data['specical_price_fromdate'])));
			}
			if(isset($data['specical_price_todate'])) {
				if(!$data['specical_price_fromdate']) {
					$pprice->setSpecialPriceFromdate(date("Y-m-d 00:00:01",time()));
				}
				$pprice->setSpecialPriceTodate(date("Y-m-d 23:59:59",strtotime($data['specical_price_todate'])));
			}
			
			if(isset($data['special_price'])) {
				$pprice->setSpecialPrice((float)$data['special_price']);
			}
			if(isset($data['special_price'])) {
				$pprice->setMaxQuantity((int)$data['max_quantity']);
			}
			$pprice->setProductId($product->getId());								
			$pprice->setPlaceId($data['place']);
			if(isset($data['in_stock'])) {
				$pprice->setInStock($data['in_stock']);
			} 			
			$pprice->setPrice((float)$data['price']);
			$pprice->saveStorePrice();
			$data['success'] = true;
		}
		catch(Validation_Exception $ve) {  
				$errors = $ve->array->errors('apivalidation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
					print_r($ke); exit;
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			print_r($e); exit;
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	} 	
	
	protected function _initData($post = array())
	{		
		$data = $post;			
		if(isset($data['price']) && $data['price']) {
			$data['price'] = $data['price'];
		}
		/** if(isset($data['id']) && $data['id']) {
			$data['product_id'] = $data['id'];
		} **/
		if(isset($data['special_price']) && $data['special_price']){ 
			$data['special_price']=$data['special_price'];
		}		
		if(isset($data['special_price_fromdate']) && $data['special_price_fromdate']){ 
			$data['special_price_fromdate']=$data['special_price_fromdate'];
		}		
		if(isset($data['special_price_todate']) && $data['special_price_todate']){ 
			$data['special_price_todate'] = $data['special_price_todate'];
		}	
		if(isset($data['availability']) && $data['availability']){ 
			$data['availability'] = explode(',',$data['availability']);
		}	
		return $data;
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
		if(!isset($params['place'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Place'),
				'field' => 'place_id',
			));
		}
		$product = App::model('product',false)->load($params['id']);	
		if(!$product->getId()) {
			 throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid Product id'),
				'field' => 'id',
			));
        }
        $product_price=App::model('core/products_price')->getDeleteProductPriceDetails($params['id'],$params['place']);
		$data['success'] = true;
		return $data;
	}
	
	public function productAttribute() {		
        return $select = DB::select(array('attribute_id', 'attribute'))
					->from(array(App::model('entity/attributes_collection')->getTableName(),'attr'))
					->where('attr.attribute_code','=','product_name')->limit(1)->execute()->get('attribute');			
	}
	
	public function getProduct($pid)
	{
		return App::model('product',false)->load($pid);
	}
		
	
}	
