<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_List_Renderer_Type extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
        $html = '';
        if($row->getData('user_type') == Model_User::DOCTOR) {
            $html = 'Doctor';
        }
        if($row->getData('user_type') == Model_User::PATIENT) {
            $html = 'Patient';
        }
        $os = ($html)? $html:'--';
        return $os;
    }
 

}
