<?php  defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Settings_Googlemap extends Blocks_Admin_Abstract
{ 
	public function __construct(){
		$this->setTemplate('settings/googlemap');
	}
	
    protected function _getValue()
    {
		$attrs = $this->getFieldAttrs();
		return isset($attrs['value'])?$attrs['value']:array();
	}

}
