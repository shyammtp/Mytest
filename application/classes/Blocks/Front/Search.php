<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Search extends Blocks_Front_Abstract
{
	public function getCity()
	{
		$subquery = '(CASE WHEN (SELECT count(csi.city_id) AS totalcount FROM '.App::model('core/city_info')->getTableName().' AS csi WHERE csi.language_id = '.App::getCurrentLanguageId().' AND csi.city_id = main_table.city_id)>0 THEN '.App::getCurrentLanguageId().' ELSE 1 END)';
		$select = DB::select(array('ci.city_name','city_name'),'main_table.city_id','main_table.url')->from(array(App::model('core/city')->getTableName(),'main_table'))
						->join(array(App::model('core/city_info')->getTableName(),'ci'),'left')
						->on('ci.city_id','=','main_table.city_id')
						->on('ci.language_id','=',DB::expr($subquery))
						->where('country_id','=',App::instance()->getCountry()->getId())
						->where('city_status','=',1)
						->execute()
						->as_array();
		return $select;
	}
	
	public function getChoosedCity()
	{
		$area = $this->getRequest()->param('city');
		$areas = explode("~",$area);
		if(!$this->hasData('data_choosed_city')) {
			$this->setData('data_choosed_city',App::model('core/city',false)->load(Arr::get($areas,0),'url'));
		}
		return $this->getData('data_choosed_city');
	}
	
	public function getChoosedArea()
	{
		$area = $this->getRequest()->param('city');
		$areas = explode("~",$area);
		if(!$this->hasData('data_choosed_area')) {
			$this->setData('data_choosed_area',App::model('core/area',false)->load(Arr::get($areas,1),'url'));
		}
		return $this->getData('data_choosed_area'); 
	}
	
	
	public function getResults()
	{  
		$results = array();
		switch($this->getRequest()->param('type')) {
			case "doctor": 
					return $this->getRootBlock()
							->getBlock('doctors')->setCity($this->getChoosedCity())
							->setArea($this->getChoosedArea())
							->setTerm($this->getTerm())->toHtml();
				break;
			case "labs": 
					return $this->getRootBlock()
								->getBlock('labs')->setCity($this->getChoosedCity())
								->setArea($this->getChoosedArea())
								->setTerm($this->getTerm())->toHtml();
				break;
			case "hospital":
			case "pharmacy":
			case "optics":
			case "clinic": 
					return $this->getRootBlock()
							->getBlock('clinic')->setCity($this->getChoosedCity())
							->setArea($this->getChoosedArea())
							->setTerm($this->getTerm())->toHtml();
				break;
		}
		return '';
	}

}
