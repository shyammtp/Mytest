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
class Model_Admin_Email_Subject_Label extends Model_Abstract {

    private $_languages = array();
    private $_subjectLables = array();

    public function __construct()
    {
        $this->_table = 'email_subject_info';
       // $this->_primaryKey = NULL;
        parent::__construct(); //this needs to be called mandatory after defining table and primary key
    } 

    public function getSubjectLabels($langid,$subjectId = '')
    {
        if(!isset($this->_subjectLables[$langid])) {
            $this->_subjectLables[$langid] = array();
        }
        if(empty($this->_subjectLables[$langid])) {
            $subjectLabel = DB::select('*')->from($this->getTableName())->where('language_id','=',$langid)->execute($this->getDbConfig());
            $subsL = array();
            foreach($subjectLabel as $coul) {
                $subsL[$coul['id']] = new Kohana_Core_Object($coul);
            }
            $this->_subjectLables[$langid] = new Kohana_Core_Object($subsL);
        }
        return $subjectId && isset($this->_subjectLables[$langid]) && isset($this->_subjectLables[$langid][$subjectId]) ?
                            $this->_subjectLables[$langid][$subjectId]
                            :new Kohana_Core_Object(array());
    }

}
