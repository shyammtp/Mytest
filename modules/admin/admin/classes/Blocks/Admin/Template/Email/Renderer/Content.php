<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Template_Email_Renderer_Content extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {		
		return Text::limit_words(strip_tags($row->getData($this->getColumn()->getIndex())),20);
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
