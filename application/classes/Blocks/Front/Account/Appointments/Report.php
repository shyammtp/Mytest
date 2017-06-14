<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Account_Appointments_Report extends Blocks_Front_Abstract
{ 
	
	public function getAppointments()
	{
		return App::registry('appointments');
	}
	
	public function getLogo($type = "square")
    {
        if($type == 'horizontal') {
            $logo = App::getConfig('ADMIN_HORIZONTAL_LOGO',Model_Core_Place::ADMIN);
        } else {
            $logo = App::getConfig('ADMIN_LOGO',Model_Core_Place::ADMIN);
        }
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl().$logo;
        }
        return $logo;
    }

}
