<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Page_Sidebar extends Blocks_Store_Abstract
{
    protected $_menus;
    
    public function getMenuConfig()
    {       
        return $this->_loadMenus();
    }
    
    public function getAccess()
    {
        return array('dashboard');
    }
    
    protected function _helper()
    {
        return App::helper('store');
    }
    
    public function getLogo()
    { 
        $logo = App::getConfig('STOREADMIN_LOGO');
        if($logo && file_exists(DOCROOT.$logo)) {
            $logo = App::getBaseUrl('uploads').'cache/uploads/cache/w200/'.$logo;
        } else {
            $logo = false;
        }
        return $logo;
    }
    
    protected function _loadMenus($config = null,$path = '',$level=0)
    {
        if(is_null($config))
        {
            $config = Kohana::$config->load('storemenu');
        }
        $parentArr = array();
        
        $sortOrder = 0;
        foreach($config as $childName => $attributes)
        {
            $aclResource = $path . $childName;
            if (!$this->_checkAcl($aclResource)) {
                continue;
            }
            if (!isset($attributes['title'])) {
                continue;
            }
            
            $menuArr = array();
            $menuArr['before'] = '';
            $menuArr['after'] = '';
            $menuArr['label'] = isset($attributes['title'])?__($attributes['title']):"";
            if (isset($attributes['url'])) {
                $menuArr['url'] = $this->_helper()->getStoreUrl($attributes['url'],Arr::get($attributes,'query',array()));
            } else {
                $menuArr['url'] = '#';
                $menuArr['click'] = 'return false';
            }
            
            $menuArr['active'] = ($this->getActive()==$path.$childName)
                || (strpos($this->getActive(), $path.$childName.'/')===0);
                
            $menuArr['sort_order'] = isset($attributes['sort']) ? (int)$attributes['sort'] : $sortOrder;
            $menuArr['level'] = $level;
            if (isset($attributes['before'])) {
                $menuArr['before'] = $attributes['before']; 
            }
            if (isset($attributes['after'])) {
                $menuArr['after'] = $attributes['after']; 
            }
            if(isset($attributes['children'])) {
                $menuArr['children'] = $this->_loadMenus($attributes['children'],$path.$childName.'/',$level+1);
            }
            $parentArr[$childName] = $menuArr;

            $sortOrder++;
        }
        uasort($parentArr, array($this, '_sortMenu'));

        while (list($key, $value) = each($parentArr)) {
            $last = $key;
        }
        if (isset($last)) {
            $parentArr[$last]['last'] = true;
        }

        return $parentArr;
    }
    
    /**
     * Check is Allow menu item for admin user
     *
     * @param string $resource
     * @return bool
     */
    protected function _checkAcl($resource, $attributes = array())
    {
       // echo $child."<br/>";
        if (stripos(strtolower($resource), 'myplaces/store_') !== false) {
			if(App::hasTask('admin/modify/roleplaces')) {
				return true;
			}
		}
        if(isset($resource)) {
            if(in_array($resource,$this->getAccess())) {
                return true;
            }
            return App::model('core/acl')->checkAcl($resource);
        }
        return false;
    }
    
    protected function _sortMenu($a, $b)
    {
        return $a['sort_order']<$b['sort_order'] ? -1 : ($a['sort_order']>$b['sort_order'] ? 1 : 0);
    }
    
    /**
     * Get menu level HTML code
     *
     * @param array $menu
     * @param int $level
     * @return string
     */
    public function getMenuLevel($menu, $level = 0)
    {
        $html = '';
        foreach ($menu as $item) {
            //echo $item['label']."---".$item['active']."<br/>";
            $html .= '<li ' . (!empty($item['children']) ? 'onmouseover="$(this).addClass(\'over\')" '
                . 'onmouseout="$(this).removeClass(\'over\')"' : '') . ' class="'
                . ($item['active'] ? ' active' : '') . ' '
                . (!empty($item['children']) ? ' parent' : '')
                . (!empty($level) && !empty($item['last']) ? ' last' : '')
                . ' level' . $level . '"> <a href="' . $item['url'] . '" '
                . (!empty($item['title']) ? 'title="' . $item['title'] . '"' : '') . ' '
                . (!empty($item['click']) ? 'onclick="' . $item['click'] . '"' : '') . ' class="'
                . ($item['active']? 'active' : '') . '">'
                . $item['before']
                //. ($item['active'] ? ' <i class="selected"></i>' :'')
                . '<span class="xn-text">'
                . __($item['label']) . '</span>'
                //. (!empty($item['children']) ? '<span class="arrow '.(!$level && !empty($item['active']) ? 'open' :'').'"></span>' : '')
                . $item['after']
                .'</a>'. PHP_EOL;

            if (!empty($item['children'])) {
                $html .=  '<ul ' . (!$level ? 'id="nav"' : '') . ' class="sub-menu children">' . PHP_EOL;
                $html .= $this->getMenuLevel($item['children'], $level + 1);
                $html .= '</ul>' . PHP_EOL;
            }
            $html .= '</li>' . PHP_EOL;
        }
        return $html;
    }
    
    public function getProductsHasNoDelivery()
    {
        $product_id = DB::select(array(DB::expr('array_to_string(array_agg(pp.product_id),\',\')'),'product_id'))->from(array(App::model('product/price')->getTableName(),'pp'))
                                ->join(array(App::model('core/delivery')->getTableName(),'d'),'left')
                                ->on('d.product_id','=','pp.product_id')
                                ->on('d.place_id','=','pp.place_id')
                                ->where("pp.place_id",'=',App::instance()->getPlace()->getId())
                                ->where('d.delivery_id','is',DB::expr('null'))
                                ->execute()->get('product_id');
        return array_filter(explode(",",$product_id));
    }
    
    public function getPlaceOrder()
    {
        $orders = DB::select(array(DB::expr('array_to_string(array_agg(po.porder_id),\',\')'),'porder_id'))->from(array(App::model('sales/place_orders')->getTableName(),'po'))
                                ->join(array(App::model('sales/place_items')->getTableName(),'poi'),'inner')
                                ->on('po.porder_id','=','poi.porder_id') 
                                ->where("po.place_id",'=',App::instance()->getPlace()->getId())
                                ->where('poi.is_item_available','is',DB::expr('null'))
                                ->execute()->get('porder_id');
        
        return array_filter(explode(",",$orders));
    }
}
