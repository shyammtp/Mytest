<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Paging extends Blocks_Front_Abstract
{
    protected $_itemPerPage = 10;
    protected $_firstPage = 1;
    protected $_lastPage;
    protected $_pagingKey = 'page';
	public function __construct()
	{
		$this->setTemplate('paging/basic');
		parent::__construct();
	}
	
	public function getPerPage()
    {
        return $this->_itemPerPage;
    }
	
	public function getLastPage()
    { 
        $this->_lastPage = ceil($this->getTotalItem()/$this->getPerPage());
        return $this->_lastPage;
    }
	
	public function setPerPage($page)
    {
        $this->_itemPerPage = $page;
        return $this;
    }
	
	public function getCurrentPage()
    {
        $currentpage = $this->getRequest()->query($this->getPagingQueryKey());
        if(!$currentpage || $currentpage < 1) {
            return $this->_firstPage;
        }
		 
        if($currentpage > $this->getLastPage()) {
            $currentpage = $this->getLastPage();
        }  
        return $currentpage;
    }
	
	public function getPageUrl(array $array)
	{
		$url = parse_url($this->curPageURL());
		parse_str(Arr::get($url,'query',''),$query);
		$finalurl = App::getBaseUrl();
		if(Arr::get($url,'path')) {
		   $finalurl .=trim(Arr::get($url,'path'),"/");
		} 
		$query = Arr::merge($query,$array);  
		$finalurl .= "?".http_build_query($query);
		return $finalurl; 
	}
	
	private function curPageURL() {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
   }
   
	public function setPagingQueryKey($key)
	{
		$this->_pagingKey = $key;
		return $this;
	}
	
	public function getPagingQueryKey()
	{
		return $this->_pagingKey;
	}

}
