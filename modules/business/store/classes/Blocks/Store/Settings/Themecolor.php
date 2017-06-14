<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Settings_Themecolor extends Blocks_Store_Abstract
{
	public function __construct()
	{
		$this->setTemplate('settings/themecolor');
	}

	protected function _getValue()
    {
		$attrs = $this->getFieldAttrs(); 
		return Arr::get($attrs,'value','');
	}
}
