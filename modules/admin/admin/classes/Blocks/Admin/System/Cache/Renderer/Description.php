<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Cache_Renderer_Description extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {
        $info = App::model('core/cache')->informations;
        if(isset($info[$row->getData($this->getColumn()->getIndex())]))
        {
            return $info[$row->getData($this->getColumn()->getIndex())]['description'];
        }
        return '';
    }
}