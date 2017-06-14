<?php defined('SYSPATH') OR die('No direct script access.');
class Model_Requirements extends Model_Core_Requirements {
        
    public function __construct()
    {
        $this->_table = 'user_requirements';
        $this->_primaryKey = 'requirement_id';
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    }
    
    public function getCategoryList()
    {        
		$langId =1;
        $select = DB::select('main_table.category_id','info.category_name')->from(array(App::model('products/category')->getTableName(),'main_table'))
						->join(array(App::model('products/category/info')->getTableName(),'info'),'left')
						->on('main_table.category_id','=','info.category_id')
                        //->where('main_table.level','=',2)
                        ->where('info.language_id','=',$langId)
                        ->order_by('main_table.level','ASC')
                        ->execute()->as_array();  
        return $select;
    }
    
    public function getBrandList()
    {        
		$langId =1;
        $select = DB::select('main_table.brand_id','info.title')->from(array(App::model('products/brand')->getTableName(),'main_table'))
						->join(array(App::model('products/brand/info')->getTableName(),'info'),'left')
						->on('main_table.brand_id','=','info.brand_id')
                        ->where('main_table.level','IN',array(1,2))
                        ->where('info.language_id','=',$langId)
                        ->order_by('main_table.level','ASC')
                        ->execute()->as_array();  
        return $select;
    }
    
    public function getCategory($category)
    {        
		$langId =1;
        $select = DB::select('main_table.category_id','info.category_name')->from(array(App::model('products/category')->getTableName(),'main_table'))
						->join(array(App::model('products/category/info')->getTableName(),'info'),'left')
						->on('main_table.category_id','=','info.category_id')                        
                        ->where('info.language_id','=',$langId)
                        ->where('main_table.category_id','=',$category)                        
                        ->limit(1)
                        ->execute()->as_array();  
        return $select;
    }
    
    public function getBrand($brand)
    {        
		$langId =1;
        $select = DB::select('main_table.brand_id','info.title')->from(array(App::model('products/brand')->getTableName(),'main_table'))
						->join(array(App::model('products/brand/info')->getTableName(),'info'),'left')
						->on('main_table.brand_id','=','info.brand_id')                        
                        ->where('info.language_id','=',$langId)
                        ->where('main_table.brand_id','=',$brand)
                        ->execute()->as_array();  
        return $select;
    }
    
   public function saveRequirement() 
   {
	    $request = Request::current();  
        App::dispatchEvent('Requirement_Save_Before',array('post'=> $request->post(),'requirement' => $this));
        parent::save();
        App::dispatchEvent('Requirement_Save_After',array('post'=> $request->post(),'requirement' => $this));
        return $this;
   }
   
   public function save() 
   {
	   parent::save();
   }
   
   public function saveRequirementInfo($data = array()) 
   {
        App::dispatchEvent('Requirement_Save_Before',array('post'=> $data,'requirement' => $this));
        parent::save();
        App::dispatchEvent('Requirement_Save_After',array('post'=> $data,'requirement' => $this));
        return $this;
   }
   
   public function getCompany($categoryid) 
   {
	   
	   $placeid = array();
	   $results = array();   	   
	   $select = DB::select('main_table.company_id','main_table.place_category_id')
						->from(array(App::model('company')->getTableName(),'main_table'))
						->join(array(App::model('company/product')->getTableName(),'info'),'left')
						->on('main_table.company_id','=','info.company_id')
						->where(DB::expr('regexp_split_to_array(info.product_subcategory,\',\')::integer[]'),'@>',DB::expr("'{".$categoryid."}'::integer[] and info.product_subcategory !=''"))    			        
						->execute()->as_array();               		
		if(!empty($select)) {
			foreach($select as $key => $val) {				
				$placeResults[] = DB::select('main_table.place_id')
						->from(array('place_entity','main_table'))
						->where('main_table.place_category_id','=',$select[$key]['place_category_id'])
						->where('main_table.entity_primary_id','=',$select[$key]['company_id'])
						->execute()->as_array();
				
				if(!empty($placeResults)) {	
					if(array_key_exists(0,$placeResults[$key])) {	
						$results[] = $placeResults[$key][0];
					}
				}										
			}
		}			
        return $results;
   }
   
   public function getStore($categoryid) 
   {
	   
	   $placeid = array();
	   $results = array();  	   
	   $select = DB::select('main_table.store_id','main_table.place_category_id')
						->from(array(App::model('store')->getTableName(),'main_table'))
						->join(array(App::model('store/product')->getTableName(),'info'),'left')
						->on('main_table.store_id','=','info.store_id')
						->where(DB::expr('regexp_split_to_array(info.product_subcategory,\',\')::integer[]'),'@>',DB::expr("'{".$categoryid."}'::integer[] and info.product_subcategory !=''"))            
						->execute()->as_array();       
			        		
		if(!empty($select)) {
			foreach($select as $key => $val) {				
				$placeResults[] = DB::select('main_table.place_id')
						->from(array('place_entity','main_table'))
						->where('main_table.place_category_id','=',$select[$key]['place_category_id'])
						->where('main_table.entity_primary_id','=',$select[$key]['store_id'])
						->execute()->as_array();
				
				if(!empty($placeResults)) {	
					if(array_key_exists(0,$placeResults[$key])) {	
						$results[] = $placeResults[$key][0];
					}
				}										
			}
		}		
        return $results;
   }
   
   public function getPrice($from,$to,$placeid) 
   {	   
	   $select = array();	   	   
	   $select = DB::select('main_table.place_id')
						->from(array(App::model('product/price')->getTableName(),'main_table'))
						->where('main_table.price', 'BETWEEN', array($from, $to));
	   if(is_array($placeid)) {
		   if(!empty($placeid)) {
			   $select->and_where('main_table.place_id', 'IN', $placeid);
		   }
	   }					
	   $result = $select->execute()->as_array();               						
       return $result;
   }
   
   public function getPlaceRelated($categoryid) {
	   $placeIds = array();
	   $select = DB::select('main_table.product_id')
						->from(array(App::model('core/category/product')->getTableName(),'main_table'))
						->where('main_table.category_id', '=', $categoryid)
						->execute()->as_array(); 
		foreach($select as $s) {
			$product[] = $s['product_id'];
		}							
		if(!empty($product)) {			
			$places = DB::select(array('main_table.company_place_id','place_id'))
					->from(array(App::model('company/association')->getTableName(),'main_table'))
					->where(DB::expr('regexp_split_to_array(main_table.product_ids,\',\')::integer[]'),'&&',DB::expr("'{".implode(",",$product)."}'::integer[] and main_table.product_ids !=''"))
					->execute()->as_array(); 											
					if(!empty($places)) {
						if(is_array($places)) {
							$placeIds = $places;
						}
					}	
		}		
		return $placeIds;				
   }
   
   public function getCityPlaceIds($cityid)
	{		
		$sql = 'select place_id from city c, place_temp_point ptp where st_contains(c.geom,ptp.geom) and gid = '.$cityid.' and ptp.place_id is not null and ptp.waiting_approval = false';
		$select = DB::query(Database::SELECT,$sql)->execute(App::model('location/city')->getDbConfig()); 
		$pids = array();
		foreach($select->as_array() as $s) {
			$pids[] = $s['place_id'];
		}
		return empty($pids) ? array(-5) :$pids;
	}
	
	public function requirementValidate()
    { 					
		$validate = Validation::factory($this->getData());
        $validate->rule('additional_info','not_empty');
        $validate->rule('city_id','not_empty');
        $validate->rule('category_id','not_empty');
        $validate->rule('brand_id','not_empty');
       
        if(!$validate->check()) { 
            throw new Validation_Exception($validate);
        }
        return $this;
    }
	
}
