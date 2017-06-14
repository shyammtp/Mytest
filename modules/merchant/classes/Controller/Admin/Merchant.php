<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Merchant extends Controller_Core_Admin {
    
	public function preDispatch()
	{
		$this->_noAccessCheckAction = array('');
		parent::preDispatch();
	}
	

	public function action_index()
	{
		$this->loadBlocks('merchant');
		$this->renderBlocks();
	}
	public function action_view()
	{		
		$this->loadBlocks('merchant');
		$id = $this->getRequest()->query('id');
		$place = App::model('core/place',false);
		if($id) {
			$place = $place->load($id,'place_index');
		}
		App::register('place',$place);
		$this->renderBlocks();
	}
     
	
}
