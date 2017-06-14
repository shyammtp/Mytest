<?php  defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Settings_Cache extends Blocks_Admin_Abstract
{  
    
	public function getMemoryCache($type)
	{
		return $this->formatSizeUnits(App::model('core/cache_key')->getTotalMemoryCache($type));
	}
	
	protected function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = number_format($bytes,2) . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

}
