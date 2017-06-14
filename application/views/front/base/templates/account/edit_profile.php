<?php
$_user = $this->getUsers();
if($_user->isDoctor()){
	echo $this->childView('doctorprofilepage');
}else{
	echo $this->childView('patientprofilepage');
}
?>
<div class='change_pass'>
	
<a href="<?php echo App::helper('url')->getAccountUrl('account/changepassword'); ?>"><?php echo __('Change Password'); ?></a>
</div>
