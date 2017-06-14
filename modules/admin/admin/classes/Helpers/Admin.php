<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Contains the most low-level helpers methods in Kohana:
 *
 * - Environment initialization
 * - Locating files within the cascading filesystem
 * - Auto-loading and transparent extension of classes
 * - Variable and path debugging
 *
 * @package    Kohana
 * @category   Base
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Helpers_Admin extends Kohana_Core_Object {
    
    public function getAdminUrl($path = '',$query = array(),$type = '')
    {
        $url = App::getBaseUrl($type);
        $path = trim($path,"/");
        $this->getRoutePath($path); 
        $controller = $this->getControllerName();
        $action = $this->getActionName();
        $secret = array('token' => $this->getToken($controller, $action)); 
        $query = @array_merge(array_filter($query,'strlen'),$secret); 
        $finalpath = $this->getRoutePath($path).URL::query($query,false);
        return $url.$finalpath;
    }
    
    public function getUrl($path = '',$query = array(),$type = '')
    {
        return $this->getAdminUrl($path, $query, $type);
    }
    
    protected function _getRequest()
    {
        return Request::current();
    }
    
    public function getRoutePath($path)
    { 
        if($routePath = $this->getUrlRewritePath($path)) {
            return $routePath;
        } 
        $a = explode('/', $path);
        $route = array_shift($a); 
        $routePath = $route.'/'; 
        if (!empty($a)) {
            $controller = array_shift($a);
            if ('*' === $controller) {
                $controller = Request::current()->controller();
            }
            $this->setControllerName($controller);
            $routePath .= $controller . '/';
        } 
        if (!empty($a)) {
            $action = array_shift($a); 
            if ('*' === $action) {
                $action = Request::current()->action();
            }
            $this->setActionName($action);
            $routePath .= $action . '/';
        }
        if($subfolder = App::instance()->getWebsite()->getSubfolder()) {
            $routePath = $subfolder.'/'.$routePath;
        } 
        //echo $routePath;
        return $routePath;
    }
    
    public function getUrlRewritePath($path)
    {
        $urlrewrite = App::getUrlRewrites();
        if(!array_key_exists($path,$urlrewrite)) {
            return false; 
        }
        $rewrite = $urlrewrite[$path]; 
        $parsedUrl = parse_url($rewrite['path']);
        if(isset($parsedUrl['path'])) {
            $parsedUrl['path'] = trim($parsedUrl['path'],'/');
            $a = explode('/', $parsedUrl['path']); 
            $route = array_shift($a);
            $this->setRouteName($route);
            if (!empty($a)) {
                $controller = array_shift($a);
                $this->setControllerName($controller); 
            }                
            if (!empty($a)) {
                $action = array_shift($a); 
                $this->setActionName($action); 
            }  
        }
        return $path;
    }
    
    public function getToken($controller = null, $action = null, $userid = null)
    { 
        if(!$userid) {
            $userid = App::model('admin/session')->getId();
        } 
        $key = $userid;
        if(!$controller) {
            $controller = strtolower($this->_getRequest()->controller());
        }
        if(!$action) {
            $action = strtolower($this->_getRequest()->action());
        }
        $secret = $controller . $action . $key;

        return md5($secret);
    }
    
    public function randomKey()
    {
        return Text::random();
    }
    
    public function ImageExist($oldimage,$newimage)
    { 
		if(basename($oldimage) == basename($newimage)){
				return NULL;
		}else{	
			$image = trim($oldimage,App::getBaseUrl(''));
			if($image && file_exists(DOCROOT.$image)) {
				unlink($image); 
				return NULL;
			}
		}
    }
}
