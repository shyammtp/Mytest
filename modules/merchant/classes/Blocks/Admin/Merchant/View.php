<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Merchant_View extends Blocks_Admin_Abstract
{
    
    public function getPlace()
    {
    	return App::registry('place'); 
    }

}