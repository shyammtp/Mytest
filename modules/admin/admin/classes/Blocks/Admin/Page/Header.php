<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Page_Header extends Blocks_Admin_Abstract
{
    public function getCustomer()
    {
        return App::model('admin_session')->getCustomer();
    }

    public function getLogo($type = "horizontal")
    {
        if($type == 'horizontal') {
            $logo = App::getConfig('ADMIN_HORIZONTAL_LOGO');
        } else {
            $logo = App::getConfig('ADMIN_LOGO');
        }
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl('uploads').$logo;
        } else {
            $logo = App::getBaseUrl('uploads').$logo;
        }
        return $logo;
    }
}