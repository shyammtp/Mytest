<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Settings_Exchangerate extends Blocks_Admin_Abstract
{ 
    public function __construct()
    {
        $this->setTemplate('settings/exchangerate');
    }
}