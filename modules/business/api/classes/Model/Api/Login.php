<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Login extends Model_RestAPI {
	
	public function __construct()
	{ 
		$this->_model = App::model('user');
	}
	
	public function create($params)
	{
		$user = $this->_validation($params);
		$resultant = $user;
		unset($resultant['profile']['password'],$resultant['profile']['verification_key'],$resultant['profile']['password_verification_code'],$resultant['profile']['password_verification_key']);
		return array('details' => $resultant,'total_rows' => 1);
	}
	
	 
	
	public function _validation($params)
	{ 
		$data = array();
		if(isset($params['user_type'])) {
			
				if(isset($params['user_type']) && isset($params['profile_id'])) {
					if($customer = $this->login($params)) {
						$data['profile']=$customer['user']->getData();
						$data['url'] = App::getBaseUrl('media');
						$data['geoserver_url'] = App::getConfig('GEOSERVER_URL',Model_Core_Place::ADMIN);
						$data['bizbox_subjects'] = App::model('core/subject')->getEmailsubjects(Arr::get($params,'language',1));
						$data['associated_accounts']=$customer['aaccount']->getData(); 
						$data['places_and_roles']=$this->roles($customer['aaccount']->getRoles());
						$data['cartcount'] = $this->getCartItemsCount();
						
						return $data;
					} else {
						throw HTTP_Exception::factory(401, array(
						'error' => __('Invalid User Type/Profile Id'),
						'field' => '',
						));
					}
				}
				else{
					throw HTTP_Exception::factory(401, array(
						'error' => __('Invalid User Type/Profile Id'),
						'field' => '',
					));
				}	
		} else {	
			
				if(isset($params['email']) && isset($params['password'])) {
					
					if($customer = $this->login($params)) { 
						$data['profile']=$customer['user']->getData();
						$data['url'] = App::getBaseUrl('media');
						$data['geoserver_url'] = App::getConfig('GEOSERVER_URL',Model_Core_Place::ADMIN);
						$data['bizbox_subjects'] = App::model('core/subject')->getEmailsubjects(Arr::get($params,'language',1));
						$data['associated_accounts']=$customer['aaccount']->getData(); 
						$data['places_and_roles']=$this->roles($customer['aaccount']->getRoles());
						$data['usercart'] = $this->getCartItemsCount($customer['user']);
						
						if(isset($params['app_user']) && $params['app_user']!=''){
							if(isset($data['profile']['is_verified']) && $data['profile']['is_verified']){
								return $data;
							}
							else {
								throw HTTP_Exception::factory(401, array(
									'error' => 3,
									'field' => '',
									));
							}
						}
						if($data['associated_accounts']['owners'] ||  $data['places_and_roles']){
							return $data;
						} else {
							throw HTTP_Exception::factory(401, array(
							'error' => 1,
							'field' => '',
							));
						}
							
						} else {
							
						
						throw HTTP_Exception::factory(401, array(
						'error' => 2,
						'field' => '',
						));
					}	
				} else {
					throw HTTP_Exception::factory(401, array(
						'error' =>2,
						'field' => '',
					));
				}	
		}
	}
	
	public function login($post = array())
    {
		$customer = $this->_model->selectAttributes('*')
							->filter('status', array('=',true))
							->filter('is_verified', array('=',true));
		switch (isset($post['user_type'])) {
					case 'F':
						$customer->filter('facebook_profile_id', array('=',$post['profile_id']));
					break;
					case 'G':
						$customer->filter('gplus_profile_id', array('=',$post['profile_id']));
					break;
					default:
						$customer->filter('password', array('=',md5($post['password'])))
								->filter('primary_email_address', array('=',strtolower($post['email'])));
		}
        $select = $customer->loadCollection();

        if(isset($select[0])) { 
            $select = $select[0];
            $ownerset = $select->getOwners($select->getUserId(),false); 
            $associatedStores = $select->getAssociatedStores()
                                ->getAssociatedRoles();
			$ownersets = array();
			foreach($ownerset->as_array() as $s) {
				if(Arr::get($s,'place_id')) {
					$s['place_logo'] = $this->_getLogo(Arr::get($s,'place_id'));
				}
				$ownersets[] = $s;
			}
            $associatedAccount = array(); 
            $associatedAccount['owners'] = $ownersets;
			
            $associatedAccount['roles'] = $associatedStores;
            App::dispatchEvent('Access_Login_Approved',array('user' => $select,'aaccount' => new Kohana_Core_Object($associatedAccount)));
            //No Roles Associated with the user
            //$rolemodel = $this->_getRoleModel()->setCustomer($select)->checkOnAdminRoles(); 
            //App::dispatchEvent('Admin_Login_After',array('role' => $rolemodel,'user' => $select));
            return array('user' => $select,'aaccount' => new Kohana_Core_Object($associatedAccount));
        }
        return false;
    }
	
	private function getCartItemsCount($user)
	{ 
		$cart = $user->getLastCart(); 
		return array('cart_id' => $cart->getCartReference(), 'total_items' => count($cart->getItems()));
	}
	
	private function _getLogo($place_id)
    { 
        $logo = App::getConfig('STOREADMIN_LOGO',$place_id);
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl('uploads').'cache/uploads/cache/w200/'.$logo;
        } else {
            $logo = false;
        }
        return $logo;
    }
	
	public function roles($roles = array())
    { 
		if(count($roles)){
			$place_ids=array();
			$user_roles=array();
			foreach($roles as $key => $role){
				$place_ids[]=$key;
				$user_roles=Arr::merge($role,$user_roles);
			}
			
			$role = App::model('core/role',false)->getuserroles($user_roles);
	 	
			$place = App::model('core/place',false)->getPlaceInfos($place_ids);	
			if(count($place)){
				$place_infos=array();
				$place_id=array();
				foreach($place as $keys => $values){
					$values['place_logo'] = $this->_getLogo($values['place_id']);
					$place_infos[$values['place_id']]=$values;
					$place_id[]=$values['place_id'];

				}
			
				if(count($role)){
					$user_roles1=array();
					foreach($role as $key1=>$value1){
						if(in_array($value1['role_id'], $user_roles)){
							$user_roles1[$value1['role_id']] = $value1;
						}
					}
				} 
				$place_set=array();		
				foreach($roles as $key => $role){
					if(isset($place_infos[$key])){
						$place_set[$key]=$place_infos[$key];
					}	
					$place_set[$key]['associates']=array();
					foreach($role as $rolesset){
						if(isset($user_roles1[$rolesset])){
							$place_set[$key]['associated_roles'][]=$user_roles1[$rolesset];
						}
					}
				}			
				return $place_set;
			}	
		}		
	}	

}	
