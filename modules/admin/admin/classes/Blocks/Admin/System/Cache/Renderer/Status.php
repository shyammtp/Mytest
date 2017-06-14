<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Cache_Renderer_Status extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {
        if($row->getData($this->getColumn()->getIndex()) == 1) {
            return '<span class="label label-success">'. __('Enabled').'</span>';
        }
        else {
            return '<span class="label label-danger">'. __('Disabled').'</span>';
        }
    }
}