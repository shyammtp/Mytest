<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Clinic_Gallery extends Blocks_Admin_Abstract
{
    public function getGalleryImages($clinic_id)
    {
        $model = DB::select('*')->from(App::model('clinic')->getTableName())
                        ->where('clinic_id','=',$clinic_id)
                        ->execute(App::model('admin/clinic')->getDbConfig());
        return $model;
    }
}
