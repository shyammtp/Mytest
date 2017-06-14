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
class Model_Api_Delivery extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('core/delivery');
	}
	
	public function getQueryData()
	{					
		$select = DB::select('de.charge','de.delivery_id','p.product_id')
					->from(array(App::model('core/delivery')->getTableName(),'de'))
					->join(array(App::model('product')->getTableName(),'p'))
					->on('de.product_id','=','p.product_id')
					->where('de.place_id','=',$this->_params['place']);
		if(isset($this->_params['id'])) {
			$select->where('de.delivery_id','=',$this->_params['id']);
		}
		return $select;				
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
		$delivery = $this->_model->load($id);
		
		if($delivery->getDeliveryId()) {			
			$this->_prepareList();		
			$resultant = $this->as_array();									
		} else {			
			$this->_prepareList();		
			$resultant = $this->as_array();
		}
		if(!empty($resultant)) {
			foreach($resultant as $key => $item) {
				$product = $this->getProduct($item['product_id']);			
				$attrset = $this->getProduct($item['product_id'])->getAttributeSet();
				$attr = '';
				foreach($attrset as $atrid => $valid) {
						$attr .= $product->getAttributeGroupsText($atrid)." ".$product->getAttributeValuesText($valid);
				}		
				$resultant[$key]['product_name'] = $product->getProductName().' '.$attr;
			}	
		}
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	public function create($params)
	{
		$data = array();
		$deliverymodel = clone $this->_model;
		try{			
			$data = $this->_initData($params);	
							
			$validate = $deliverymodel->validate($data);											
			foreach($data['products'] as $product) {		
				$deliverymodel = App::model('core/delivery', false);	
				if(isset($data['delivery_id'])) {
					$deliverymodel->setDeliveryId((int)$data['delivery_id']);
				}														
				$deliverymodel->setData($data);				
				$deliverymodel->setProductId($product);					
				$deliverymodel->setPlaceId($data['place']);				
				if(isset($data['circle_geometry_data'])) {
					if($data['circle_geometry_data'] != '') {
						$circle = explode(',',$data['circle_geometry_data']);	
						$deliverymodel->setLongitude($circle[0]);
						$deliverymodel->setLatitude($circle[1]);
						$deliverymodel->setRadius($circle[2]);
					} 
				}
				if(isset($data['delivery_id'])) {
					$deliverymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
				}else {
					$deliverymodel->setCreatedDate(date("Y-m-d H:i:s",time()));
				}			
				$deliverymodel->setStatus(true);														
				$deliverymodel->saveDelivery($data);				
			}			
			$data['success'] = true;
		}
		catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('validation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
			
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	} 	
	
	protected function _initData($post = array())
	{		
		$data = $post;	
		if(isset($data['location']) && $data['location']) {
			$data['location'] = $data['location'];
		}
		if(isset($data['id']) && $data['id']) {
			$data['delivery_id'] = $data['id'];
		}
		if(isset($data['geometry_data']) && $data['geometry_data']){ 
			$data['geometry_data']=$data['geometry_data'];
		}		
		if(isset($data['circle_geometry_data']) && $data['circle_geometry_data']){ 
			$data['circle_geometry_data']=$data['circle_geometry_data'];
		}		
		if(isset($data['products']) && $data['products']){ 
			$data['products'] = explode(',',$data['products']);
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
		$delivery=$this->_model->load($params['id']);
		if(!$delivery->getDeliveryId()){
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
		$deliverymodel->deleteRow();
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
