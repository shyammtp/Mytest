<?php $_user = $this->getUser(); ?>


    <div class="fixed_outer">
	<div class="fixed_inner">
	    <div class="doctor_menu">
		<a href="javascript:;" title="Menu" class="profile_menu"><?php echo __('Edit Profile'); ?></a>
	    <?php if ($_user->isDoctor()): ?>
    	    <ul>
    		<li class="<?php echo $this->getActive()=="edit"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/edit'); ?>"><i class="fa fa-user"></i><?php echo __('Edit Profile'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="appointments"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/appointments'); ?>"><i class="fa fa-thumb-tack"></i><?php echo __('Appointments'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="timings"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/timings'); ?>"><i class="fa fa-clock-o"></i><?php echo __('Timings'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="photos"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/media'); ?>"><i class="fa fa-image"></i><?php echo __('Photos and Videos'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="settings"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/settings'); ?>"><i class="fa fa-gears"></i><?php echo __('Settings'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="generate_report"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/generatereport'); ?>"><i class="fa fa-file"></i><?php echo __('Generate Report'); ?></a></li>
    	    </ul>
	    <?php else: ?>
    	    <ul>
            <li class="<?php echo $this->getActive()=="edit"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/edit'); ?>"><i class="fa fa-user"></i><?php echo __('Edit Profile'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="appointments"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/appointments'); ?>"><i class="fa fa-thumb-tack"></i><?php echo __('Appointments'); ?></a></li>
    		<li class="<?php echo $this->getActive()=="settings"? "active":"";?>"><a href="<?php echo App::helper('url')->getAccountUrl('account/settings'); ?>"><i class="fa fa-gears"></i><?php echo __('Settings'); ?></a></li>
    	    </ul>
	    <?php endif; ?>
	</div>
	    <script type="text/javascript">
		$(document).ready(function(){
		    $('.profile_menu').click(function(){
			$('.doctor_menu ul').toggle();
		    });
		    
		});
	    </script>
    </div>
</div>
