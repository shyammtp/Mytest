<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Contains the most low-level helpers methods in Kohana:
 *
 * - Environment initialization
 * - Locating files within the cascading filesystem
 * - Auto-loading and transparent extension of classes
 * - Variable and path debugging
 *
 * @package    Kohana
 * @category   Base
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Helpers_User extends Kohana_Core_Object {
    
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
							return App::getBaseUrl().'cache/uploads/cache/thumb_80x80/'.$gal;
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
						return App::getBaseUrl().'cache/uploads/cache/thumb_80x80/'.$gal;
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
						return App::getBaseUrl().'cache/uploads/cache/thumb_80x80/'.$gal;
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
						return App::getBaseUrl().'cache/uploads/cache/thumb_80x80/'.$gal;
					}
				}
				return false;
				break;             
		}
	}
}