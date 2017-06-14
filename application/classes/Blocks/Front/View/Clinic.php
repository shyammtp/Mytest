<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_View_Clinic extends Blocks_Front_Abstract
{
    public function getClinic()
    {
        return App::registry('clinic');
    } 
}