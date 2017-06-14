<?php defined('SYSPATH') or die('No direct script access.');

class Model_RestAPI extends Model_Abstract {
    
    protected $_query;
    protected $_dbconfig='default';
    protected $_dbquery;
	
	protected $_params = array();
	protected $_fields;
	
	protected $_columns = array();
    
    protected $_model;
	
	protected $_varNameLimit    = 'limit';
    protected $_varNamePage     = 'page';
    protected $_varNameSort     = 'sort';
    protected $_varNameDir      = 'dir';
    protected $_varNameFilter   = 'filter';
    protected $_varNameFields   = 'fields';
    protected $_currentPage   	= 1;
	
	protected $_defaultDir      = 'desc';
	protected $_itemPerPage 	= 10;
	
	protected $_totalItems 		= 0;
	
	public function __construct()
    { 
        parent::__construct(); //this needs to be called mandatory after defining table and primary key 
    }
	
	public function getDbConfig()
	{
		return $this->_dbconfig;
	}
	public function setQueryData($dbresult)
    {
        $this->_query = $dbresult;
		return $this;
    }
	
	public function getQueryData()
	{ 
		return $this; 
	}
	
	public function getVarNameFields()
    {
        return $this->_varNameFields;
    }
    
    public function getVarNameLimit()
    {
        return $this->_varNameLimit;
    }

    public function getVarNamePage()
    {
        return $this->_varNamePage;
    }

    public function getVarNameSort()
    {
        return $this->_varNameSort;
    }

    public function getVarNameDir()
    {
        return $this->_varNameDir;
    }

    public function getVarNameFilter()
    {
        return $this->_varNameFilter;
    }
	
	public function setVarNameFields($name)
    {
        return $this->_varNameFields  = $name;
    }
	
	public function setVarNameLimit($name)
    {
        return $this->_varNameLimit = $name;
    }

    public function setVarNamePage($name)
    {
        return $this->_varNamePage = $name;
    }

    public function setVarNameSort($name)
    {
        return $this->_varNameSort = $name;
    }

    public function setVarNameDir($name)
    {
        return $this->_varNameDir = $name;
    }

    public function setVarNameFilter($name)
    {
        return $this->_varNameFilter = $name;
    } 

    public function setDefaultSort($sort)
    {
        $this->_defaultSort = $sort;
        return $this;
    }

    public function setDefaultDir($dir)
    {
        $this->_defaultDir = $dir;
        return $this;
    }
	
	public function getDbResult()
    {
        return $this->_dbquery;
    }
	
	public function getParams()
	{
		return new Kohana_Core_Object($this->_params);
	}
	
	public function getOffset()
    { 
        $this->_offset  = (int) (($this->getCurrentPage() - 1) * $this->getPerPage());
        if( $this->_offset < 0) {
             $this->_offset = 0;
        }
        return  $this->_offset;
    }
	
	public function prepareQuery()
	{ 		  
		$this->_dbquery = $this->getQueryData(); 
		if($this->getDbResult()) {
             if(method_exists($this->getDbResult(),'getEntityCode')) {
                $this->setIsEntity(true);
            }
            $columnId = $this->getParams()->getData($this->getVarNameSort());  
            $dir      = $this->getParams()->getData($this->getVarNameDir());
            $filter   = $this->getParams()->getData($this->getVarNameFilter());
            $this->_itemPerPage   =  $this->getParam($this->getVarNameLimit(),$this->_itemPerPage);
            $this->_currentPage =  $this->getParam($this->getVarNamePage(),1); 
             

            if (is_string($filter)) {
                $data = $this->prepareFilterString($filter); 
                $this->_setFilterValues($data);
            }
            else if ($filter && is_array($filter)) {
                $this->_setFilterValues($filter);
            } 

			if($columnId) {
				$dir = (strtolower($dir)=='desc') ? 'desc' : 'asc';
				$this->_setQueryOrder($columnId, $dir); 
			} 
			 
        }
		return $this;
	}
	
	protected function getCurrentPage()
	{
		return $this->_currentPage;
	}
	
	protected function getPerPage()
	{
		return $this->_itemPerPage;
	}
	
	protected function _setLimit($limit)
	{
		$collection = $this->getDbResult();
		 
        if ($collection) {
			if($limit < 1) {
				return $this;
			}
            $collection->limit((int) $limit);
        }
        return $this;
	}
	
	protected function _setOffset($page,$limit)
	{
		$collection = $this->getDbResult();		
		$lastpage =  $this->_totalItems / $limit; 
        if ($collection) {
			if($limit < 1) {
				return $this;
			}
			if($page > $lastpage) {
				$page = ceil($lastpage);
			}
			$offset  =  (($page - 1) * $limit);
			if($offset<0) {
				$offset = 0;
			}
            $collection->offset($offset);
        }
        return $this;
	}
	
	protected function _setFilterValues($data)
    { 
        foreach ($data as $columnId => $value) {
			$this->_addColumnFilterToQuery($columnId,$value);
        }
        return $this;
    }
	
	protected function _addColumnFilterToQuery($column, $value='')
    {
        if ($this->getDbResult()) { 
			if($this->getIsEntity()) {
				call_user_func_array(array($this->getDbResult(),'filter'),array($column,array("=",$value)));
			} else {
				call_user_func_array(array($this->getDbResult(),'where'),array($column,"=",$value));
			} 
        }
        return $this;
    }
	
	protected function _setQueryOrder($column, $dir = 'desc')
    {
        $collection = $this->getDbResult();
        if ($collection) { 
            if($this->getIsEntity()) {
                $collection->sort($column, strtoupper($dir));
            } else {
                $collection->order_by($column, strtoupper($dir));
            }
        } 
        return $this;
    }
	
	/**
     * Decode filter string
     *
     * @param string $filterString
     * @return data
     */
    public function prepareFilterString($filterString)
    {
        $data = array();
        $filterString = base64_decode($filterString); 
        parse_str($filterString, $data);
        array_walk_recursive($data, array($this, 'decodeFilter'));
        return $data;
    }

    /**
     * Decode URL encoded filter value recursive callback method
     *
     * @param string $value
     */
    public function decodeFilter(&$value)
    {
        $value = rawurldecode($value);
    }
	
	protected function _prepareList()
    { 
		$this->_collectDbFields();
        $this->prepareQuery();
		if($this->getIsEntity()) {
			$query = clone $this->getDbResult()->getSelect(); 
			$this->_totalItems = $query->resetSelect()->resetSelect('order')->select(DB::expr('COUNT(\'*\') AS mycount'))->execute($this->getDbconfig())->get('mycount'); 
			$this->getDbResult()->limit($this->getPerPage())->offset($this->getOffset()); 
            $this->_dbquery = $this->getDbResult()->loadCollection(); 
        } else {
            if($this->getDbResult()) {

				$query = clone $this->getDbResult(); 
				$this->_totalItems = $query->resetSelect()->resetSelect('order')->select(DB::expr('COUNT(\'*\') AS mycount'))->execute($this->getDbconfig())->get('mycount');
				$limit   = $this->getParams()->getData($this->getVarNameLimit());
				$page   = $this->getParams()->getData($this->getVarNamePage());
				
				$this->_setLimit($this->getPerPage());
				$this->_setOffset($page,$this->getPerPage());
				if($limit) {
					$this->_setLimit($limit);
					if($page) {
						$this->_setOffset($page,$limit);
					}
				}
                $db = $this->getDbResult()->execute($this->getDbconfig());
                $this->_dbquery = array();
                foreach($db as $result) {
                    $this->_dbquery[] = new Kohana_Core_Object($result);
                }
				
            }
        } 
        return $this;
    }
	
	protected function _collectDbFields()
	{ 
		$this->_fields = array('*');
		if($this->getParams()->getData($this->getVarNameFields())) {
			$this->_fields = array();
			$fields = explode(",",$this->getParams()->getData($this->getVarNameFields())); 
			foreach($fields as $field) { 
				if(in_array(trim($field),$this->_allowedFields)) { 
					$this->_fields[] = trim($field);
				}
				//$this->_fields[] = trim($field);
			}
		} 
	}
	
	public function getParam($paramName, $default=null)
    {
        $session = App::model('core/session');
        $sessionParamName = $this->getId().$paramName;
        if (array_key_exists($paramName,Request::current()->query())) {
            $param = Request::current()->query($paramName); 
            return $param;
        } 

        return $default;
    }
	
	public function getTableColumns()
	{ 
		return $this->_model->loadColumns();
	}
	
	public function as_array()
	{
		$result = array();
		foreach($this->getDbResult() as $rel)
		{
			$result[] = $rel->getData();
		}
		return $result;
	}
	
	
}
