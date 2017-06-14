<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Account extends Blocks_Front_Abstract
{
	protected $_renderAttrs = array();
	protected $_elementAttrs = array();
	const ENTITY_TYPE_ID = 1;
	public function getEntity()
	{
		if(!$this->hasData('entity')) {
			$this->setData('entity', App::model('entity')->load(Model_User::ENTITY_CODE,'entity_code'));
		}		
		return $this->getData('entity');
	}

	public function setRenderAttrs($code)
	{ 
		$this->_renderAttrs[] = $code;
		return $this;
	}

	public function setElementAttrs($key, $attrs = '')
	{
		
		if(is_array($key)) {
			$this->_elementAttrs = $key;
		}
		else {
			$this->_elementAttrs[$key] = $attrs;
		}		
		return $this;
	}

	public function render($attribute_code)
	{ 		
		if(!$attribute_code) {
			return '';
		}
		
		$attribute = App::model('entity/attributes')->getAttributeByCode($this->getEntity()->getEntityTypeId(),$attribute_code);
		
		if(!$attribute) {
			return '';
		}
		
		$attribute->setElementAttributes($this->getElementAttrs());
		$this->setElementAttrs(array());
		
		if($attribute->getRenderer()) {						
			$block = $this->getRootBlock()->createBlock($attribute->getRenderer(),$attribute_code.'_block');
			$this->setRenderAttrs($attribute_code);
			$attribute->setEntityData($this->getUsers());
			return $block->setAttribute($attribute)->setCompany($this->getCompany())->toHtml();
		}
		if($attribute->getBackendType()) {			
			$this->setRenderAttrs($attribute_code);
			$attribute->setEntityData($this->getUsers());			
			return $attribute->renderAttribute($this->getRootBlock(),'Front');
		}
		
		return false;
	}

	public function getRenderAttrs()
	{ 
		return $this->_renderAttrs;
	}

	public function getElementAttrs()
	{
		return $this->_elementAttrs;
	}

	public function getUserGroupOptions()
	{
		$options = App::model('groups')->toOptionArray();
		return $options;
	}
	
	public function getUserProfessionOptions()
	{
		$options = App::model('profession')->toOptionArray();
		array_unshift($options,__('Select Profession')); 
		return $options;
	}
	
	public function getUserCityOptions()
	{
		$options = App::model('location/city')->toOptionArray();
		array_unshift($options,__('Select City')); 
		return $options;
	}
	
	public function getCartItems()
	{ 
		$cart = App::helper('cart')->getLastCartId();
		$cartitems = $cart->getItems();
		return $cartitems;
	}
	
	public function getAddedItems()
	{
		$cartitems = $this->getCartItems();
		$it = array();
		foreach($cartitems as $items) {			 
			$it[] = $items->getPlaceId().":".$items->getProductId();			 
		}
		return json_encode($it); 		
	}
	
	public function getUsers()
	{
		return App::registry('users');
	}
		
	public function getInsurance()
	{
		return App::model('insurance')->getAll();
	}
	
	public function getAppointments()
	{
		return App::registry('appointments');
	}
	
	public function getRotateDoctors($excludeid = array()) {
		$select = App::model('user',false)->selectAttributes(array('first_name','social_title'))
					->filter('user_id',array('not in', (array) $excludeid))
					->filter('user_type',array('=', Model_User::DOCTOR)); 
		$doctors = array();
		foreach($select->loadCollection() as $s) {
			$doctors[$s->getId()] = $s->getFullName();
		}
		return $doctors;
	}

}
