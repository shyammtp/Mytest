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
class Model_Api_Storeservices extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('services/place', false);
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
			
		$db = App::model('product')->setLanguage($languageId)->setConditionalLanguage(true)->selectAttributes('*')
				->filter('has_parent',array('>',Model_Product::PARENT_ID))->filter('type_id',array('=',Model_Product::SERVICE_TYPE));
		if($q) {		
			$db->filter('product_name', array('ilike',$q.'%'));
		} 	
		$category= DB::select(array(DB::Expr("array_to_string(array_agg(catinfo.category_name),',')"),'category_names'))->from(array(App::model('core/category/product')->getTableName(),'cat'))
					->join(array(App::model('core/productcategory/info')->getTableName(),'catinfo'),'left')
					->on('cat.category_id','=','catinfo.category_id')
					->on('catinfo.language_id','=',DB::expr($subsql))
					->where('cat.product_id','=',DB::expr('main_table.product_id'));
		$db->getSelect()->select(array(DB::Expr('('.$category.')'),'category_names'),'sc.title','sc.price_from','sc.price_to','sc.people_id','sc.file')->join(array(App::model('services/place')->getTableName(),'sc'),'left')
					->on('main_table.product_id','=','sc.product_id')
					->on('sc.place_id','=',DB::expr($this->_params['place']));
		if($isowner == 0){
			if(!empty($product_ids)){
				//$db->getSelect()->where('pp.product_id','IN',$product_ids);
				$db->getSelect()->where('main_table.product_id','IN',$product_ids);
			}
		}
		if(isset($this->_params['id'])) {
			$db->getSelect()->where('main_table.product_id','=',$this->_params['id']);
		}
		if(isset($this->_params['review_status'])) {
			$db->getSelect()->where('main_table.review_status','=',$this->_params['review_status']);
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
		if(!empty($resultant)) { 
			foreach($resultant as $key => $item) {
				$product = $this->getProduct($item['product_id']);	
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
				if(Arr::get($item,'file')) {
					$filesset = json_decode($item['file']);
					$files = array();
					foreach($filesset as $file) {
						if($file && file_exists(DOCROOT.$file)) {
							$files[] = $file;
						}
					} 
					$resultant[$key]['file'] = $files; 
				}
				$resultant[$key]['formatted_price_from'] = App::helper('price')->setAsArray(true)->formatPrice($item['price_from'],Arr::get($params,'place'),true);
				$resultant[$key]['formatted_price_to'] = App::helper('price')->setAsArray(true)->formatPrice($item['price_to'],Arr::get($params,'place'),true);
				$resultant[$key]['product_image'] = $product_image;
				//$resultant[$key]['product_name'] = $product->getProductName().' '.$attr;
				$resultant[$key]['product_name'] = $resultant[$key]['product_name'].' '.$attr;
				
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
		if(!isset($params['service'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Service'),
				'field' => 'service',
			));
		}
		$product = App::model('product',false)->load($params['service'],'reference');
		if(!$product->getId()) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Invalid Services'),
				'field' => 'service',
			));
		}
		if($product->isProduct()) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Invalid Services'),
				'field' => 'service',
			));
		}
		
		$data = array();
		$pprice = clone $this->_model;
		try{						
			$data = $this->_initData($params);	
			$data = Arr::merge($params,$_FILES);
			$validate = $pprice->validateService($data);
			if(isset($data['service_id'])){
				$pprice->setServiceId($data['service_id']); 
			}											
			if(isset($data['price_from'])) {
				$pprice->setPriceFrom((float)$data['price_from']);
			}
			if(isset($data['price_to'])) {
				$pprice->setPriceTo((float)$data['price_to']);
			}
			$pprice->setProductId($product->getId());								
			$pprice->setPlaceId($data['place']);
			$pprice->setPeopleId((int)$data['people_id']);
			$pprice->setTitle($data['title']);
			$pprice->saveService();
			if(isset($data['documents']) && $data['documents']!=''){
				$this->document_update($data['documents'],$pprice->getId());
			}
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
	
	public function document_update($data,$price_id)
	{ 
			$json = array();
			$filename = NULL;
            if (isset($_FILES['documents']))
            {
				$uploaddir = 'uploads/products'.DIRECTORY_SEPARATOR.$price_id;
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
                $filename = $this->_save_image($_FILES['documents'],DOCROOT.$uploaddir);
                if ($filename) {
				$json['file'] = basename($filename);
				$image[]=$uploaddir.DIRECTORY_SEPARATOR.basename($filename);
				$service_image=App::model('services/place')->load($price_id);
				if($service_image->getFile()!=""){
					$old_data=json_decode($service_image->getFile(),TRUE);
					$image=array_merge($image,$old_data);
				}
				$model = $model = App::model('services/place',false)->setServiceId($price_id)
						->setFile(json_encode($image))
						->save();
				$json['success']='success';
				}
            }
        if (!$filename) {
            $json['error'] = 'There was a problem while uploading the image.
                Make sure it is uploaded and must be pdf/doc/xl/xls/docs/csv/txt file.';
        }
		return $json;
		
	}
	
	protected function _save_image($image, $dir)
    {
        /** if (! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
        {
            return FALSE;
        } **/
        $directory = $dir;
        if ($file = Upload::save($image, $image['name'], $directory)) {
            return $file;
        }
        return FALSE;
    }
	
	protected function _initData($post = array())
	{		
		$data = $post;				
		return $data;
	}
		
	public function productAttribute()
	{		
        return $select = DB::select(array('attribute_id', 'attribute'))
					->from(array(App::model('entity/attributes_collection')->getTableName(),'attr'))
					->where('attr.attribute_code','=','product_name')->limit(1)->execute()->get('attribute');			
	}
	
	public function getProduct($pid)
	{
		return App::model('product',false)->load($pid);
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
				'error' => __('Missing Place id'),
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
        $product_price=App::model('services/place')->getDeleteServiceDetails($params['id'],$params['place']);
		$data['success'] = true;
		return $data;
	}

	
}	
