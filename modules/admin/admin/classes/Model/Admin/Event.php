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
class Model_Admin_Event extends Model_Abstract {

    public function loginactivity(Kohana_Core_Object $obj)
    {
        $user = $obj->getUser();
        $message = "Logged in as administrator in street directory"; 
        App::userlog($message,$user->getUserId());
    }

    public function logoutactivity(Kohana_Core_Object $obj)
    {
        $user = $obj->getSession()->getCustomer();
        $message = "Logged out";
        if($user->getUserId()) {
            App::userlog($message,$user->getUserId());
        }
    }
    
    public function related_place_delete(Kohana_Core_Object $obj)
    {
		try{
			
			$delete_role = DB::delete(App::model('core/role')->getTableName())
								->where('place_id','=',$obj->getPlace()->getPlaceId())
								->execute();
								
			$delete_user_website = DB::delete(App::model('core/customer/website')->getTableName())
								->where('place_id','=',$obj->getPlace()->getPlaceId())
								->execute();
								
			$delete_settings = DB::delete(App::model('configuration')->getTableName())
								->where('place_id','=',$obj->getPlace()->getPlaceId())
								->execute();						
		}
		catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}											
   
	}
    
    public function api_account_store_save(Kohana_Core_Object $obj)
    { 
        $api = $obj->getApi();
        $post = $obj->getPost();	 
        App::model('core/api_resources')->deleterow($api->getAccountId(),'account_id'); 
        if(isset($post['resource'])) {            
            foreach($post['resource'] as $key =>  $res) {
                foreach($res as $method => $resource) {
                $model = App::model('core/api_resources',false)->setResources($key)
                                    ->setMethod($method)
                                    ->setAccountId($api->getAccountId())
                                    ->save();
                }
            }
        }

        $role_users = App::model('core/role_users')->getRoleusers($api->getRoleId());
        App::model('core/api_store')->deleterow($api->getAccountId(),'api_account_id'); 
        foreach($role_users as $key1 => $users){ 
			 $model = App::model('core/api_store',false)->setApiAccountId($api->getAccountId())
								->setPlaceId($users->place_id)
								->setUserId($users->user_id)
								->save();
		}	
    }
    
            
    public function roleusers_save_after(Kohana_Core_Object $obj)
    { 
		$users = $obj->getRoleusers();
        $post = $obj->getPost();
        $api = App::model('core/api')->getApiaccounts($users->getRoleId());
        if(count($api)){
			foreach($api as $key => $val) { 
				$store_account = App::model('core/api_store',false)->deleterow($val->account_id,'api_account_id');
				$store_account->setApiAccountId($val->account_id)
								->setPlaceId($users->place_id)
								->setUserId($users->user_id)
								->save();
			}	
		}	
	}	
	
	public function advertsinfo(Kohana_Core_Object $obj)
	{
		$advert = $obj->getAdvert();
        $post = $obj->getPost();
		$title =  $post['title'];
		$description =  $post['description'];		
		$advertinfomodel = App::model('admin/advert_info',false);
		try {	
			$advertinfomodel->deleterow($advert->getAdvertsId(),'adverts_id');
			$languages = App::model('core/language')->getLanguages();
			foreach($languages as $language_id => $lang){
				if(isset($title[$language_id]) && $title[$language_id]!=""){
					$advertinfomodel->setAdvertsId($advert->getAdvertsId());
					$advertinfomodel->setLanguageId($language_id);
					$advertinfomodel->setTitle($title[$language_id]);
					$advertinfomodel->setDescription($description[$language_id]);						
					$advertinfomodel->save();
				}				
			}		
			
		} catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
	}
    
    public function product_categorysave(Kohana_Core_Object $obj)
    { 		
        $post = $obj->getPost();   
        $product = $obj->getProduct();
        try {
            App::model('core/category_product',false)->deleterow($product->getId(),'product_id');
            foreach($product->getCategoryId() as $catid) {
                $catproductModel = App::model('core/category_product',false)->setCategoryId($catid)
                                ->setProductId($product->getId())
                                ->setPosition(1);
                $catproductModel->save();
            }            
			
		} catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
		
    }
    
    public function product_brandsave(Kohana_Core_Object $obj)
    { 
        $post = $obj->getPost();   
        $product = $obj->getProduct();
        try {
            App::model('core/brand_product',false)->deleterow($product->getId(),'product_id');
            foreach($product->getBrandId() as $brandid) {
                $brandproductModel = App::model('core/brand_product',false)->setBrandId($brandid)
                                ->setProductId($product->getId())
                                ->setSortOrder(1);
                $brandproductModel->save();
            }            
			
		} catch(Kohana_Exception $ke) {
			
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		} 
    }
    
    public function product_tagsave(Kohana_Core_Object $obj)
	{
		$product = $obj->getProduct();
		$post = $obj->getPost();
        if($product->getHasParent() < 0) {
            return $this;
        } 
		try {
			$np = App::model('product',false)->load($product->getId());
			 
			if(isset($post['product_name'])) {
				$categoryids = $product->getCategoryIds();
				$cattags = array();
				foreach($categoryids as $id)
				{
					$cat = App::model('products/category')->getCacheCategory($id,1);
					if(isset($cat['category_name'])) {
						$cattags[] = $cat['category_name'];
					}
				} 
				$cattags = implode("|",$cattags);
				foreach($post['product_name'] as $langid => $value) {
					
					$tagModel = App::model('core/tags',false);
					if(empty($value))  {
						continue;
					}
					$tagid = $product->getTagSetId(); 
					if($tagid) {
						$tagModel->load($tagid);
					}
					if($ref = $product->getReference()) { 
						$value .= "|".$ref;
					}
					if($cattags) {
						$value .="|".$cattags;
					}
					$data = array('entity_type' => $product->getEntity()->getEntityTypeId(),
								'language_id' => $langid,
								'tag_name' => $value
					); 
					$tagModel->setEntityType($data['entity_type'])->setLanguageId($data['language_id'])->setTagName($value)->save();					
					if(!$tagid) {
						$productTag = App::model('product/tag',false)->setProductId($product->getId())->setTagId($tagModel->getTagId())->save();
					}					
					$np->setTagSetId($tagModel->getTagId());
				}
			}
            if(isset($post['product_tags']) && !empty($post['product_tags'])) {
				$tagModel = App::model('core/tags',false);				
				$tagid = $product->getTagId();
				 
				if($tagid) {
					$tagModel->load($tagid);
					
				} 
				$value = $post['product_tags']; 
				$data = array('entity_type' => $product->getEntity()->getEntityTypeId(),
							'language_id' => 1,
							'tag_name' => $value
				);
				$tagModel->addData($data)->save();
				if(!$tagid) {
					$productTag = App::model('product/tag',false)->setProductId($product->getId())->setTagId($tagModel->getTagId())->save();
				}
				 
				$np->setTagId($tagModel->getTagId());
				$tagModel->unsetData(); 
			}
			$np->save();			 
			
			
		} catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
	}
    
    public function producttagDelete(Kohana_Core_Object $obj)
	{
		$product = $obj->getProduct();
		try {
			$deleteTag = App::model('product/tag')->deleteTags($product->getId());
		} catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
	}
	
	public function product_attributesave(Kohana_Core_Object $obj)
	{
		$post = $obj->getPost();   
        $product = $obj->getProduct(); 
		if(!$product->getAttributeSet() || count($product->getAttributeSet())< 0) {
			return $this;
		} 
        try {
			App::model('product/attribute_combinations_set',false)->deleterow($product->getId(),'product_id');
			foreach($product->getAttributeSet() as $attribute_id  => $attribute_value_id) {
				$combinationset = App::model('product/attribute_combinations_set',false)
							->setProductId($product->getId())
							->setAttributeId($attribute_id)->setAttributeValueId($attribute_value_id)->save();
			} 
            $this->shiftImage($product, $post);
			$this->shiftRelated($product,$post); 
			$this->shiftSpecification($product,$post);
			
		} catch(Kohana_Exception $ke) { 
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) { 
			Log::Instance()->add(Log::ERROR, $e);
		} 
	}
	
	private function shiftImage(Model_Product $product, $post = array())
	{
		if(isset($post['product_group_images'])) {
			$pproduct = App::model("product",false)->load($product->getParentId());
			$images = $pproduct->getGallerysImages(json_decode($post['product_group_images'],true));
			
			foreach($images as $image) { 
				$uploaddir = 'uploads/products'.DIRECTORY_SEPARATOR.$product->getId();
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
				$file = basename($image['file']);
				$filename = $this->copyProductImage(DOCROOT.$image['file'],DOCROOT.$uploaddir.DIRECTORY_SEPARATOR.$file);                    
				if($filename) {
					$model = App::model('product/gallery',false)->setProductId($product->getId())
					->setFile($uploaddir.DIRECTORY_SEPARATOR.$file)
					->setFileType($image['file_type'])
					->setAddedOn(date("Y-m-d H:i:s"))
					->save();
				}
			}
		} 
	}
	
	private function shiftRelated(Model_Product $product, $post = array())
	{
		if(isset($post['product_group_relateds'])) {
			$model = App::model("product/related",false)->load($product->getId(),'product_id');
			$relatedids = $model->getRelationProductsIds();
			$checkedids = json_decode($post['product_group_relateds'],true); 
			if(count($checkedids)) {
				try {
					$model->setProductId($product->getId())->addProduct($checkedids)->saveRelated();
				} catch(Exception $e) {
					 
				}
			}
		} 
	}
	
	private function shiftSpecification(Model_Product $product, $post = array())
	{
		$specificationmodel = App::model('product/specification_group'); 
		$specificationmodel->deleterow($product->getId(),'product_id');
		$specificationset = $specificationmodel->getSpecificationset($product->getParentId());
		$data = array();
		$data['specification'] = $specificationset;
		$newspecificationmdoel =  App::model('product/specification_group',false); 
		if(isset($data['specification']) && count($data['specification'])){
			foreach($data['specification'] as $key => $groups){
				if($data['specification'][$key]['value'][1]) {
					$specificationmodel->setProductId($product->getId())->setGroupvalues($data['specification'][$key]['value']);
					$specificationmodel->saveGroup(); 
					$specificationmodel->setGroupId($specificationmodel->getId());
					if( isset($data['specification'][$key]['values']) && count($data['specification'][$key]['values'])){
						$specification = App::model('product/specification',false);
						foreach($data['specification'][$key]['values'] as $keys => $specifications){
							$specification->setGroupId($specificationmodel->getId())->setSpecificationname($specifications['name'])->setSpecificationvalue($specifications['value']);
							$specification->saveSpecification();
							$specification->setSpecificationId($specification->getId()); 
							$specification->unsetData();
						}
					}	 
					$specificationmodel->unsetData();
				} 
			}
		}  
	}
    
    public function product_subproductupdate(Kohana_Core_Object $obj)
	{
		$post = $obj->getPost();   
        $product = $obj->getProduct(); 
        if($product->getHasParent() >= 0) {
            return $this;
        } 
        try {  
            if(isset($post['productupdate']) && !empty($post['productupdate'])) {
                foreach($post['productupdate'] as $pid => $fields)
                {
                    $subproduct = App::model('product',false)->load($pid);
                    $data = array();
					$set = array();
                    foreach($fields as $field => $s) {
                        if($product->hasData($field) && isset($post[$field])) {
                            $data[$field] = $post[$field];
                            $subproduct->setData($field,$post[$field]);
                        }
						if($field =='images') {
							$gallery = App::model('product/gallery')->getGalleryImages($product->getId());
							$images = array();
							foreach($gallery as $gal) {
								$images[] = $gal['file'];
							}
							App::model('product/gallery')->deleterow($subproduct->getId(),'product_id');
							$set['product_group_images'] = json_encode($images);
							$this->shiftImage($subproduct, $set);
						}
						if($field =='related') {
							$related = App::model('product/related')->load($product->getId(),'product_id'); 
							$set['product_group_relateds'] = json_encode($related->getRelationProductsIds());
							$this->shiftRelated($subproduct, $set);
						}
						if($field == 'specification') {
							$this->shiftSpecification($subproduct);
						}
                    } 
                    $subproduct->saveProduct(); 
                }
            } 
			
		} catch(Kohana_Exception $ke) {
			
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			
			Log::Instance()->add(Log::ERROR, $e);
		} 
	}
     
    
    protected function copyProductImage($filepath,$dir)
    {
        try {            
            return copy($filepath,$dir) ;
            
        }catch(Kohana_Exception $ke) { 
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
        return false;
    }
    
    public function subjectsave(Kohana_Core_Object $obj)
	{
		$subject = $obj->getSubject();
        $post = $obj->getPost();
		$subjecttitle =  $post['subject'];		
		$subjectinfomodel = App::model('admin/email_subject/info',false);
		$subjectinfomodel->deleterow($subject->getData('id'),'id');
		try {	
			
			$languages = App::model('core/language')->getLanguages();
			foreach($languages as $language_id => $lang){
				if(isset($subjecttitle[$language_id])  && $subjecttitle[$language_id]!=""){					
					$subjectinfomodel->setId($subject->getData('id'));
					$subjectinfomodel->setLanguageId($language_id);
					$subjectinfomodel->setSubject($subjecttitle[$language_id]);											
					$subjectinfomodel->save();
					$subjectinfomodel->unSetData();
				}				
			}		
			
		} catch(Kohana_Exception $ke) {
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Log::Instance()->add(Log::ERROR, $e);
		}
	}
	
	public function api_key_save(Kohana_Core_Object $obj)
	{
		$config = $obj->getConfig();
		if($config->getName()=='API_KEY'){
			 $webapimodel = App::model('core/customer_website')->load(1);
			 $webapimodel->setApiKey($config->getValue());
			 $webapimodel->setForAdmin(true);
			 $webapimodel->save();
		}
	}
	
	public function citylabelinfo(Kohana_Core_Object $obj)
	{
		$city = $obj->getCity();
        $post = $obj->getPost();
		$label =  $post['name'];		
		
		if(isset($post['name'])) {			
			$cityinfomodel = App::model('admin/city/info',false);
			$cityinfomodel->deleterow($city->getCityLabelId(),'city_label_id');
			try {				
				$languages = App::model('core/language')->getLanguages();
				foreach($languages as $language_id => $lang){
					if(isset($label[$language_id]) && $label[$language_id]!=""){						
						$cityinfomodel = App::model('admin/city/info',false);
						$cityinfomodel->setCityLabelId($city->getCityLabelId());
						$cityinfomodel->setLanguageId($language_id);
						$cityinfomodel->setName($label[$language_id]);														
						$cityinfomodel->save();						
					}				
				}						
			} catch(Kohana_Exception $ke) {
				Log::Instance()->add(Log::ERROR, $ke);
			}
		}
	}
	
	
	public function countrysaveafter(Kohana_Core_Object $obj)
	{
		$countrymodel = $obj->getCountry();
		$post = $obj->getPost();
		$countryname = Arr::get($post,'country_name');  
		$language = App::model('core/language')->getLanguages();
		$infomodel = App::model('core/country_info',false);
		$infomodel->deleterow($countrymodel->getId(),'country_id');
		foreach($language as $langid => $la) {
			if(isset($countryname[$langid]) && $countryname[$langid] != ''){
				$infomodel->setCountryId($countrymodel->getId())
							->setLanguageId($langid);
				if(isset($countryname[$langid])){
					$infomodel->setCountryName($countryname[$langid]);
				}
				$infomodel->save();
				$infomodel->unsetData();
			}
		}
	}
	
	public function citysaveafter(Kohana_Core_Object $obj)
	{
		$citymodel = $obj->getCity();
		$post = $obj->getPost();
		$cityname = Arr::get($post,'city_name'); 
		$language = App::model('core/language')->getLanguages();
		$infomodel = App::model('core/city_info',false);
		$infomodel->deleterow($citymodel->getId(),'city_id');
		foreach($language as $langid => $la) {
			if(isset($cityname[$langid]) && $cityname[$langid] != ''){
				$infomodel->setCityId($citymodel->getId())
							->setLanguageId($langid);
				if(isset($cityname[$langid])){
					$infomodel->setCityName($cityname[$langid]);
				}
				$infomodel->save();
				$infomodel->unsetData();
			}
		}
	}
	
	public function areasaveafter(Kohana_Core_Object $obj)
	{
		
		$areamodel = $obj->getArea();
		$post = $obj->getPost();
		$areaname = Arr::get($post,'area_name');  
		$language = App::model('core/language')->getLanguages();
		$infomodel = App::model('core/area_info',false);
		$infomodel->deleterow($areamodel->getId(),'area_id');
		foreach($language as $langid => $la) {
			if(isset($areaname[$langid]) && $areaname[$langid] != ''){
				$infomodel->setAreaId($areamodel->getId())
							->setLanguageId($langid);
				if(isset($areaname[$langid])){
					$infomodel->setAreaName($areaname[$langid]);
				}
				$infomodel->save();
				$infomodel->unsetData();
			}
		}
	}
	
	public function departmentsaveafter(Kohana_Core_Object $obj)
	{		
		$deptmodel = $obj->getDepartment();
		$post = $obj->getPost();
		$deptname = Arr::get($post,'department_name'); 
		$desc = Arr::get($post,'description');
		$language = App::model('core/language')->getLanguages();
		$infomodel = App::model('core/department_info',false);
		$infomodel->deleterow($deptmodel->getId(),'department_id');
		foreach($language as $langid => $la) {
			if((isset($deptname[$langid]) && $deptname[$langid] != '') ||
			   (isset($desc[$langid]) && $desc[$langid] != '')
			   ){
				$infomodel->setDepartmentId($deptmodel->getId())
							->setLanguageId($langid);
				if(isset($deptname[$langid])){
					$infomodel->setDepartmentName($deptname[$langid]);
				}
				if(isset($desc[$langid])){
					$infomodel->setDescription($desc[$langid]);
				}
				$infomodel->save();
				$infomodel->unsetData();
			}
		}
		
		// Users
		try {
			$select = DB::select('de.entity_id','de.entity_type_id')->from(array(App::model('core/department_entity')->getTableName(),'de')) 
								->where('de.department_id','=',$deptmodel->getId())  
								->execute()->as_array(); 
			foreach($select as $s) {
				 
				if(Arr::get($s,'entity_type_id') == Model_User::ENTITY_TYPE_ID) {
					$userid = Arr::get($s,'entity_id');
					$user = App::model('user',false)->loadByAllLanguages($userid);
					$tags = array();
					$nams = array(); 
					foreach($user->getFirstName() as $names) {
						$nams[] = $names;
					}
					$tags[] = implode(", ",$nams);
					$tags[] = $user->getPrimaryEmailAddress();
					$departments = $user->getDepartments();
					$deps = array();
					foreach($departments as $d)
					{
						$depar = App::model('core/department',false)->loadAllLanguages($d->getDepartmentId());
						$dpna = array();
						$deprtmentname = $depar->getDepartmentName();
						if(!empty($deprtmentname)) {
							foreach($depar->getDepartmentName() as $langid => $name) {
								if(trim($name)) {
									$dpna[] = $name;
								}
							} 
							$deps[] = implode(", ",$dpna);
						}
					}
					if(count($deps)) {
						$tags[] = implode(", ",$deps);
					}
					$insurance = $user->getInsurance();
					$ins = array();
					foreach($insurance as $d)
					{
						$ins[] = $d->getInsuranceName();
					}
					if(count($ins)) {
						$tags[] = implode(", ",$ins);
					} 
					$tagmodel = App::model('core/tags',false);
					try {
						if($tagid = $tagmodel->checkTagExists($user->getId(),Model_User::ENTITY_TYPE_ID)) {
							$tagmodel->load($tagid);
						}
						$tagmodel->setEntityId($user->getId())->setEntityTypeId(Model_User::ENTITY_TYPE_ID)
								->setTagName(implode("|",$tags));  
						$tagmodel->save();
					} catch(Kohana_Exception $ke) {
						Log::Instance()->add(Log::ERROR, $ke);
					} catch(Exception $e) {
						Log::Instance()->add(Log::ERROR, $e);
					}
				} 
				if(Arr::get($s,'entity_type_id') == Model_Clinic::ENTITY_TYPE_ID) {
					 
					$clinicid = Arr::get($s,'entity_id');
					$clinic = App::model('clinic',false)->loadByAllLanguages($clinicid);
					$tags = array();
					$nams = array(); 
					foreach($clinic->getClinicName() as $names) {
						$nams[] = $names;
					}
					$tags[] = implode(", ",$nams); 
					$departments = $clinic->getDepartments();
					$deps = array();
					foreach($departments as $d)
					{
						$depar = App::model('core/department',false)->loadAllLanguages($d->getDepartmentId());
						$dpna = array();
						$deprtmentname = $depar->getDepartmentName();
						if(!empty($deprtmentname)) {
							foreach($depar->getDepartmentName() as $langid => $name) {
								if(trim($name)) {
									$dpna[] = $name;
								}
							} 
							$deps[] = implode(", ",$dpna);
						}
					}
					if(count($deps)) {
						$tags[] = implode(", ",$deps);
					}
					$insurance = $clinic->getInsurance();
					$ins = array();
					foreach($insurance as $d)
					{
						$ins[] = $d->getInsuranceName();
					}
					if(count($ins)) {
						$tags[] = implode(", ",$ins);
					}
					if(!is_array($clinic->getFacilities()) && $clinic->getFacilities()) { 
						$tags[] = (string)$clinic->getFacilities();
					}
					if(!is_array($clinic->getServices()) && $clinic->getServices()) {
						$tags[] = (string)$clinic->getServices();
					}
					if(!is_array($clinic->getTags()) && $clinic->getTags()) {
						$tags[] = (string)$clinic->getTags();
					}
					
					try {
						$tagmodel = App::model('core/tags',false);
						if($tagid = $tagmodel->checkTagExists($clinic->getId(),Model_Clinic::ENTITY_TYPE_ID)) {
							$tagmodel->load($tagid);
						}
						$tagmodel->setEntityId($clinic->getId())->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
								->setTagName(implode("|",$tags))->save();
					} catch(Kohana_Exception $ke) { 
						Log::Instance()->add(Log::ERROR, $ke);
					} catch(Exception $e) { 
						Log::Instance()->add(Log::ERROR, $e);
					} 	
				}
			} 
		} catch(Exception $e) { 
			Log::Instance()->add(Log::ERROR, $e);
		} 
	}
	
}	
