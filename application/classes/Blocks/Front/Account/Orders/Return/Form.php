<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Orders_Return_Form extends Blocks_Front_Abstract
{
	
	public function getReturnRequest()
	{
		if(!$this->hasData('return_request')) {
		$select = DB::select('request_id')->from(App::model('sales/return')->getTableName())
					->where('item_id','=',$this->getItem()->getId())
					->execute()->current();
			$this->setData('return_request',App::model('sales/return',false)->setData($select));
		}
		return $this->getData('return_request');
	}
 
}
