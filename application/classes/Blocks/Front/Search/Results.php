<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Search_Results extends Blocks_Front_Abstract
{
    private $_totalItem = 0;
	private $_collection;
	public function _getTotalItem()
    { 
        if(!$this->_totalItem) { 
			$pagination_query = clone $this->_collection->getSelect();
            $q =  $pagination_query->resetSelect()->resetSelect('order')->select(DB::expr('COUNT(*) AS mycount'))->execute()->current();
			$this->_totalItem = Arr::get($q,'mycount',0); 
        }
        return $this->_totalItem;
        
    }
	
	public function getAreas()
	{
		if(!$this->hasData('areas')) {
			$area = $this->getRequest()->param('city');
			$areas = explode("~",$area);
			$this->setData('areas',$areas);
		}
		return $this->getData('areas');
	}
	
	public function getCity()
	{
		if(!$this->hasData('city')) {
			$areas = $this->getAreas();
			$this->setData('city',App::model('core/city')->load(Arr::get($areas,0),'url'));
		}
		return $this->getData('city');
	}
	
	public function getArea()
	{
		if(!$this->hasData('area')) {
			$areas = $this->getAreas();
			$this->setData('area', App::model('core/area')->load(Arr::get($areas,1),'url'));
		}
		return $this->getData('area');
	}
	
	public function getAreaText()
	{
		$cityname = $this->getCity()->getCityName();
		$areaname = $this->getArea()->getAreaName();
		$text = array();
		if($areaname) 
			$text[] = $areaname;
		if($cityname)
			$text[] = $cityname;
		if(!count($text)) {
			$text[] = App::instance()->getCountry()->getCountryName();
		}
		return implode(", ",$text);
	}
	
	public function setCollection($collection)
	{
		$this->_collection = $collection;
		$this->_getTotalItem();
		return $this;
	}
	
	public function getTotal()
	{
		return $this->_totalItem;
	}
	
	public function getPerPage()
	{
		return Arr::get($this->getRequest()->query(),'limit',10);
	}
	
    public function getLastPage()
    { 
        $this->_lastPage = ceil($this->getTotal()/$this->getPerPage());
        return $this->_lastPage;
    }
	
	public function getPaging()
	{
		$block = $this->getRootBlock()->createBlock('Front/Paging','pagination');
		$block->setCollection($this->_collection)
			->setTotalItem($this->getTotal())
			->setPerPage($this->getPerPage());
		return $block->toHtml();
	}
	
	public function getCurrentPage()
    {
        $currentpage = Arr::get($this->getRequest()->query(),'page',1);
        if(!$currentpage || $currentpage < 1) {
            return $this->_firstPage;
        }
		 
        if($currentpage > $this->getLastPage()) {
            $currentpage = $this->getLastPage();
        }  
        return $currentpage;
    }
}
