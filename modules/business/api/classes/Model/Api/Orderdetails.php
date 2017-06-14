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
class Model_Api_Orderdetails extends Model_RestAPI {
	
	public function __construct()
	{ 		
		$this->_model = App::model('sales/place/orders');
	}
	
	
	public function get($params)
	{ 
		if(!isset($params['place_id'])) {
			throw HTTP_Exception::factory(401, array(
				'error' => __('Missing Place Id'),
				'field' => 'place_id',
			));
		}
		$language = 1;
		if(isset($params['language']) && $params['language']!='') {
			$language = $params['language'];
		}	
		$orders = $this->_model->load($params['id']);
		$order_info=$orders->getData();
		$parentOrder = $orders->getOrder();
		$customer = $parentOrder->getCustomer();
		$skippedstates = array(Model_Sales_Place_State::DELIVERY_PICKUP,Model_Sales_Place_State::PROCESSING);
		$placeorderstatus = App::model('sales/place_state')->getOrderStatusesapi();
		$orders_paymentinfo = App::model('sales/payment',false)->load($parentOrder->getOrderReference(),'order_reference');	
		$total_amount = 0;
		$grand_total_amount = 0;
		$deliverys = 0;
		$item_detail=array();
		$items = $orders->setLanguage($language)->getPlaceItems();
			foreach($items as $item){ 
				$product = $item->getProduct();  
				$total_amount += $item->getBasePrice()*$item->getQuantity();
				$deliverys += $item->getDeliveryCharge();
				$grand_total_amount += ($item->getBasePrice()*$item->getQuantity())+$item->getDeliveryCharge();
				$status='';
				if($item->isConfirmed()){
					$status=__('Confirmed');
				}else{
					if($item->getIsItemAvailable() == null){
						$status=__('Not Confirmed');
					}else{
						 $status=__('Item not available');
					}
				}
				if($item->isGift()){
					$status=__('Gift');
				}
				$skipstate = $skippedstates;
				if($item->isConfirmed()) {
					$skipstate[] = Model_Sales_Place_State::CONFIRMED;
				}
				$skipstate[] = Model_Sales_Place_State::SHIPPED;
				$skipstate[] = Model_Sales_Place_State::PAYMENT_TRANSFER;
				$skipstate[] = Model_Sales_Place_State::PAYMENT_RECEIPT;
				$skipstate[] = Model_Sales_Place_State::GOODS_RETURN;
				$subtotal = ($item->getBasePrice()*$item->getQuantity())+$item->getDeliveryCharge();
				$price=$parentOrder->formatPrice(($item->getQuantity() * $item->getBasePrice()));
				$delivery_charge=$parentOrder->formatPrice(($item->getDeliveryCharge()));
				$grand_total=$parentOrder->formatPrice($subtotal);
				$delivery_address=$item->getDeliveryAddress() ? $item->getDeliveryAddress() : '';
				$phone_number=$item->getPhoneNumber() ? __('Phone Number: ').$item->getPhoneNumber() : '';
				$estimate_delivery_date=$item->getDeliveryDate('d, M Y');
				$delivered_date=__('Item needs to delivered ').Date::fuzzy_span(strtotime($item->getDeliveryDate()));
				$item_history=App::model('sales/place_history',false)->getItemHistory($item->getItemId());
				$item_detail[]=array('item_id'=>$item->getItemId(),'item_name'=>$item->getItemName(),'status'=>$status,'place_item_referance'=>$item->getPlaceItemReference(),'item_image'=>$product->getProductThumbnail('w100',true,'h100'),'item_image1'=>$product->getProductThumbnail('w200',true,'h200'),'sold_by'=>$item->getPlaceName(),'quantity'=>$item->getQuantity(),'price'=>strip_tags($price),'delivery_charge'=>strip_tags($delivery_charge),'grand_total'=>strip_tags($grand_total),'delivery_name'=>$item->getDeliveryName(),'delivery_address'=>$delivery_address,'phone_number'=>$phone_number,'estimate_delivery_date'=>$estimate_delivery_date,'delivered_date'=>$delivered_date,'skip_states'=>$skipstate,'item_history'=>$item_history);
			}
		$resultant = array();
		$resultant['order']=$order_info;
		$resultant['customer']=$customer->getData();
		$resultant['payment_info']=$orders_paymentinfo->getPaymentMethodTitle();
		$resultant['customer']=$customer->getData();
		$resultant['item_detail']=$item_detail;
		$resultant['place_order_status']=$placeorderstatus;
		$resultant['subtotal']=strip_tags($parentOrder->formatPrice($total_amount));
		$resultant['total_shiiping']=strip_tags($parentOrder->formatPrice($deliverys));
		$resultant['grand_total']=strip_tags($parentOrder->formatPrice($grand_total_amount));
		return array('details' => $resultant,'total_rows' => $this->_totalItems);	 		 		
	}
	
	
	public function update($params)
	{		
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		if(!isset($params['item'])){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid item'),
				'field' => 'item',
			));
		}	
		if(!isset($params['porder_state'])){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid porder_state'),
				'field' => 'porder_state',
			));
		}
		$item = App::model('sales/place_items',false)->load($params['item']);
		if(!$item->getPorderId()){
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid item'),
				'field' => 'item',
			));
		}
		$placeorder = App::model('sales/place_orders',false)->load($item->getPorderId());
		try {
			if($placeorder->getOrder()->isCanceled()) {
				throw HTTP_Exception::factory(400, array(
					'error' => __('This Order has been Canceled'),
				));
				
			}
			if($params['porder_state']) {
				$placeorder->setItem($item)->validateStatus($params['porder_state']);
				switch($params['porder_state']) { 
					case Model_Sales_Place_State::DELIVERED:
						if(isset($params['comments']) && $params['comments']!=''){
							$message = $params['comments'];
						}else{
							$message = __('Item has been delivered to the above address');
						}
						$item->setState(Model_Sales_Place_State::DELIVERED,$message);
						
						//Only Push Notification
						$notification = App::helper('notification')->ForceStopAdmin()
										->ForceStopPermissionCheck()->ForceStopSystemNotification()
										->ForceStopEmailNotification()
										->addToQueue('iphone')->addToQueue('android');
						$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN))); 
						$notification->setReceivers(array($placeorder->getOrder()->getCustomer()->getId()))
										->setArea('frontend')
										->setPushMessage($message)
										->setSubject($message)
										->setPlace(array())
										->setPushMessageData(array('order_id' => $placeorder->getOrder()->getId()));
						$notification->sendNotification();
						$data['success'] = true;
						break;
					case Model_Sales_Place_State::CONFIRMED:
						foreach($placeorder->getPlaceItems() as $pitems) {
							if($pitems->getId() == $item->getId()) {  
								$item->setIsItemAvailable(true);
								$item->savePlaceItems();
								if(isset($params['comments']) && $params['comments']!=''){
									$message = $params['comments'];
								}else{
									$message = __('Item has been confirmed by the store');
								}
								$item->setState(Model_Sales_Place_State::CONFIRMED,$message);
								$order = $placeorder->getOrder();
								$notification = App::helper('notification')->ForceStopAdmin()
													->ForceStopPermissionCheck()->ForceStopSystemNotification()
													->ForceStopEmailNotification()->addToQueue('iphone');
								$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN))); 
								$notification->setReceivers(array($order->getCustomer()->getId()))
												->setArea('frontend')
												->setPushMessage($message)
												->setSubject($message)
												->setPlace(array())
												->setPushMessageData(array('order_id' => $order->getId()));
								$notification->sendNotification();
							}
						}
						$data['success'] = true;
					break;
					case Model_Sales_Place_State::SHIPPED: 
						if(isset($params['pickupdate']) && !$params['pickupdate']) {
								throw HTTP_Exception::factory(400, array(
									'error' => __('Invalid Shipped date'),
								));
						}
						$pickupdate = Date::formatted_time($params['pickupdate'],'Y-m-d H:i:s'); 
						if($pickupdate < Date::formatted_time()) {
							throw HTTP_Exception::factory(400, array(
									'error' => __('Invalid Shipped date'),
								));
						}
						foreach($placeorder->getPlaceItems() as $pitems) {
							if($pitems->getId() == $item->getId()) {
								$placestate = App::model('sales/place_history',false);
								$placestate->setPlaceOrderStateId(Model_Sales_Place_State::SHIPPED);
								if(isset($params['comments']) && $params['comments']!=''){
									$message = $params['comments'];
								}else{
									$message = __('his item has been shipped');
								}
								$placestate->setMessage($message);
								$placestate->setDateAdded(Date::formatted_time())
											->setPlaceOrderItemId($pitems->getId())
											->save();
								if(isset($params['notifycustomeremail']) && $params['notifycustomeremail']!='') {
									 $order  = $placeorder->getOrder();		
									$notification = App::helper('notification')->setUseTemplateData(true)->ForceStopAdmin()->ForceStopPermissionCheck()->ForceStopSystemNotification()->ForceStopPushNotification()->setCustomTemplateId(35); 
									$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN))); 
									$notification->setReceivers(array($placeorder->getOrder()->getCustomer()->getPrimaryEmailAddress()));
									$notification->setVariables(array('item' => $pitems,'order' => $order, 'customer' => $$order->getCustomer(), 'custom' => new Kohana_Core_Object(array('message' => $message,
																															   'date' => Date::formatted_time('now','d M Y h:i A'),
																															   'shippeddate' => Date::formatted_time($pickupdate,'d M Y h:i A')
																																		))));
									$notification->setBlockVariables(array('$pitems' => $pitems));
									$notification->sendNotification();
									
									//Only Push Notification
									$notification = App::helper('notification')->ForceStopAdmin()
													->ForceStopPermissionCheck()->ForceStopSystemNotification()
													->ForceStopEmailNotification()->addToQueue('iphone');
									$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN))); 
									$notification->setReceivers(array($order->getCustomer()->getId()))
													->setArea('frontend')
													->setPushMessage($placestate->getMessage())
													->setSubject($placestate->getMessage())
													->setPlace(array())
													->setPushMessageData(array('order_id' => $order->getId()));
									$notification->sendNotification();
								}
							}
						}
						$data['success'] = true;
					break;
					case Model_Sales_Place_State::CANCELED:
						foreach($placeorder->getPlaceItems() as $pitems) {
							if($pitems->getId() == $item->getId()) {  
								$item->setIsItemAvailable(false);
								$item->savePlaceItems();
								if(isset($params['comments']) && $params['comments']!=''){
									$message = $params['comments'];
								}else{
									$message = __('Item has been Denied by the store');
								}
								$item->setState(Model_Sales_Place_State::CANCELED,$message); 
							}
						}
					$data['success'] = true;
					break;
				}
			}
		} catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('validation',true); 
				$data['errors'] = $errors; 
		} catch(Kohana_Exception $ke) {
				Log::Instance()->add(Log::ERROR, $ke);
				$data['errors'] = $ke->getMessage();
		} catch(Exception $e) {
				Log::Instance()->add(Log::ERROR, $e);
				$data['errors'] = $e->getMessage();
		}
		if(isset($data['success']) && $data['success']!=''){
			$data['success'] =__('Item status updated successfully');
		}
		return $data;
		
	}
		
}	
