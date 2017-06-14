<?php 
$apointments = $this->getAppointments();
$doctor = $apointments->getdoctor();
$patient = $apointments->getPatient();
$date = $this->getAppointments()->getReadableTime();
$reload = true;
?>
<?php if($apointments->getReportMessage()):?>
	<div class="report_state_message"> 
		<?php echo $apointments->getReportMessage();?>
	</div> 
<?php endif;?>
<div class="appointment_details">
    <div class="apointment_top_part">
	<div class="appointment_detail_daybox">
	    <span class="c_month" ><?php echo $apointments->getReadableTime('M'); ?></span>
	    <span class="c_date"><?php echo $apointments->getReadableTime('d'); ?></span>
	    <span class="c_day"><?php echo $apointments->getReadableTime('D'); ?></span>
	</div>
	<div class="appointment_top_right">
	   <h2><?php echo __('You\'ve booked an appointment with :name on :date',array(':name' => $doctor->getFullName(), ':date' => $date));?> (#<?php echo $apointments->getReferenceId();?>)</h2>
	    <?php if ($doctor->getVenue()): ?><p> at <?php echo $doctor->getVenue();?></p><?php endif;?>
	</div>
	<?php if($apointments->isClosed()):?>
	<div class="appointment_closed_icon"> 
		<div class="closed_state_message">
			<?php echo __('This appointment is Closed.');?>
		</div> 
	</div>
	<?php endif;?> 
    </div>
    <div class="apointment_mid_box">
	<h2><?php echo __('Appointment fixed with');?> <?php echo $doctor->getFullName(); ?>.</h2>
	<h3>@ <?php echo $date;?></h3>
	<?php if($doctor->getVenue()):?>
	<h4><?php echo $doctor->getVenue();?></h4>
	<?php endif;?>
	<ul>
	   <li><label><?php echo __('When');?></label><span><?php echo $date; ?></span></li>
	    <li><label><?php echo __('Where');?></label><span><?php echo $doctor->getVenue() ? $doctor->getVenue() : "-"; ?></span></li>
	    <li><label><?php echo __('Patient Name');?></label><span><?php echo $apointments->getName();?></span></li>
	    <li><label><?php echo __('Details');?></label><span><?php echo $apointments->getComments();?></span></li>	          
	</ul>
    </div>
	
	<?php if(!$apointments->isClosed()):?>
    <div class="apointment_botom_form">
	<ul class="state_check">  
	    <li>
		<div class="box state_box">
		    <div class="apointment_botom_left">
			<div class="apointment_botom_title"><?php echo __('Edit'); ?></div>
			<p><?php echo __('Editing this appointment time will modify on the doctor end');?></p>
		    </div>
		    <div class="apointment_botom_right">
			<div class="rdio rdio-primary">
			    <input type="radio" name="astate" value="edit"> 
			</div>
		    </div>				
		    <div class="body-cont" style="display: none;">
<?php echo $this->childView('bookappointment', array('doctor' => $doctor,'apptid' => $apointments->getReferenceId(),'name_value' => $apointments->getName(),'comment_value' => $apointments->getComments(),'reload' => $reload)); ?>
		    </div>
		</div>
	    </li>
	</ul>
	    
    </div>
	<?php endif;?>
	
    <!--<div class="apointment_botom_form">
	<div class="general_form">
	<form>
	    <ul>
		<li><label>Select</label><div class="input_fileds"><select><option></option></select></div></li>
		<li><label class="empty_label">&nbsp;</label><div class="input_fileds"><input type="submit" /></div></li>
	    </ul>
	</form>
	</div>
    </div>-->
</div>
<script>
	function radioelementclick(ele) {
		
		$(".type_dyna").val(0);
		$(".body-cont").hide();
		var val = ele.val(); 
		if (val == 'edit') { 
			ele.parents('.state_box').find('.body-cont').fadeIn();
		} 
	}
	$("input[name='astate']").click(function(){
		radioelementclick($(this));
		
	});
</script>