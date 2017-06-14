<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Domain_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    
    public function render(Kohana_Core_Object $row)
    {

        $html = '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('domain/list/edit',array('id' => $row->getData('website_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
                                      </div>';
        return $html;
    }


}
