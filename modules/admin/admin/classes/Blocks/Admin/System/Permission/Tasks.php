<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Block
*/
class Blocks_Admin_System_Permission_Tasks extends Blocks_Admin_System_Permission_Roles_Edit
{ 
    public function getRoleTasks()
    {
		if(!$this->hasData('db_role_tasks')) {
			$this->setData('db_role_tasks', App::model('core/role_tasks')->getTasks($this->getRequest()->query('id')));
		}		
        $taskmodel = App::model('core/tasks'); 
		$task = $taskmodel->setRoleTasks($this->getData('db_role_tasks'))->setApiResources($this->getRole()->getApi()->getResources())->optionTasks();
		return $taskmodel->getHtmlTree($task);
		
    }
}
