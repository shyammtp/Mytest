<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Page_Head extends Blocks_Store_Abstract
{
    protected $_Css = array();

    public function appendThemeCss($cssfile = "")
    {
        if(!$cssfile) {
            return $this;
        }
        if(is_array($cssfile)) {
            foreach($cssfile as $csfile) {
               if(!isset($this->_Css[$csfile])) {
                    $this->_Css[$csfile] = $this->addThemeCss($csfile);
                }
            }
        } else {
            if(!isset($this->_Css[$cssfile])) {
                $this->_Css[$cssfile] = $this->addThemeCss($cssfile);
            }
        } 
        return $this;
    }

    public function appendCss($cssfile = "")
    {
        if(!$cssfile) {
            return $this;
        }
        if(is_array($cssfile)) {
            foreach($cssfile as $csfile) {
               if(!isset($this->_Css[$csfile])) {
                    $this->_Css[$csfile] = $this->addCss($csfile);
                }
            }
        } else {
            if(!isset($this->_Css[$cssfile])) {
                $this->_Css[$cssfile] = $this->addCss($cssfile);
            }
        }

        return $this;
    }

    public function getAdditionalCss()
    {
        $cssoutput = "";
        foreach($this->_Css as $cssfile => $css)
        {
            $cssoutput .= $css;
        }
        return $cssoutput;
    }

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
    
     public function getTitle()
    {
        return __($this->getData('title'));
    }
}
