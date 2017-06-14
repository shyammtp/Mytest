<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Requirements_Edit extends Blocks_Front_Abstract
{
	protected $_requirement;
		
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getRequirement()
    { 		
		if(!$this->_requirement){
			$this->_requirement = App::model('user/requirements')->load($this->getRequest()->query('id'));
		}
		return $this->_requirement;
    }
    
    public function getCategoryList() 
    {		
		return $categories = App::model('requirements')->getCategoryList();		
	}
	
	public function getBrandList() 
    {		
		return $brands = App::model('requirements')->getBrandList();		
	}
	
	public function getPlaces() 
    {		
		$langId = 1;		
		return $this->_places = DB::select('main_table.requirement_info_id','pl.place_id','pl.place_index','plinfo.place_name')
								->from(array(App::model('requirements/info')->getTableName(),'main_table'))
								->join(array('place_entity','pl'),'left')
								->on('main_table.place_id','=','pl.place_id')
								->join(array('place_info','plinfo'),'left')
								->on('pl.place_id','=','plinfo.place_id')								
								->where('plinfo.language_id','=',$langId)													
								->where('main_table.requirement_id','=',$this->getRequest()->query('id'))
								->execute()->as_array();
	}
	
	public function getComments() 
    {				
		$langId = 1;
		return $this->_comments = DB::select(array('user.value','comment_author'),'co.created_date','co.comments','main_table.place_id')
								->from(array(App::model('requirements/info')->getTableName(),'main_table'))
								->join(array(App::model('requirements/comments')->getTableName(),'co'),'left')
								->on('main_table.requirement_info_id','=','co.requirement_info_id')		
								->join(array(App::model('user/attribute')->getTableName(),'user'),'left')
								->on('co.created_by','=','user.user_id')														
								->where('main_table.requirement_id','=',$this->getRequest()->query('id'))
								->where('user.language_id','=',$langId)
								->execute()->as_array();								
	}
	
	public function getCategory($category) 
	{
		return $category = App::model('requirements')->getCategory($category);
	}
    
    public function getBrand($brand)
    {
		return $brand = App::model('requirements')->getBrand($brand);
	}
	
	public function getCityList() {
		return $city = App::model('location/city')->toOptionArray();		
	}
}
