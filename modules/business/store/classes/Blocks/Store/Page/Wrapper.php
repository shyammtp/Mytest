<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Page_Wrapper extends Blocks_Store_Abstract
{ 
    public function __construct()
    {
        $this->setTemplate('page/wrapper');
    }
}