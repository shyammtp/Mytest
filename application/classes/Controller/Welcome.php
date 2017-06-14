<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Core_Front {

	public function action_index()
	{ 
		echo "fdgd0"; exit;
		$this->forward('move');
	}

	public function action_move()
	{
		//$model = App::model('company')->setLanguage(1)->setCompanyName('testing23')->save();exit;
		$model = App::model('company')->selectAttributes('*')->filter('company_id',array('=',2));
		$model->groupByAttribute('company_id');
		//print_r($model->getSelect()->__toString()); exit;
		$s = $model->loadCollection();
		print_r($s);
		echo View::factory('profiler/stats');
	}

} // End Welcome
