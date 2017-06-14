<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_View_Doctor extends Blocks_Front_Abstract
{
    public function getDoctor()
    {
        return App::registry('doctor');
    }
    
    
    public function getBookedAppointments()
    {
        if(!$this->hasData('booked_appointments')) {
            $model = App::model('core/appointments',false);
            $appt = $model->checkAlreadyPatientRejected(App::model('user/session')->getId(),$this->getDoctor()->getId());        
            if($appt) {
                $model->load(Arr::get($appt,'appointment_id'));
            }
            $this->setData('booked_appointments',$model);
        }
        return $this->getData('booked_appointments');
    }
    
    public function isBookedAlready()
    {
        $appt = $this->getBookedAppointments();        
        if($appt->getId()) {
            return true;
        }
        return false;
    }
}
