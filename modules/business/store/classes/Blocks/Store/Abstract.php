<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Abstract extends Blocks_Core
{
    
    public function getUrl($path = '',$query = array())
    {
        if(isset($query['__current']) && $query['__current'])
        {
            unset($query['__current']);
            $path = Request::detect_uri();
            $query = Arr::merge($this->getRequest()->query(),$query);
            return App::helper('store')->getStoreUrl($path,$query);
        }
        return App::helper('store')->getStoreUrl($path,$query);
    }
     
}
