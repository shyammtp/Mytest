<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Subscription extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = "";
	}
	
	public function get($params)
	{ 
		if(!isset($params['place_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place id'),
				'field' => 'place',
			));
		}
		$promotion =$this->_getPromotionDetails($params['place_id']); 	
		return $promotion;

	}	
	
	public function _getPromotionDetails($place_id) 
	{
		$place=App::model('core/place')->load($place_id);
		$placeid = $place->getData('parent_id');
        $childPlaces = App::model('core/place')->getChildIds($placeid); 
        if($childPlaces){
			$PromotionIDS = App::model('core/promotion',false)->getPromotionDetails($childPlaces);
			$CheckStoreSub = App::model('subscriptionplace',false)->load($placeid,'place_id');
			if($CheckStoreSub){
				$PromotionSubCount = $CheckStoreSub->getNoOfPromotionsSubscribe();
				$promotion=array('no_of_promotion_subscribed'=>$PromotionSubCount,'no_of_promotions_added'=>count($PromotionIDS));
				return $promotion; 
			}
		}
		return array();
	}
	


}	
