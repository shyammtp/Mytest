<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Page_Js extends Blocks_Admin_Abstract
{
    protected $_js = array();

    public function appendThemeJs($jsfile = "")
    {
        if(!$jsfile) {
            return $this;
        }
        if(is_array($jsfile)) {
            foreach($jsfile as $jfile) {
               if(!isset($this->_js[$jfile])) {
                    $this->_js[$jfile] = $this->addThemeJs($jfile);
                }
            }
        } else {
            if(!isset($this->_js[$jsfile])) {
                $this->_js[$jsfile] = $this->addThemeJs($jsfile);
            }
        }
        return $this;
    }

    public function appendJs($jsfile = "")
    {
        if(!$jsfile) {
            return $this;
        }
        if(is_array($jsfile)) {
            foreach($jsfile as $jfile) {
               if(!isset($this->_js[$jfile])) {
                    $this->_js[$jfile] = $this->addJs($jfile);
                }
            }
        } else {
            if(!isset($this->_js[$jsfile])) {
                $this->_js[$jsfile] = $this->addJs($jsfile);
            }
        }
        return $this;
    }


    public function getAdditionalJs()
    {
        $jsoutput = "";
        foreach($this->_js as $jsfile => $js)
        {
            $jsoutput .= $js ."\n";
        }
        return $jsoutput;
    }
}