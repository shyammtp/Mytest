<?php defined('SYSPATH') OR die('No direct script access.');
/*
    * @Override Model
*/
class Model_Admin_Tasks extends Model_Core_Tasks {

    protected $_taskslist = array();

    public function optionTasks($tasks = null,$path = '', $level=0)
    {
        if(is_null($tasks))
            $tasks = Kohana::$config->load('tasks');
        $arr = array();
        $sortOrder = 0;
        foreach ($tasks as $taskname =>  $task) {
            $options = array();
            $options['id'] = $path.$taskname ;
            if(in_array($options['id'],$this->getRoleTasks())) {
                $options['checked'] = true;
            }
            $options['level'] = $level;
            $options['text'] = isset($task['title']) ? __($task['title']) : '';
            $options['task_note'] =  isset($task['task_note']) ? __($task['task_note']) : false;
            $options['sort_order'] = isset($task['sort']) ? (int)$task['sort'] : $sortOrder;
            $options['apiresources'] = isset($task['apiresources']) ? $task['apiresources'] : array();
            $options['index'] = false;
            if(isset($task['task_index'])) {
                $this->_taskslist[$options['id']] = $task['task_index'];
                $options['index'] = $task['task_index'];
            }
            if(isset($task['children'])) {
                $options['children'] = $this->optionTasks($task['children'], $path.$taskname."/",$level+1);
            }
            $arr[] = $options;

        }
        uasort($arr, array($this, '_sortMenu'));

        while (list($key, $value) = each($arr)) {
            $last = $key;
        }
        if (isset($last)) {
            $arr[$last]['last'] = true;
        }
        return $arr;
    }

    protected function _sortMenu($a, $b)
    {
        return $a['sort_order']<$b['sort_order'] ? -1 : ($a['sort_order']>$b['sort_order'] ? 1 : 0);
    }

    public function getTaskList()
    {
        return $this->_taskslist;
    }

    public function getRoleTasks()
    {
        if(!$this->hasData('role_tasks'))
        {
            $this->setData('role_tasks',array());
        }
        return $this->getData('role_tasks');
    }
}
