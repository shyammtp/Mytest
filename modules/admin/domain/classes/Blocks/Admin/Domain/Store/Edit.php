<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Domain_Store_Edit extends Blocks_Admin_Abstract
{  
    public function websiteOptions()
    {
        $html = '';
        $options = App::model('core/website')->toOptionArray();
        Arr::unshift($options,'', 'Select Website'); 
        if($this->getWebsite()->getWebsiteId()) { 
            $html .= $this->getWebsite()->getName();
        } else { 
            $html .= Form::select('website_id',$options,NULL,array('class' => 'select2','id'=> 'select2','style' => 'width:100%'));
        }
        return $html;
    }
}