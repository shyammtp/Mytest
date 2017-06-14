<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Orders_Statuses extends Blocks_Front_Abstract
{ 
    
    public function getUserStatuses()
    {
    	return App::model('sales/place_history')->getUserStatuses();
    }
    
    public function getStatuses()
    {
    	return App::model('sales/place_history')->getStatuses();
    }
    
    public function getLastHistory($itemid)
    {
    	return App::model('sales/place_history')->getLastHistory($itemid);
    }
    
    public function getLastUpdatedStatus($itemid)
    {
    	return App::model('sales/place_history')->getLastUpdatedStatus($itemid);
    }
 
}
