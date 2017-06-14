<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Category_Blocklist extends Blocks_Front_Abstract
{
	public function __construct()
	{
		$this->setTemplate('category/blocklist');
	}

}
