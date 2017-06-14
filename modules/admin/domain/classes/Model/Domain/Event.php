<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Session Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Domain_Event extends Model_Abstract {
     
    
    public function categorysave(Kohana_Core_Object $obj)
    {

        $website = $obj->getWebsite();
        $post = $obj->getPost();
        $categorymodel = App::model('core/category');
        if($website->getRootCategoryid()==0){
			
			 $categorymodel->setCategoryName($post->post('category'));
			 $categorymodel->setCategoryUrl(URL::title($post->post('category')));
			 $categorymodel->setCreatedDate(date("Y-m-d H:i:s",time()));
			 $categorymodel->save();
			 $website->setData('root_categoryid',$categorymodel->getCategoryID());
			 $website->save();
			
		}
		if($website->getRootCategoryid()){
			
			 $categorymodel->load($website->getRootCategoryid());
			 $categorymodel->setCategoryName($post->post('category'));
			 $categorymodel->setCategoryUrl(URL::title($post->post('category')));
			 $categorymodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
			 $categorymodel->save();
			
			
		}		
		
     
    }
}
