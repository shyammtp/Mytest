<?php $_user = $this->getUsers();
?>
<div class="appointment_settings">
    <form method="post" id="setting_form" action="<?php echo $this->getUrl('settings/save'); ?>">
	<ul>
	    <?php if ($_user->isDoctor()): ?>
    	    <li>
    		<div class="appointment_settings_left">
    		    <h2><?php echo __('Receive email & push notification on every appointment'); ?></h2>
    		    <p><?php echo __('You will receive an email notification as well as push notification in the app everytime when a patient books an appointment.'); ?></p>   	    
    		</div>
    		<div class="appointment_settings_right">
    		    <input type="checkbox"  value="1" class="inputtypes" <?php echo $_user->getConfig("EMAIL_APP_NOTIFICATION") == 1 ? "checked" : ""; ?> name="email_notification"/>
    		</div>
    	    </li>
    	    <li>
    		<div class="appointment_settings_left">
    		    <h2><?php echo __('Appointment status'); ?></h2>
    		    <p><?php echo __('Default accept the appointment when a patient books for it.'); ?></p>
    		</div>
    		<div class="appointment_settings_right">
    		    <input type="checkbox" value="1"  class="inputtypes" <?php echo $_user->getConfig("APPOINTMENT_ACCEPT") == 1 ? "checked" : ""; ?> name="appt_status"/>
    		</div>

    	    </li>
	    <?php else: ?>
    	    <li>
    		<div class="appointment_settings_left">
    		    <h2><?php echo __('Receive email & push notification on every appointment'); ?></h2>
    		    <p><?php echo __('You will receive an email notification as well as push notification in the app everytime you book'); ?></p>
    		</div>
    		<div class="appointment_settings_right">
    		    <input type="checkbox"  value="1" class="inputtypes" <?php echo $_user->getConfig("EMAIL_APP_NOTIFICATION") == 1 ? "checked" : ""; ?> name="email_notification"/>
    		</div>
    	    </li>
	    <?php endif; ?>
	</ul>
    </form>
</div>
<script>
    $(':checkbox').checkboxpicker({
		onLabel : '<?php echo __("Yes");?>',
		offLabel : '<?php echo __("No");?>'
		});
    $(".inputtypes").change(function(){
	$("#setting_form").submit();
    })
</script>
