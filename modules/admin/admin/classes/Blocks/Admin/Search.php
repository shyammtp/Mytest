<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Search extends Blocks_Admin_Abstract
{
    public function getTags()
    {
        $ts = App::model('core/tags')->getTagsByKeyword($this->getRequest()->query('q'));
        $tags = array(); 
        foreach($ts as $entity => $tagids) {
            $entityModel = App::model('entity',false)->load($entity);
            $model = App::model($entityModel->getEntityModel())->setTagsIds($tagids);
            if(method_exists($model, 'getTagsDatas')) {
                $tags[$entity] = $model->getTagsDatas();
            }
        }
        $config = Kohana::$config->load('tags');
        $tagset = $config->get('admintags');
        $i = 1;
        $totalset = 5;
        foreach($tagset as $id => $set) {
            if(isset($set['task']) && !App::hasTask($set['task'])) {
                continue;
            } 
            if(!isset($set['tag'])) {
                continue;
            }
            if($totalset == $i-1) {
                break;
            }
            if (strpos($set['tag'],strtolower($this->getRequest()->query('q'))) !== false) {
                $tags['static'.$i][$id] = $set;
                $i++;
            }
        }
        App::model('sales')->getTagDatas($tags,$this->getRequest()->query('q'));
        return $tags;
    }
}
