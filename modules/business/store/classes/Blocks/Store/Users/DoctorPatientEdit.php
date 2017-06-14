<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_DoctorPatientEdit extends Blocks_Store_Abstract
{
	protected $_renderAttrs = array();
	protected $_elementAttrs = array();
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
			return $attribute->renderAttribute($this->getRootBlock(),'Store');
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
	
}
