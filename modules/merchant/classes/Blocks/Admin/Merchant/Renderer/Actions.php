<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Merchant_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    public function render(Kohana_Core_Object $row)
    { 
        $html = '<a class="btn btn-default btn-sm" href="'.App::helper('admin')->getUrl('admin/merchant/view',array('id' => $row->getData('place_index'))).'">View</a>'; 
        return $html;
    }
    
     

}
