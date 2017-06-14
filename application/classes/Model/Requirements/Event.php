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
class Model_Requirements_Event extends Model_Abstract {
	
	public function requirementinfosave(Kohana_Core_Object $obj)
	{
		$requirement = $obj->getRequirement(); 
		$post = $obj->getPost();
		if(isset($post['requirement'])) {
			$userid = $post['created_by'];
		} else {
			$session = App::model('user/session');
			$user = App::model('user',false)->setData($session->getFormData());
			$userid = $session->getId();	
		}
		
		$username = App::model('user')->load($userid);
		$category = $requirement->getData('category_id');
		$requirement_id = $requirement->getData('requirement_id');	
		$from = $requirement->getData('price_from');
		$to = $requirement->getData('price_to');
		$city = $requirement->getData('city_id');
		
		$getCompany = array();
		$getStore = array();
		$getPrice = array();
		$placeRelated = array();
		
		$placeRelated = App::model('requirements')->getPlaceRelated($category);
		$cityPlaces = App::model('requirements')->getCityPlaceIds($city);
		
		$placeid =  array_map('current', $placeRelated);
		
		$placeid = array_values(array_unique(array_merge($cityPlaces,$placeid)));
		
		
		if($from != '' && $to != '') {
			$getPlaces = App::model('requirements')->getPrice($from,$to,$placeid);
		}
		
		if(!empty($getPlaces)) {			
			$getPlaces = array_values(array_unique($getPlaces,SORT_REGULAR));								
			$placeid =  array_map('current', $getPlaces);	
			
			if(!empty($placeid)) {
				foreach($placeid as $place) {					
					$requirementmodelinfo = App::model('requirements/info',false);
					$requirementmodelinfo->setRequirementId($requirement_id);
					$requirementmodelinfo->setPlaceId($place);
					$requirementmodelinfo->setCreatedBy($userid);
					$requirementmodelinfo->setCreatedDate(date("Y-m-d H:i:s",time()));
					$requirementmodelinfo->save();
					$exists=App::model('core/customer_website',false)->getUserByPlace($place);					
					$placeuserid[] = $exists->getOwnerId();								
					$places['place'][] = $place;
					$places['user_id'][] = $exists->getOwnerId();
					$placeusers[$place] =  $exists->getOwnerId(); 					
				}	
				
				$subtype = 'requirement_post';
				$templateid = App::model('core/subject')->getTemplate($subtype);
				$template = App::model('core/email_template')->load($templateid,'template_id');
				if($template->getTemplateId()) {
					if(is_array($places)) {
						$placeCollection = array();
						$placeuserid = array_values(array_unique(array_filter($places['user_id'])));	
						$querystring = array('reply'=>$requirement->getData('requirement_id'));
						$subtype = 'requirement_post';
												
						foreach($placeusers as $key => $val) {
							$placename = App::model('core/subject')->getPlaceName($key);
							$placeCollection[] = $placename['place_name'];							
							$messagereplace = array("PRODUCT_NAME" => $requirement->getData('additional_info') ,"PLACE_NAME" => $placename['place_name'], "LOCATION" => $requirement->getData('location'), "PRICE_FROM" => $requirement->getData('price_from'),"PRICE_TO" => $requirement->getData('price_to'), "USERNAME"=>$username->getFirstName());
							
							
							$notification=App::helper('notification');
							$notification->setReceivers(array($val));
							$notification->setSenders(array($userid,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)));
							$notification->setSubjectType($subtype);
							$notification->setSubject('Requirements for '.$requirement->getData('additional_info'));
							$notification->setMessage($messagereplace);
							$notification->setQueryString($querystring);
							$notification->setReplyStatus(false);
							$notification->setPlace(array($key));
							$notification->setPriority('important');
							//$notification->ForceStopEmailNotification();
							$notification->addToQueue('email');
							$notification->ForceStopAdmin();
							$notification->sendNotification();	
							
							$pushSubject = 'Requirements for '.$requirement->getData('additional_info');
							
							$pushMessage = $username->getFirstName().' has been posted a requirement for this store '.$placename['place_name'].' Requirement : '.$requirement->getData('additional_info').' Price From : '.$requirement->getData('price_from').' Location : '.$requirement->getData('price_to').' Price To : '.$requirement->getData('location');
							
							
							$pushNotification = App::helper('notification');
							$pushNotification->ForceStopAdmin();
							$pushNotification->ForceStopPermissionCheck();
							$pushNotification->ForceStopSystemNotification();
							$pushNotification->ForceStopEmailNotification();
							$pushNotification->addToQueue('iphone');
							$pushNotification->addToQueue('android');
							$pushNotification->setSenders(array($userid,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)));
							$pushNotification->setReceivers(array($val));
							$pushNotification->setArea('frontend');
							$pushNotification->setPushMessage($pushMessage);
							$pushNotification->setSubject($pushSubject);
							$pushNotification->setPlace(array($key));
							$pushNotification->setPushMessageData(array('requirement_id' => $requirement->getData('requirement_id')));
							$pushNotification->sendNotification();	
							
							
						}	
						if(!empty($placeusers)) {
							$adminMessage = array("PRODUCT_NAME" => $requirement->getData('additional_info') ,"PLACE_NAME" => implode(',',$placeCollection), "LOCATION" => $requirement->getData('location'), "PRICE_FROM" => $requirement->getData('price_from'),"PRICE_TO" => $requirement->getData('price_to'), "USERNAME"=>$username->getFirstName());
							$admin = App::ADMIN;
							$senderID = App::model('core/customer/website')->load($admin,'website_id')->getOwnerId();
					
							$notification=App::helper('notification');
							$notification->setReceivers(array($senderID));
							$notification->setSenders(array($userid,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)));
							$notification->setSubjectType('admin_requirement_post');
							$notification->setSubject('Requirements for '.$requirement->getData('additional_info'));
							$notification->setMessage($adminMessage);
							$notification->setQueryString($querystring);														
							$notification->setPriority('important');
							$notification->ForceStopEmailNotification();							
							$notification->sendNotification();	
						}																
					}		
				}		
				$this->noOfForwards($requirement_id,count($getPlaces));
			}			
		}		
	}
	
	public function noOfForwards($requirement_id,$count) {
		$model = '';
		$model = App::model('requirements');
		if($requirement_id) {								
			$model->setRequirementId($requirement_id);
			$model->setNoOfForwards($count);
			$model->save();						
		}
	}
	
}
