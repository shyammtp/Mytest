<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Page_Sidebar extends Blocks_Admin_Abstract
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
        return App::helper('admin');
    }

    protected function _loadMenus($config = null,$path = '',$level=0)
    {
        if(is_null($config))
        {
            $config = Kohana::$config->load('adminmenu');
        }
        $parentArr = array();

        $sortOrder = 0;
        foreach($config as $childName => $attributes)
        {
            $aclResource = $path . $childName;

            /*if (!$this->_checkAcl($aclResource)) {
                continue;
            }*/
    
            $menuArr = array();
            $menuArr['before'] = '';
            $menuArr['after'] = '';
            $menuArr['label'] = __($attributes['title']);
            if (isset($attributes['url'])) {
               
                $menuArr['url'] = $this->_helper()->getAdminUrl($attributes['url'],Arr::get($attributes,'url_query',array()));
            } else {
                $menuArr['url'] = '#';
                $menuArr['click'] = 'return false';
            }
            //$menuArr['s']= $this->getActive()."--".$path.$childName;
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
        //print_r($parentArr);
        uasort($parentArr, array($this, '_sortMenu'));

        while (list($key, $value) = each($parentArr)) {
            $last = $key;
        }
        if (isset($last)) {
            $parentArr[$last]['last'] = true;
        }

        return $parentArr;
    }

    protected function _getRoleTasksModel()
    {
        return App::model('core/role_tasks');
    }


    /**
     * Check is Allow menu item for admin user
     *
     * @param string $resource
     * @return bool
     */
    protected function _checkAcl($resource, $attributes = array())
    {
        
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
                . '<span>'
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
}
