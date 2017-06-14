<?php 
$apointments = $this->getAppointments();
$doctor = $apointments->getdoctor();
$patient = $apointments->getPatient();
$date = $this->getAppointments()->getReadableTime(); 
?>
<div class="fixed_outer">
	<div class="fixed_inner"> 
	   	<?php /*  <div class="report_select_box">
			<form method="post" id="rtype-form" action="<?php echo $this->getUrl('report/settype',$this->getRequest()->query());?>"> 
				<select name="report_type" class="form-control">
					<option value="1" <?php echo $this->getRequest()->query('type') == Model_Core_Report::DOCTOR_REPORT_TYPE? "selected":"";?>><?php echo __('Doctor/Clinic Report');?></option>
				<option value="2" <?php echo $this->getRequest()->query('type') == Model_Core_Report::LAB_REPORT_TYPE? "selected":"";?>><?php echo __('Lab Report');?></option>  
				</select> 
			</form>
	    </div>*/ ?>
	     <div class="report_view_box">
		<?php
			if($this->getRequest()->query('type') == Model_Core_Report::LAB_REPORT_TYPE){
				//echo $this->childView('labreport');
			}
			else {
				echo $this->childView('doctorreport');
			} 
		?>
		
	     </div>
	</div>
</div>
<script>
	$("select[name='report_type']").change(function(){
		$("#rtype-form").submit();
	})
</script>
