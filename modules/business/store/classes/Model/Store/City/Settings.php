<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Store_City_Settings extends Model_Core_City {
  
    public function validate($data)
    { 		
        $validate = Validation::factory($data);
        $validate->label('city_name',__('City'))
				->label('country_id',__('Country'))
                ->rule('country_id','not_empty')
                ->rule('city_name','not_empty');
                
       
			//$validate->rule('city_name',array($this,'city_name_allready_exists'), array($data['city_name'],$data['city_id']));
		        
        $cityid = '';
        if(isset($data['city_id'])) { 
           $cityid = $data['city_id'];
        }        
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }             
        return $this;
    }
    
    public function city_name_allready_exists($city_name,$city_id)
	{ 
		$city = DB::select('*')->from(array($this->getTableName(),'main_table'))->where('city_name','=',$city_name);
		if($city_id){
				$city->where('city_id','!=',$city_id);
		}
		$result = $city->execute();
		return count($result) < 1;
	}
	
    public function saveCity()
    {		
        $request = Request::current();
		$data = $request->post();
		if($this->hasData('post_data')) {
			$data = $this->getData('post_data');
		}
        App::dispatchEvent('city_Save_Before',array('post'=> $data,'city' => $this));
        parent::save();
        App::dispatchEvent('city_Save_After',array('post'=> $data,'city' => $this));
        return $this;
    }

}
