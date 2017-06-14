<?php 
defined('SYSPATH') OR die('No direct script access.'); 
if($this->getClinic()->getId()):
$_clinic = $this->getClinic(); 
$_usertimings = $_clinic->getTimings(); 
$timearray = App::model('core/timings')->getDaysWeekArray(); 
$timeerror = $_clinic->getTimeError() ? $_clinic->getTimeError() : array();
//$times = App::helper('time')->setTimeSets($_usertimings)->formatGroupTime(); 
?>
 
              
<form method="post" action="<?php echo $this->getUrl('clinic/settimings',$this->getRequest()->query());?>">
 
<?php   	
 
	foreach($timearray as $key1 => $val1) { 
		 	$timest = Arr::get($_usertimings,$key1,array());
?> 
			<div id="value-<?php echo $key1;  ?>" class="row mb15">
			
			<label class="col-sm-2 pt10" for="timing_<?php echo $key1; ?>"> <input type="checkbox"  id="timing_<?php echo $key1; ?>" value='1' <?php if(Arr::get($_usertimings,$key1)) { echo "checked"; } ?> name="timing[<?php echo $key1; ?>][istrue]" > <?php echo $key1; ?>  </label>
			<div class="row"> 
				
				<div class="col-sm-3">
					 <div class="input-group mb15">
							<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							 <div class="bootstrap-timepicker">
								<input type="text" value="<?php echo strtoupper(Arr::get($timest,'start_time_thr'));?>" name="timing[<?php echo $key1; ?>][from]" class="timepicker form-control">
							 </div>
					</div>
				</div>
				<div class="pt10 pull-left"><?php echo __('to'); ?></div>
					<div class="col-sm-3">
						<div class="input-group mb15">
							  <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							  <div class="bootstrap-timepicker"> 
								<input type="text"  value="<?php echo strtoupper(Arr::get($timest,'end_time_thr'));?>" name="timing[<?php echo $key1; ?>][to]" class="timepicker form-control">
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
		 
	 });
	 
</script>


<?php else:?>
<div class="alert alert-warning">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong><?php echo __('Warning!');?></strong>
    <?php echo __('Please add :place_name details first',array(':place_name' => App::registry('place_name')));?>
</div>
<?php endif;?>
