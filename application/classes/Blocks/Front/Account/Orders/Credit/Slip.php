<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Orders_Credit_Slip extends Blocks_Front_Abstract
{
	public function getLogo($type = "horizontal")
    {
        if($type == 'horizontal') {
            $logo = App::getConfig('ADMIN_HORIZONTAL_LOGO',Model_Core_Place::ADMIN);
        } else {
            $logo = App::getConfig('ADMIN_LOGO',Model_Core_Place::ADMIN);
        }
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl('uploads').$logo;
        }
        return $logo;
    }
	
	public function getCredit()
	{		
		return App::registry('credit');
	}
 
}
