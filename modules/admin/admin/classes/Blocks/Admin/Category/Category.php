<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Category extends Blocks_Admin_Category_Addcategory_Addcategory
{
	protected $_category;
    public function __construct()
    {
		 parent::__construct();
	}
	
	protected function _getCategoryInfo($id,$level)
    {

		if(!$this->_category){
			$this->_category = App::model('core/category')->getCategories($id,$level);
		}
		return $this->_category;
    }
	
}
