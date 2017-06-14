<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Adverts_Edit extends Blocks_Admin_Abstract
{
	protected $_advert;	
	protected $_advert1;
	
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function getAdvert()
    { 
		if(!$this->_advert){
			$id = $this->getRequest()->query('adverts_id');
			if($id) {				
				$select = DB::select('main_table.*','ci.*',array('ci.title','lang_title'),array('ci.description','description'),array('main_table.category_image','images'))->from(array(App::model('admin/advert')->getTableName(),'main_table'))
                                         ->join(array(App::model('admin/advert_info')->getTableName(),'ci'))
                                         ->on('main_table.adverts_id','=','ci.adverts_id')
                                         ->where('main_table.adverts_id','=',$id)->execute()->current();
				$this->_advert = App::model('admin/advert')->load($this->getRequest()->query('adverts_id'));
				$this->_advert =  new Kohana_Core_Object($select);
			} else {
                $this->_advert = new Kohana_Core_Object(array());
            }
		}
		return $this->_advert;
    }
    
    public function _getPlaceCategoryInfo($languageId = 1)
	{ 
		if(!$this->_place_category) {

			$getlanguage = DB::select(array(DB::expr('count(*)'),'totalcount'))->from(array(App::model('core/place_category')->getTableName(),'co'))
						->where('language_id','=',$languageId)
						->and_where('place_category_id','=',DB::expr('place_category.place_category_id'));
			$this->_place_category = DB::select('*')->from(App::model('core/place_category')->getTableName())
								->join('place_category_info','left')
								->on('place_category_info.place_category_id','=','place_category.place_category_id')
								->where('place_category_info.language_id','=',$languageId)
								->where('place_category.status','=',1)
								->where('place_category.place_category_id','!=',0)
								->where('place_category.category_parent_id','=',0)
								->order_by('place_category_info.place_name','asc')
								->execute(App::model('core/place_category')->getDbConfig());
		}
		return $this->_place_category;
	}
	
	public function getImageUrl($id) {		
		$query = DB::select('category_image')->from(App::model('admin/advert')->getTableName())
							->where('adverts_id', '=', $id)->limit(1)->execute()->as_array();	
		foreach($query as $val) {
			return $val['category_image'];
		}	
	}
	
	protected function _getAdvert()
    {  
		if(!$this->_advert1){
			$this->_advert1 = App::model('admin/advert')->load($this->getRequest()->query('adverts_id'));
		}
		return $this->_advert1;
    }
    
    public function getplaces($id) {		
		return $query = DB::select('place_id','place_index')->from('place_entity')->where('place_category_id', '=', $id)->execute()->as_array();
	}
    
}
