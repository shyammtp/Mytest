<?php
defined('SYSPATH') OR die('No direct script access.');
$_user = $this->getUsers();
$_usertimings = $this->getUsers()->getTimings();
$timearray = App::model('core/timings')->getDaysWeekArray();
$timeerror = $this->getUsers()->getTimeError() ? $this->getUsers()->getTimeError() : array();

?>
<?php if($_user->isSubscribed() && $_user->isExpiredSubscription()):?>
	<div class="alert alert-info">
		<h4 style="font: normal 14px/32px OpenSansSemibold;"><?php echo __('Info:');?></h4>  
			<p style="font: normal 13px/20px OpenSansRegular;"><?php echo __('Your subscription has been expired. You will not be included in our search index and patient cannot book an appointment until it has been renewed. Please contact the administrator.');?></p> 
		<div class="input_fileds" style="margin-top:10px;">
			<a  style="font: normal 13px/28px OpenSansRegular;" href="<?php echo $this->getUrl('contactus');?>" class="btn btn-primary"><?php echo __('Contact us');?></a>
		</div>
		<div class="clearfix"></div>
	</div>
<?php endif;?>
<?php if(!$_user->isSubscribed()):?>
	<div class="alert alert-info">
		<h4 style="font: normal 14px/32px OpenSansSemibold;"><?php echo __('Info:');?></h4>
		<p  style="font: normal 13px/20px OpenSansRegular;"><?php echo __('You have not subscribed with us yet. You will not be included in our search index and patient cannot book an appointment until it has been subscribed. Please contact the administrator.');?></p>
		<div class="input_fileds" style="margin-top:10px;">
			<a  style="font: normal 13px/28px OpenSansRegular;" href="<?php echo $this->getUrl('contactus');?>" class="btn btn-primary"><?php echo __('Contact us');?></a>
		</div>
		<div class="clearfix"></div>
	</div>
<?php endif;?>
<div class="timing_page">
    <form method="post" action="<?php echo $this->getUrl('settings/settimings', $this->getRequest()->query()); ?>" id="timingform">
	<div class="general_form">
	    <ul>
		<li>
		    <label><?php echo __('Appointment duration'); ?></label>
		    <div class="input_fileds">
			<select name="appointment_duration" class="form-control" id="appointment-duration" data-placeholder="<?php echo __('Choose One'); ?>" >
			    <option value="15m" <?php echo ($_user->getAppointmentDuration() == '15m') ? "selected" : ""; ?>><?php echo __('15 mins'); ?></option>
			    <option value="20m" <?php echo ($_user->getAppointmentDuration() == '20m') ? "selected" : ""; ?>><?php echo __('20 mins'); ?></option>
			    <option value="30m" <?php echo ($_user->getAppointmentDuration() == '30m') ? "selected" : ""; ?>><?php echo __('30 mins'); ?></option>
			    <option value="1h" <?php echo ($_user->getAppointmentDuration() == '1h') ? "selected" : ""; ?>><?php echo __('1 hour'); ?></option>
			    <option value="2h" <?php echo ($_user->getAppointmentDuration() == '2h') ? "selected" : ""; ?>><?php echo __('2 hours'); ?></option>
			</select>
		    </div>
		</li>
		<?php
		foreach ($timearray as $key1 => $val1) {
		    $timest = Arr::get($_usertimings, $key1, array());
		    ?> 
    		<li id="value-<?php echo $key1; ?>">
    		    <div for="timing_<?php echo $key1; ?>">
			<div class="checkbox checkbox-primary stylish_input_box"><input type="checkbox" class="styled styled-primary"  id="timing_<?php echo $key1; ?>" value='1' <?php
			 if (Arr::get($_usertimings, $key1)) { echo "checked";}?> name="timing[<?php echo $key1; ?>][istrue]" ><label></label>
			 <span class="label_span"><?php echo __($key1); ?> </span>
			</div></div>
    		    <div class="input_fileds timing_fileds">
			<div class="small_time_fileds">
    			<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    			<div class="bootstrap-timepicker">
    			    <input type="text" value="<?php echo strtoupper(Arr::get($timest, 'start_time_thr')); ?>" name="timing[<?php echo $key1; ?>][from]" class="timepicker form-control">
    			</div>
			</div>
    			<span class="label_span mt10"><?php echo __('to'); ?></span>
			<div class="small_time_fileds">
    			<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    			<div class="bootstrap-timepicker"> 
    			    <input type="text"  value="<?php echo strtoupper(Arr::get($timest, 'end_time_thr')); ?>" name="timing[<?php echo $key1; ?>][to]" class="timepicker form-control">
    			</div> 
			</div>
    			<div class="second_label " for="secondshift_<?php echo $key1; ?>"> 
			    <div class="checkbox checkbox-primary stylish_input_box">
    				<input type="checkbox" class="styled styled-primary"  id="secondshift_<?php echo $key1; ?>" value='1' <?php
    if (Arr::get($timest, 'second_shift_status') == 1) {
	echo "checked";
    }
    ?> name="second_shift[<?php echo $key1; ?>][istrue]"><label></label>
    				<span class="label_span"><?php echo __('Second shift'); ?></span>
    			    </div> 
			<div class="small_time_fileds">
    			<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    			<div class="bootstrap-timepicker">
    			    <input type="text" value="<?php echo strtoupper(Arr::get($timest, 'shift_start_time_thr')); ?>" name="second_shift[<?php echo $key1; ?>][from]" class="timepicker form-control">
    			</div>
			</div>
			    <span class="label_span mt10"><?php echo __('to'); ?></span>
			<div class="small_time_fileds">
    			<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
    			<div class="bootstrap-timepicker"> 
    			    <input type="text"  value="<?php echo strtoupper(Arr::get($timest, 'shift_end_time_thr')); ?>" name="second_shift[<?php echo $key1; ?>][to]" class="timepicker form-control">
    			</div>
			</div>
    		    </div>
			<?php if (Arr::get($timeerror, $key1)) { ?>
			   <div class="timing_error"><?php echo Arr::get($timeerror, $key1); ?></div>
			<?php } ?>
    		</li>
		<?php } ?>
		<div class="value"></div>
		<li>
		    <label class="empty_label"></label>
		    <div class="input_fileds">
			<button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
		    </div>
		</li>
	    </ul>
	</div>
    </form>
</div>
<script>
    var fields={};
    $(function() {
	// Time Picker
	$('.timepicker').timepicker({defaultTIme: false});
	$("#localeselect").select2();
	$("#timingform").submit(function(){
		alert('<?php echo __("Changing your timings will affect only to the future appointments.");?>');
	});
    });
</script>
