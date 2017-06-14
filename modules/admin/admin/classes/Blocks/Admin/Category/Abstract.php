<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Abstract extends Blocks_Admin_Abstract
{
    public function getCategories($level ='')
    {
        $category = App::model('core/category'); 
        return $category->getCategories($this->getRootCatId(),$level);
    }
    
    public function getRootCatId()
    {
        if(!$this->hasData('root_category_id')) {
            $this->setData('root_category_id',App::instance()->getWebsite()->getRootCategoryid());
        }
        return $this->getData('root_category_id');
    }
    
    public function getAllCategories()
    {
        return App::model('core/category')->getAllCategories();
    }
}
