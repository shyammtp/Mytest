<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Session Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Store_Adminevent extends Model_Abstract {

    public function afterLogin(Kohana_Core_Object $obj)
    { 
        $obj->getSession()->setDatas('is_owner',$obj->getCustomer()->checkOwner($obj->getCustomer()->getUserId()));
    }

    public function storeinfosave(Kohana_Core_Object $obj)
    {
        $store = $obj->getStore();
        $post = $obj->getPost();
        $infomodel = App::model('core/store_info')->load($store->getInfoId());
        $infomodel->setName($post->post('name'));
        $infomodel->setDescription($post->post('description'));
		$imagedata = App::model('core/image')->uploadFileManagerImage($post->post('storeimage'),$post->post('name'),Model_Core_Store_Info::CACHE_STORE_UPLOAD_DIRECTORY);
		$infomodel->setImages($imagedata);
        $infomodel->save();
        $store->setInfoId($infomodel->getInfoId());
        $store->save();
    }

	public function setDefaultplaceid(Kohana_Core_Object $obj)
	{
		$role = $obj->getRole();
		$user = $obj->getUser();
		$hisowncompany = $this->getOwner($user->getUserId());
		$placeids = array();
		foreach($hisowncompany as $c) {
			$placeids[$c['place_id']] = $c['place_index'];
		}
		$placeid = 2;
		if(isset($placeids[$placeid])) {
			App::setCurrentStore($placeids[$placeid]);
		}
	}

	public function checkAllAccess(Kohana_Core_Object $obj)
	{
		$role = $obj->getRole();
		$user = $obj->getUser();
	}

	public function getOwner($customerid,$withwebsite = true)
    {
		$user = DB::select('*')->from(array(App::model('core/customer_website')->getTableName(),'main_table'))
						->join(array(App::model('core/place')->getTableName(),'p'),'left')
						->on('p.place_id','=','main_table.place_id');
		if($withwebsite) {
			$user->where('main_table.website_id','=',App::instance()->getWebsite()->getWebsiteId());
		}
		$select = $user->where('main_table.owner_id','=',$customerid)
						->execute();
		return $select;
    }
	
	public function loginactivity(Kohana_Core_Object $obj)
    {
		/*try {
			$role = $obj->getRole();
			$user = $role->getCustomer(); 
			if($user->getUserId()) {       
				$roles = $role->getRolesForCustomer($user->getUserId());  
				$adminplaces = $role->getAdminPlaces(); 
				$message = "Logged in as ";
				if(array_key_exists(App::instance()->getPlace()->getPlaceId(), $adminplaces) && $user->checkOwner($user->getUserId())) {
					$message .= "administrator in ".$adminplaces[App::instance()->getPlace()->getPlaceId()];
				}
				else {
				   if($roles->as_array()) {
					   foreach($roles->as_array() as $r) {
						   $message .= $r['role_name'];
						   $message .= ' in '. $r['place_name'];
					   }
				   } else {
					   $message .= "administrator in street directory";
				   }
				} 
				App::userlog($message,$user->getUserId());
			}
		}
		catch(Exception $e) { 
		}*/
    }
	
	public function logoutactivity(Kohana_Core_Object $obj)
    {
        $user = $obj->getSession()->getCustomer();
        $message = "Logged out";
        App::userlog($message,$user->getUserId());
    }
    
    public function api_account_store_save(Kohana_Core_Object $obj)
    { 
        $api = $obj->getApi();
        $post = $obj->getPost();	 
        App::model('core/api_resources')->deleterow($api->getAccountId(),'account_id'); 
        if(isset($post['resource'])) {            
            foreach($post['resource'] as $key =>  $res) {
                foreach($res as $method => $resource) {
                $model = App::model('core/api_resources',false)->setResources($key)
                                    ->setMethod($method)
                                    ->setAccountId($api->getAccountId())
                                    ->save();
                }
            }
        }
		
        $role_users = App::model('core/role_users')->getRoleusers($api->getRoleId());
		
        App::model('core/api_store')->deleterow($api->getAccountId(),'api_account_id'); 
        foreach($role_users as $key1 => $users){ 
			 $model = App::model('core/api_store',false)->setApiAccountId($api->getAccountId())
								->setPlaceId($users->place_id)
								->setUserId($users->user_id)
								->save();
		}	
    }
    
    public function people_infosave(Kohana_Core_Object $obj)
    { 
		$peoples = $obj->getPeoples();
        $post = $obj->getPost();
			$specialist = $post['specialist'];
			$nationality = $post['nationality'];
			$profile_description = $post['profile_description'];
			$infomodel = App::model('store/peoples_info',false);
			try{
			$infomodel->deleterow($peoples->getPeopleId(),'people_id');
			$languages = App::model('core/language')->getLanguages();
				foreach($languages as $language_id => $lang){
					 if((isset($specialist[$language_id]) && $specialist[$language_id]!="") || (isset($nationality[$language_id]) && $nationality[$language_id]!="") || (isset($profile_description[$language_id]) && $profile_description[$language_id]!="")){ 
						$infomodel->setLanguageId($language_id);
						$infomodel->setPeopleId($peoples->getPeopleId()); 
						$infomodel->setSpecialist($specialist[$language_id]);
						$infomodel->setNationality($nationality[$language_id]);
						$infomodel->setProfileDescription($profile_description[$language_id]);
						$infomodel->save();
					} 
				}
			}catch(Exception $e) {
				
				Log::Instance()->add(Log::ERROR, $e);
			}

    
    
	}
}
