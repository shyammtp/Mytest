<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Clinic_Edit extends Blocks_Store_Abstract
{
	protected $_clinic;
	
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	protected function _getClinic()
    {
		return $this->getClinic();
	}
	
	public function getClinic()
    { 
		if(!$this->_clinic){
			$this->_clinic = App::registry('clinic');
		}
		return $this->_clinic;
    }
	
	public function getGalleryImages($clinic_id)
    {
        $model = DB::select('*')->from(App::model('clinic/gallery')->getTableName())
                        ->where('clinic_id','=',$clinic_id)
                        ->order_by('added_on','desc')
                        ->execute(App::model('clinic/gallery')->getDbConfig());
		$images = array();
		foreach($model as $s) {
			$s['primary_id'] = $s['clinic_id'];			
			$images[] = $s;
		}
        return $images;
    }
	
	public function getInsurance()
	{
		return App::model('insurance')->getAll();
	}
	
	
	protected $_renderAttrs = array();
	protected $_elementAttrs = array();
	public function getEntity()
	{
		if(!$this->hasData('entity')) {
			$this->setData('entity', App::model('entity')->load(Model_Clinic::ENTITY_CODE,'entity_code'));
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
			$attribute->setEntityData($this->getClinic());
			return $block->setAttribute($attribute)->toHtml();
		}
		
		if($attribute->getBackendType()) {
			$this->setRenderAttrs($attribute_code);
			$attribute->setEntityData($this->getClinic());
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
}
