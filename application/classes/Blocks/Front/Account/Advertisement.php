<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Account_Advertisement extends Blocks_Front_Account
{
	public function getBanner($bannerType,$position,$lat,$lon,$city) 
	{		
		$banners = App::model('core/banner')->getBanners($bannerType,$position,$lat,$lon,$city);			
		return $banners;		
	}

}
