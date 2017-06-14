<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_Edit_Mobile extends Blocks_Store_Abstract
{
    public function __construct()
    {
        $this->setTemplate('store/users/edit/mobile');
    }

    public function getElementname()
    {
        if(!$this->hasData('element_name')) {
            $this->setData('element_name','mobile_with_countrycode');
        }
        return $this->getData('element_name');
    }
}
