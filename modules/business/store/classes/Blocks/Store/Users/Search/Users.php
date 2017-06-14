<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_Search_Users extends Blocks_Store_Abstract
{
	public function getSearchUsersLists($keyword = '')
    { 
		$user = App::model('user',false);
        $ts = App::model('core/tags')->getTagsByKeyword($keyword,1,$user->getEntity()->getEntityTypeId());
		/*if(!isset($ts[$user->getEntity()->getEntityTypeId()])) {
			return array();
		}
		$users = $user->setTagIds($ts[$user->getEntity()->getEntityTypeId()])->getUserSearchDatas();*/
		return $ts;
	}

	public function getUser()
	{ 
		//print_r($this->getUserId());exit;
		if(!$this->getData('user')) {
			$this->setData('user',App::model('user',false)->load($this->getUserId()));
		}
		return $this->getData('user');
	}
}
