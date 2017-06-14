<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Addcategory_Addcategory extends Blocks_Admin_Abstract
{
    protected $_category;
    protected $_category1;
    protected function _prepareBlocks()
    { 
        parent::_prepareBlocks();
       
    } 
    
    public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	public function isReadOnly()
	{
		$array = App::model('core/place_category')->getDefaultPlaces();
		$catid = $this->_getCategory()->getId();
		if(in_array($catid,$array)) {
			return true;
		}
		return false;
	}
    
    public function getCategory()
    {
       $catid = $this->getRequest()->query('category_id');
	   $categorymodel = App::registry('category');
        if(!$this->_category) {
             if($catid) {
             $select = DB::select('main_table.*','ci.*',array('ci.place_name','lang_catname'),array('ci.place_description','description'),array('main_table.category_image','images'))->from(array(App::model('core/category')->getTableName(),'main_table'))
                                         ->join(array(App::model('core/category_info')->getTableName(),'ci'))
                                         ->on('main_table.place_category_id','=','ci.place_category_id')
                                         ->where('main_table.place_category_id','=',$catid)->execute(App::model('core/category')->getDbConfig())->current();
				$select = Arr::merge($select,$categorymodel->getData());
				$this->_category =  new Kohana_Core_Object($select);
             } else {
                $this->_category = new Kohana_Core_Object(array());
             }
        }
        return $this->_category;
    }
    
    public function getImages()
    { 
        if($this->getCategory()->getImages()) {
            $img = array();
            $images = json_decode($this->getCategory()->getImages(),true); 
            foreach($images as $res => $url) { 
                $img[$res] = str_replace("\\","/",$url);
            }
            return new Kohana_Core_Object($img);
        }
        return new Kohana_Core_Object(array());
    }
    
    protected function _getCategory()
    { 
		if(!$this->_category1){
			$this->_category1 =  App::registry('category'); 
		}
		return $this->_category1;
    }
    

    
    
}
