<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Renderer_Username extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {		
		$html = '';
		$class="";    
		
		$users = explode(',',$row->getFrom());		
		foreach($users as $user) {
			$usermodel = App::model('user',false)->selectAttributes('*')->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->load($user);	
			$userlist[] =  $usermodel->getData('first_name');
		}
		$html = implode(',',$userlist);
		        
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
