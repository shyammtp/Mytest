<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Page_Wrapper extends Blocks_Front_Abstract
{
    public function __construct()
    { 
        $this->setTemplate('page/wrapper');
    }
}