<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_View extends Blocks_Store_Abstract
{ 
	
	public function getUsers()
	{
		return App::registry('users');
	}

	protected function getRoles($userid)
    {
        return App::model('core/role')->getRolesForCustomer($userid);
    }

	protected function getActivities()
	{
		return $this->getUsers()->getActivity();
	}

	public function getPlaceImage($placecategoryId,$primaryid)
	{
		switch($placecategoryId) {
			case Model_Core_Place_Category::STORE:
					$gal = DB::select('file')->from(App::model('store/gallery')->getTableName())
								->where('store_id','=',$primaryid)
								->where('thumbnail','=',true)
								->execute(App::model('store/gallery')->getDbConfig())->get('file');
					if($gal) {
						if(file_exists(DOCROOT.$gal)) {
							return App::getBaseUrl('uploads').'cache/uploads/cache/thumb_80x80/'.$gal;
						}
					}
					return false;
				break;
			case Model_Core_Place_Category::COMPANY:
				$gal = DB::select('file')->from(App::model('company/gallery')->getTableName())
								->where('company_id','=',$primaryid)
								->where('thumbnail','=',true)
								->execute(App::model('store/gallery')->getDbConfig())->get('file');
				if($gal) {
					if(file_exists(DOCROOT.$gal)) {
						return App::getBaseUrl('uploads').'cache/uploads/cache/thumb_80x80/'.$gal;
					}
				}
				return false;
				break;
			case Model_Core_Place_Category::EDUCATION:
				$gal = DB::select('file')->from(App::model('education/gallery')->getTableName())
								->where('education_id','=',$primaryid)
								->where('thumbnail','=',true)
								->execute(App::model('store/gallery')->getDbConfig())->get('file');
				if($gal) {
					if(file_exists(DOCROOT.$gal)) {
						return App::getBaseUrl('uploads').'cache/uploads/cache/thumb_80x80/'.$gal;
					}
				}
				return false;
				break;
            case Model_Core_Place_Category::HEALTHCARE:
				$gal = DB::select('file')->from(App::model('healthcare/gallery')->getTableName())
								->where('healthcare_id','=',$primaryid)
								->where('thumbnail','=',true)
								->execute(App::model('store/gallery')->getDbConfig())->get('file');
				if($gal) {
					if(file_exists(DOCROOT.$gal)) {
						return App::getBaseUrl('uploads').'cache/uploads/cache/thumb_80x80/'.$gal;
					}
				}
				return false;
				break;  
		}
	}
}
 
