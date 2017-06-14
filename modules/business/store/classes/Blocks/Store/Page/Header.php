<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Page_Header extends Blocks_Store_Abstract
{
    
    public function getCustomer()
    {
        return App::model('store/session')->getCustomer();
    }
    
    public function getLogo()
    { 
        $logo = App::getConfig('ADMIN_HORIZONTAL_LOGO',Model_Core_Place::ADMIN);
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl('uploads').'cache/uploads/cache/h80/'.$logo;
        } else {
            $logo = App::getConfig('ADMIN_HORIZONTAL_LOGO',Model_Core_Place::ADMIN);
            if($logo && file_exists(DOCROOT.$logo)) {
                $logo = App::getBaseUrl('uploads').'cache/uploads/cache/h80/'.$logo;
            }
        }
        return $logo;
    }
     
    private $_subscription;
    public function getSubscription()
    {
        if(!$this->_subscription) {
            $this->_subscription = App::registry('subscription');
        }
        return $this->_subscription;
    }
    
    public function totalSubscriptionDays()
    {
        return $this->getSubscription()->getNoDays();
    }
    
    public function getPlace()
    {
        $currentplace = App::instance()->getPlace(); 
		if(!$currentplace->isCompany()) {
			if($currentplace->getParentId()!=0) { 
				$currentplace = $currentplace->setLanguage(App::getCurrentLanguageId())->getParent();
			}
		}
		return $currentplace;
    }
}
