<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Store_Country_Settings extends Model_Core_Country {
    
    public function validate($data)
    { 		
        $validate = Validation::factory($data);
        $validate->label('country_name',__('Country'))
				->label('country_code',__('Country Code'))
                ->rule('country_name','not_empty')
                ->rule('country_code','not_empty'); 
            
			$validate//->rule('country_name',array($this,'country_name_allready_exists'), array($data['country_name'],$data['country_id']))
					 ->rule('country_code',array($this,'country_code_allready_exists'), array($data['country_code'],$data['country_id']));     
        $countryid = '';
        if(isset($data['country_id'])) { 
           $countryid = $data['country_id'];
        }        
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }             
        return $this;
    }
    
    public function country_name_allready_exists($country_name,$country_id)
	{ 
		$country = DB::select('*')->from(array($this->getTableName(),'main_table'))->where('country_name','=',$country_name);
		if($country_id){
				$country->where('country_id','!=',$country_id);
		}
		$result = $country->execute();
		return count($result) < 1;
	}
	
	public function country_code_allready_exists($country_code,$country_id)
	{ 
		$country_code = DB::select('*')->from(array($this->getTableName(),'main_table'))->where('country_code','=',$country_code);
		if($country_id){
				$country_code->where('country_id','!=',$country_id);
		}
		$result = $country_code->execute();
		return count($result) < 1;
	}
   
    public function saveCountry()
    { 
        $request = Request::current();
		$data = $request->post();
		if($this->hasData('post_data')) {
			$data = $this->getData('post_data');
		}
        App::dispatchEvent('Country_Save_Before',array('post'=> $data,'country' => $this));
        parent::save();
        App::dispatchEvent('Country_Save_After',array('post'=> $data,'country' => $this));
        return $this;
    }

}
