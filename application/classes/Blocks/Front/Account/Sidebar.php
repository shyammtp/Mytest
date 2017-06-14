<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Account_Sidebar extends Blocks_Front_Account
{ 
    public function getCustomer()
    {
        return App::model('user/session')->getCustomer();
    }
    
    public function getMenus()
    {
        $menus = array(
            'my_requirements' => array(
                'title' => __('My Requirements'),
                'link' => $this->getUrl('account/myrequirements'),
                'sort_order' => 2,
            ),
            'my_profile' => array(
                'title' => __('My Profile'),
                'sort_order' => 1,
                'link' => $this->getUrl('account/viewprofile',array('user'=> Encrypt::instance()->encode($this->getCustomer()->getUserId()), 'mode' => 'epf')),
            ),
            'my_places' => array(
                'title' => __('My Places'), 
                'link' => $this->getUrl('account/myplaces'), 
                'sort_order' => 3,              
            ),
            /*'following_list' => array(
                'title' => __('Following List'),
                'link' => $this->getUrl('account/followinglist'),
                'sort_order' => 4,                 
            ),*/
            'my_shortlists' => array(
                'title' => __('My Shortlists'),  
                'link' => $this->getUrl('account/myshortlists'),
                'sort_order' => 5,
            ),
            'my_searchesviews' => array(
                'title' => __('My Searches'),
                'link' => $this->getUrl('account/mysearches'),  
                'sort_order' => 6,
            ), 
            'my_appointments' => array(
                'title' => __('My Appointments'),
                'link' => $this->getUrl('account/myappointments'),  
                'sort_order' => 7,
            ),
            /*'settings' => array(
                'title' => __('Settings'),  
                'link' => $this->getUrl(),
                'sort_order' => 7,
            ), 
            'notification_settings' => array(
                'title' => __('Notification Settings'),  
                'link' => $this->getUrl(),
                'sort_order' => 8,
            ),*/
            'order_history' => array(
                'title' => __('My Orders'),
                'link' => $this->getUrl('account/myorders'),  
                'sort_order' => 9,
            ), 
            'my_reviews' => array (
                'title' => __('My Reviews'),
                'link' => $this->getUrl('account/myreviews'),
                'sort_order' => 10,
            )
        );
        uasort($menus, array($this, '_sortMenu'));
        return $menus;
    }
    
    protected function _sortMenu($a, $b)
    {
        return $a['sort_order']<$b['sort_order'] ? -1 : ($a['sort_order']>$b['sort_order'] ? 1 : 0);
    }
}
