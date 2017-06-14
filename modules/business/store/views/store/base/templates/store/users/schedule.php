<?php 
defined('SYSPATH') OR die('No direct script access.'); 
if($this->getUsers()->getUserId()):
$_user = $this->getUsers(); 
$_usertimings = $this->getUsers()->getTimings();
$timearray = App::model('core/timings')->getDaysWeekArray(); 
$timeerror = $this->getUsers()->getTimeError() ? $this->getUsers()->getTimeError() : array();

//$times = App::helper('time')->setTimeSets($_usertimings)->formatGroupTime();
//print_r($times);
?>
 
              
<form method="post" action="<?php echo $this->getUrl('users/settimings',$this->getRequest()->query());?>">

<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo __('Appointment duration');?></label>
	<div class="col-sm-10">
		<select name="appointment_duration" class="form-control" style="width:100%" id="appointment-duration" data-placeholder="Choose One" class="width300">
			<option value="15m" <?php echo ($_user->getAppointmentDuration() == '15m')? "selected":"";?>>15 mins</option>
			<option value="20m" <?php echo ($_user->getAppointmentDuration() == '20m')? "selected":"";?>>20 mins</option>
			<option value="30m" <?php echo ($_user->getAppointmentDuration() == '30m')? "selected":"";?>>30 mins</option>
			<option value="1h" <?php echo ($_user->getAppointmentDuration() == '1h')? "selected":"";?>>1 hour</option>
			<option value="2h" <?php echo ($_user->getAppointmentDuration() == '2h')? "selected":"";?>>2 hours</option>
		</select>
	</div>
</div>
<?php   	
 
	foreach($timearray as $key1 => $val1) { 
		 	$timest = Arr::get($_usertimings,$key1,array());
?> 
			<div id="value-<?php echo $key1;  ?>" class="row mb15">
			
			<label class="col-sm-2 pt10" for="timing_<?php echo $key1; ?>"> <input type="checkbox"  id="timing_<?php echo $key1; ?>" value='1' <?php if(Arr::get($_usertimings,$key1)) { echo "checked"; } ?> name="timing[<?php echo $key1; ?>][istrue]" > <?php echo $key1; ?>  </label>
			<div class="row"> 
				
				<div class="col-sm-2">
					 <div class="input-group mb15">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							 <div class="bootstrap-timepicker">
								<input type="text" value="<?php echo strtoupper(Arr::get($timest,'start_time_thr'));?>" name="timing[<?php echo $key1; ?>][from]" class="timepicker form-control">
							 </div>
					</div>
				</div>
				<div class="pt10 pull-left"><?php echo __('to'); ?></div>
					<div class="col-sm-2">
						<div class="input-group mb15">
							  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							  <div class="bootstrap-timepicker"> 
								<input type="text"  value="<?php echo strtoupper(Arr::get($timest,'end_time_thr'));?>" name="timing[<?php echo $key1; ?>][to]" class="timepicker form-control">
							  </div>
						</div>
					</div> 
			
				<label class="col-sm-2 pt10 second_label" for="secondshift_<?php echo $key1; ?>"> 
				
				<input type="checkbox"  id="secondshift_<?php echo $key1; ?>" value='1' <?php if(Arr::get($timest,'second_shift_status')==1) { echo "checked"; } ?> name="second_shift[<?php echo $key1; ?>][istrue]"> Second shift</label>
				<div class="col-sm-2">
					 <div class="input-group mb15">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							 <div class="bootstrap-timepicker">
								<input type="text" value="<?php echo strtoupper(Arr::get($timest,'shift_start_time_thr'));?>" name="second_shift[<?php echo $key1; ?>][from]" class="timepicker form-control">
							 </div>
					</div>
				</div>
				<div class="pt10 pull-left"><?php echo __('to'); ?></div>
					<div class="col-sm-2">
						<div class="input-group mb15">
							  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							  <div class="bootstrap-timepicker"> 
								<input type="text"  value="<?php echo strtoupper(Arr::get($timest,'shift_end_time_thr'));?>" name="second_shift[<?php echo $key1; ?>][to]" class="timepicker form-control">
							  </div>
						</div>
					</div>
			</div>
			<?php if(Arr::get($timeerror,$key1)) { ?>
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-10"><div class="error"><?php echo Arr::get($timeerror,$key1);?></div></div>
			</div>
			<?php } ?>
	</div>
<?php }  ?>

<div class="value"></div>
<button type="submit" class="btn btn-primary"><?php echo __('Save');?></button>
</form>
 <script>
	 var fields={};
	 $(function() {
		 
        // Time Picker
		$('.timepicker').timepicker({defaultTIme: false});
		
		$("#localeselect").select2();
	 });
	 
</script>


<?php else:?>
<div class="alert alert-warning">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong><?php echo __('Warning!');?></strong>
    <?php echo __('Please add doctor details first');?>
</div>
<?php endif;?>
