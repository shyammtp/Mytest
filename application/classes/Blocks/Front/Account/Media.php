<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Media extends Blocks_Front_Abstract
{
    public function getUsers()
    {
        return App::registry('users');
    }
    
    public function getGalleryImages($user_id)
    {
        $model = DB::select('*')->from(App::model('user/gallery')->getTableName())
                        ->where('user_id','=',$user_id)
                        ->order_by('added_on','desc')
                        ->execute(App::model('user/gallery')->getDbConfig());
						
		$images = array();
		foreach($model as $s) {
			$s['primary_id'] = $s['user_id'];			
			$images[] = $s;
		}
        return $images;
    }
}
