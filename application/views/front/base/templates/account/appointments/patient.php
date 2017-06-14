<?php $_user =  $this->getUsers();
$_receivedAppts = $this->getPatientAppointments();
$query = $this->getRequest()->query();
$totalitem = $this->_getTotalItem();
$date = Arr::get($this->getRequest()->query(),'bdt',false);
 
if($date) {
	$choosedate = date("m/d/y",strtotime($date));
	$date = date("d, M Y",strtotime($date));
}
else {
	$date = false;
	$choosedate = false;
} 
$hasReceivedappts = count($_receivedAppts) > 0 ? true: false;
?>
<div class="doctor_appointment_tab">
<h3><?php echo __('Your Booked appointments (:count)',array(':count' => $totalitem));?></h3>

<div class="appointment_btn">
	<a href="<?php echo App::helper('url')->getAccountUrl('account/appointments',Arr::merge($query,array('btype' => 'yesterday')),array('bdt'));?>" class="<?php echo  Arr::get($query,'btype') == 'yesterday'?"active":"";?>"><?php echo __('Yesterday');?></a>
	<a href="<?php echo App::helper('url')->getAccountUrl('account/appointments',Arr::merge($query,array('btype' => 'today')),array('bdt'));?>" class="<?php echo !Arr::get($query,'btype') || Arr::get($query,'btype') == 'today'?"active":"";?>"><?php echo __('Today');?></a>
	<a href="<?php echo App::helper('url')->getAccountUrl('account/appointments',Arr::merge($query,array('btype' => 'tomorrow')),array('bdt'));?>" class="<?php echo  Arr::get($query,'btype') == 'tomorrow'?"active":"";?>"><?php echo __('Tomorrow');?></a>
	<a href="<?php echo App::helper('url')->getAccountUrl('account/appointments',Arr::merge($query,array('btype' => 'date')),array('bdt'));?>" class="<?php echo  Arr::get($query,'btype') == 'date'?"active":"";?>"><?php echo __('Date');?><?php if($date):?> (<?php echo $date;?>)<?php endif;?></a>
</div>
<?php if(Arr::get($query,'btype') == 'date'):?>
<div class="appointment_calender">
			<div id="datepicker-inlinepatient"></div>		
	</div>
<?php endif;?>
<div id="booked_list">
<?php if($hasReceivedappts):?>
 <div class="general_table">
	<table cellpadding="10" cellspacing="0" border="0" width="100%">
	  <thead>
		<tr>
		  <th>#</th>
		  <th><?php echo __('Date');?></th>
		  <th><?php echo __('Appointment Reference');?></th>
		  <th><?php echo __('Patient Name');?></th>
		  <th></th>
		</tr>
	  </thead>
	  <tbody>
		<?php $sno = 1; foreach($_receivedAppts as $r):?>
		<tr>
		  <td><?php echo $sno;?></td>
		  <td><?php echo $r->getReadableTime();?></td>
		  <td><?php echo $r->getReferenceId();?></td>
		  <td><?php echo $r->getPatient()->getFullName();?></td>
		  <td>
			<a href="<?php echo App::helper('url')->getAccountUrl('account/viewappointments',array('apptid' => $r->getReferenceId()));?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="Edit"><i class="fa fa-eye"></i></a> 
		  </td>
		</tr>
		<?php $sno++; endforeach;?> 
	  </tbody>
	</table>
</div>
 <?php echo  $this->getPaging();?>
<?php else:?>
<div class="nodata_found"><?php echo __('You\'ve not booked any appointments.');?></div>
<?php endif;?>
</div>
</div>
<script>
	$(':checkbox').checkboxpicker();
	$(".inputtypes").change(function(){
		$("#setting_form").submit();
	});
	$("#datepicker-inlinepatient").datepicker({
		onSelect : function(date) {
			var url = '<?php echo App::helper('url')->getAccountUrl('account/appointments',Arr::merge($query,array('btype' => 'date')));?>&bdt='+date;
			window.location.href=url;
		}
	});
	<?php if($choosedate):?>
	//goToByScroll('booked_list');
	$("#datepicker-inlinepatient").datepicker('setDate','<?php echo $choosedate;?>')
	<?php endif;?>
</script>