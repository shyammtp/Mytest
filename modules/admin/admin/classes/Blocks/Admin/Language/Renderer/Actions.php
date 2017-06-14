<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Language_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
		if(App::hasTask('admin/settings/edit_language')){
        $html = '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('admin/settings/edit_language/',array('id' => $row->getData('language_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
                                      </div>';
        return $html;
		}
    return '--';
    }

}
