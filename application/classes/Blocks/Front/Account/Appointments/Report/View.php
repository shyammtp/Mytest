<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Account_Appointments_Report_View extends Blocks_Front_Abstract
{ 
	public function getReport()
	{
		if(!$this->hasData('report')) {
			$this->setData('report',App::registry('report'));
		}
		return $this->getData('report');
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
	
	public function getGalleryImages()
    {
        $model = DB::select('*')->from(App::model('core/report/gallery')->getTableName())
                        ->where('report_id','=',$this->getReport()->getId())
                        ->order_by('added_on','desc')
                        ->execute(App::model('core/report/gallery')->getDbConfig());
						
		$images = array();
		foreach($model as $s) {
			$s['report_id'] = $s['report_id'];			
			$images[] = $s;
		}
        return $images;
    }
}
