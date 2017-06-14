<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Area_Settings extends Model_Core_Area {

    
    public function validate($data)
    { 		
        $validate = Validation::factory($data);
        $validate->label('area_name',__('Area'))
				->label('country_id',__('Country'))
				->label('city_id',__('City'))
                ->rule('country_id','not_empty')
                ->rule('city_id','not_empty')
                ->rule('area_name','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)));
                
        /*if(empty($data['area_id'])){
			$validate->rule('area_name',array($this,'area_name_allready_exists'), array($data['area_name']));
		}       */ 
        $areaid = '';
        if(isset($data['area_id'])) { 
           $areaid = $data['area_id'];
        }        
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }             
        return $this;
    }
    
    public function area_name_allready_exists($area_name)
	{ 
		$area = DB::select('*')->from(array($this->getTableName(),'main_table'))->join(array(App::model('core/area/info')->getTableName(),'info'),'left')->on('main_table.area_id','=','info.area_id')->where('info.area_name','=',$area_name[1])->execute();
		
		return count($area) < 1;
	}
	
    public function saveArea()
    {		
        $request = Request::current();
		$data = $request->post();
		if($this->hasData('post_data')) {
			$data = $this->getData('post_data');
		}
        App::dispatchEvent('Area_Save_Before',array('post'=> $data,'area' => $this));
        parent::save();
        App::dispatchEvent('Area_Save_After',array('post'=> $data,'area' => $this));
        return $this;
    }
    
    public function importvalidate()
    {
		$data = $this->getData();
        $validate = Validation::factory($data);
        $validate->label('area_name',__('Area'))
				->rule('country_id','not_empty')
				->rule('city_id','not_empty')
                ->rule('area_name','language_not_empty',array(':value',array(Model_Core_Language::DEFAULT_LANGUAGE)));
        if($data['country_id'] && $data['city_id']){
			$validate->rule('city_id',array($this,'checkCountryCityIdValidate'),array($data['country_id'],$data['city_id']));
		}
        if(!$validate->check()) {
            throw new Validation_Exception($validate);
        }
        return $this;
    }
    
    public function checkCountryCityIdValidate($country_id,$city_id)
    {
		$select = DB::select('city_id')->from(array(App::model('core/city',false)->getTableName(),'main_table'))
								->where('country_id','=',$country_id)					
								->where('city_id','=',$city_id);						
		$result = $select->execute();	
		if(count($result) < 1){
			return false;
		}
		return true;
    }

}
