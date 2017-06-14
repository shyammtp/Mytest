<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_Search extends Controller_Core_Front {
	
	private $_search;
	private $_urltypes = array();
	
	protected function _initSearch()
	{
		$keyword = $this->getRequest()->param('keyword');
		if($keyword) {
			$d = App::model('core/search')->getRowByUrl($keyword);
			$this->_search = $d->getTerm(); 
		} else {
			$this->_search = $this->getRequest()->query('q'); 
		}
		
		$insu = $this->getRequest()->param('insurance');
        $insurance = App::model('insurance',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($insu,'url_key'); 
		App::register('insurance',$insurance); 
	}
	
	private function _checkUserKeyword()
	{
		$term = $this->_search;
		$session = App::model('core/session');
		$existskeyword = (array) $session->getSearchTerm();
		if(in_array($term,$existskeyword)) {
			return true;
		}
		$finalkeys = array_unique(array_merge($existskeyword, array($term)));
		$session->setDatas('search_term',$finalkeys);
		$updatedwords = (array) $session->getSearchTerm();
		return false;
	}
	
	public function action_search()
	{ 
		$this->_initSearch(); 
		$urlhelper = App::helper('url');
		$this->loadBlocks('search');
		$results = $this->getBlock('searchresults'); 
		$this->getBlock('searchbar')->setTerm($this->_search);
		$results->setTerm($this->_search); 
		$breadcrumb = $this->getBlock('breadcrumbs');
		$keyword = $this->_checkUserKeyword();
		if(!$keyword) {
			App::model('core/search')->assignPopularity($this->_search);
		}
		$breadcrumb->addCrumb('term',array('label' => $this->_search,'title' => $this->_search));  
		$this->getBlock('head')->setTitle('Search');		
		$this->renderBlocks();
		 
	}
	
	public function action_suggestions()
	{
		$result = array();
		$result = App::model('core/search')->suggestions($this->getRequest()->query('q'));
		$this->getResponse()->body(json_encode($result));
	}
	
	public function action_submitsearch()
	{
		$request = $this->getRequest();
		$url = App::getBaseUrl();
		if($insurance = $request->post('insurance')) {
			$url .= $insurance."/";
		}
		$url .= 'search/';
 		$areas = array();
		if($city = $request->post('city')) {
			App::setCity($city); 
			$citymodel = App::model('core/city',false)->load($city);
			$areas[] = $citymodel->getUrl(); 
		}
		if($area = $request->post('area')) {
			App::setArea($area); 
			$areamodel = App::model('core/area',false)->load($area);
			$areas[] = $areamodel->getUrl(); 
		}
		if(count($areas)) {
			$url .= implode("~",$areas)."/";
		}
		$url .= $request->post('type').'/';
		$url .='?q='.$request->post('keyword'); 
		$this->_redirectUrl($url);
	}
	
	public function action_area()
	{
		$areas = array();
		if($this->getRequest()->query('city_id')) {
			foreach(App::model('core/area')->getAreaByCity($this->getRequest()->query('city_id')) as $a) {
				$selected = $this->getRequest()->query('area_id') == $a->getId() ? true: false;
				$areas[] = array('name' => $a->getAreaName(),'id' => $a->getId(),'url' => $a->getUrl(),'selected' => $selected);
			}
		}
		$this->getResponse()->body(json_encode($areas));
	}
	
	public function action_linus()
	{
		$request = $this->getRequest();
		$keyword = $request->query('keyword');
		$this->_redirectUrl(App::helper('url')->getSearchKeywordUrl($keyword, $request->query('for'), $request->query('ins')));
	}
	
	public function action_ste()
	{
		exit('asdas');
	}
}
