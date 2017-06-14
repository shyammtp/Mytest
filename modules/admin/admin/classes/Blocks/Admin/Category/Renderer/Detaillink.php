<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Category_Renderer_Detaillink extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {
		
		$html = '';
		$class="";
        $categorylabel = App::model('core/category_label');
        $label =ucfirst($row->getData($this->getColumn()->getIndex()));
        foreach($this->getLanguages() as $langid => $lang) {
            $categoryLabel = $categorylabel->getCategoryLabels($langid,$row->getData($this->getColumn()->getIndex()));
            $html .= '<a '.$class.' href="'.App::helper("url")->getUrl('admin/category/categories',array('id'=>$row->getData('place_category_id'))).'" title="'.$label.'">'.$lang['name'] .": ".($categoryLabel->getPlaceName() ? $categoryLabel->getPlaceName() : '-').'</a>';
            $html .= "<br/>";
        }
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
