<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Dashboard_Report extends Blocks_Admin_Dashboard_Dashboard
{  
    public function __construct()
    {
		parent::__construct();
		$this->setTemplate('dashboard/report/report');
	}
	
	public function getHtmlData()
	{
		$type = $this->getRequest()->query('_data');
		switch($type)
		{
			case "place_stats":
					$block = $this->getRootBlock()->createBlock('Admin/Dashboard/Chart')
							->setTemplate('dashboard/report/chart/place_stats');
					return $block->toHtml();
				break;
			default:
				$block = $this->getRootBlock()->createBlock('Admin/Dashboard/Chart')
							->setTemplate('dashboard/report/chart/newcustomer');
					return $block->toHtml();
				break;
		}
	}
}
