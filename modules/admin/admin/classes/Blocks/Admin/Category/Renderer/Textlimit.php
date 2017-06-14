<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Renderer_Textlimit extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{

	public function render(Kohana_Core_Object $row)
    {
        $html = '';
        $limit=$this->getColumn()->getTextlimit();
        $categorylabel = App::model('core/category_label');
        foreach($this->getLanguages() as $langid => $lang) {
            $categoryLabel = $categorylabel->getCategoryLabels($langid,$row->getData($this->getColumn()->getIndex()));
            $html .= $lang['name'] .": ".(Text::limit_words($categoryLabel->getPlaceDescription(),$limit," ") ? Text::limit_words($categoryLabel->getPlaceDescription(),$limit," ") : '-');
            $html .= "<br/>";
        }
        return $html;
    }

    public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
