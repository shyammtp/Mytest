<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Session Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Store_Session extends Model_Session_Abstract {

    const SESSION_NAMESPACE = 'store';

    protected $_session;

    public function _construct()
    {
        parent::_construct();
        $this->init(self::SESSION_NAMESPACE);

    }

    public function setDatas($key, $value ='')
    {
        parent::setDataOnSession($key,$value);
        return $this;
    }


    public function isLoggedIn()
    {
        if($this->getId()) {
            return true;
        }
        return false;
    }

    public function generateSession($customer, $roleid = "")
    {
        if(!empty($customer)) {
            $this->setDatas('id',$customer->user_id);
            if($roleid) {
                 $this->setDatas('role_id',$roleid);
            }
        }
    }

    public function getCustomer()
    {
        if(!$this->_customer) {
            $this->_customer = App::model('user')->load($this->getId());
        }
        return $this->_customer;
    }

    public function getCustomerRoles()
    {
        return $this->getRoles();
    }

    public function logout()
    {
        $this->unsetData();
        return $this;
    }
}
