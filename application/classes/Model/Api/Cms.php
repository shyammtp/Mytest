<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Cms extends Model_RestAPI {
	
	public function getPage()
	{
		$content = App::model('cms/cms_blocks',false)->setBlockIdentifier(Arr::get($this->params,'page'))->getContent();
		return array('content' => $content);
	}
}	
