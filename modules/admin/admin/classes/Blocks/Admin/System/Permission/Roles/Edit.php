<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Roles_Edit extends Blocks_Admin_Abstract
{
    protected function _helper()
    {
        return App::helper('admin');
    }

    public function getTasks()
    {
        $task = App::model('core/tasks')->getAdminTasks();
        return $task;
    }

	public function getRole()
	{
		if(!$this->hasData('role')) {
			$this->setData('role',App::model('core/role')->load($this->getRequest()->query('id')));
		}
		return $this->getData('role');
	}

	/*
	 * This function overrided
	 */
    public function getRoleTasks()
    {
        $roletasks = App::model('core/role_tasks')->getTasks($this->getRequest()->query('id'));
        $taskmodel = App::model('core/tasks');
		$task = $taskmodel->setRoleTasks($roletasks)->toOptionArray();
        return $taskmodel->getHtmlTree($task);
    }
}
