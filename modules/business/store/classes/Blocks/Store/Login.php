<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Login extends Blocks_Store_Abstract
{
    public function getSwitchAccountDatas()
    {
        $qdata = array();
        if($querys = $this->getRequest()->query('_stl')) {
            $decrypt = Encrypt::instance()->decode(base64_decode($querys));
            parse_str($decrypt,$qdata);
        }
        return new Kohana_Core_Object($qdata);
    }
}