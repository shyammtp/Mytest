<div class="dashboard_categories_list">
    <ul>	
	
	<li><a href ="<?php echo $this->getUrl('clinic/index', array('type' => 1)); ?>" title="Clinics"> <span><img src="/assets/admin/base/images/icons/clinics.png" alt="" /></span><p> <?php echo(count($this->_getClinics(1))); ?></p><strong>Clinics</strong> </a></li>
	
	<li><a href ="<?php echo $this->getUrl('clinic/index', array('type' => 3)); ?>" title="Labs"> <span><img src="/assets/admin/base/images/icons/labs.png" alt="" /></span><p><?php echo(count($this->_getClinics(3))); ?></p><strong>Labs</strong> </a></li>
	
	<li><a href ="<?php echo $this->getUrl('clinic/index', array('type' => 2)); ?>" title="Hospitals"> <span><img src="/assets/admin/base/images/icons/hospitals.png" alt="" /></span><p><?php echo(count($this->_getClinics(2))); ?></p><strong>Hospitals</strong> </a></li>
	
	<li><a href ="<?php echo $this->getUrl('clinic/index', array('type' => 4)); ?>" title="Pharmacy"> <span><img src="/assets/admin/base/images/icons/parmacy.png" alt="" /></span><p><?php echo(count($this->_getClinics(4))); ?></p><strong>Pharmacy</strong> </a></li>
	
	<li><a href ="<?php echo $this->getUrl('clinic/index', array('type' => 5)); ?>" title="Optics"> <span><img src="/assets/admin/base/images/icons/optics.png" alt="" /></span><p><?php echo(count($this->_getClinics(5))); ?></p><strong>Optics</strong> </a></li>
	
	<li><a href ="<?php echo $this->getUrl('users/index', array('filter' => 'dXNlcl90eXBlPTE%3D')); ?>" title="Doctors"> <span><img src="/assets/admin/base/images/icons/Doctors.png" alt="" /></span><p><?php echo(count($this->_getDoctors())); ?></p><strong>Doctors</strong> </a></li>
	
	
	
    </ul>
</div>
