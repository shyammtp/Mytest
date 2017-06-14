<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Search_Insurance extends Blocks_Front_Abstract
{    
    public function getInsurance()
    {
        return App::registry('insurance'); 
    }
}
