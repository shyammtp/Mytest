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
class Model_Admin_Session extends Model_Session_Abstract {

    const SESSION_NAMESPACE = 'admin';

    protected $_session;

    protected $_customer;

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
            $this->setDatas('id',$customer->getUserId());
            if($roleid) {
                 $this->setDatas('role_id',$roleid);
            }
        }
    }

    public function getCustomer()
    {
        if(!$this->_customer) {
            $this->_customer = App::model('user')->setLanguage(App::getCurrentLanguageId())->load($this->getId());
        }
        return $this->_customer;
    }

    public function getCustomerRoles()
    {
        return $this->getRoles();
    }

    public function logout()
    {
        App::dispatchEvent('Admin_Logout_Before',array('session' => $this));
        $this->unsetData();
        Cookie::delete('user_info');
        App::dispatchEvent('Admin_Logout_After',array('session' => $this));
        return $this;
    }
}
