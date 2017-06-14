<?php 
$apointments = $this->getAppointments();
if($apointments->isReceived()){
echo $this->childView('receivedAppointments');
}

if($apointments->isBooked()){
echo $this->childView('bookedAppointments');
}
?>


