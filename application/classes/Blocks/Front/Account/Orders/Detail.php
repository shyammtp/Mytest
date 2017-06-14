<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Orders_Detail extends Blocks_Front_Abstract
{
    public function __construct()
    { 

    }
    
    public function getCreditSlips()
    {
        $creditmemo = App::model('credit')->getResource();
        $creditmemo->getSelect()->where('main_table.order_id','=', $this->getOrder()->getId());
        return $creditmemo->loadCollection()->getValues();
    }
}
