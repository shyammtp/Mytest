<?php
$_user = $this->getUsers();
$_receivedAppts = $this->getReceivedAppointments();
$query = $this->getRequest()->query();
$totalitem = $this->_getTotalItem();
$date = Arr::get($this->getRequest()->query(), 'dt', false);

if ($date) {
    $choosedate = date("m/d/y", strtotime($date));
    $date = date("d, M Y", strtotime($date));
} else {
    $date = false;
    $choosedate = false;
}
$hasReceivedappts = count($_receivedAppts) > 0 ? true : false;
?>

<div class="btn-group  input_fileds" style="margin-bottom:10px;">
		<button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo App::helper('url')->getAccountUrl('account/reports');?>'"><?php echo __('View Reports');?></button>
	</div>
<?php if ($_user->isDoctor()): ?>
<div class="doctor_appointment_tab">
    <h3><?php echo __('Your received appointments (:count)', array(':count' => $totalitem)); ?></h3>

    <div class="appointment_btn">
        <a href="<?php echo App::helper('url')->getAccountUrl('account/appointments', Arr::merge($query, array('rtype' => 'yesterday')), array('dt')); ?>" class="<?php echo Arr::get($query, 'rtype') == 'yesterday' ? "active" : ""; ?>"><?php echo __('Yesterday'); ?></a>
        <a href="<?php echo App::helper('url')->getAccountUrl('account/appointments', Arr::merge($query, array('rtype' => 'today')), array('dt')); ?>" class="<?php echo!Arr::get($query, 'rtype') || Arr::get($query, 'rtype') == 'today' ? "active" : ""; ?>"><?php echo __('Today'); ?></a>
        <a href="<?php echo App::helper('url')->getAccountUrl('account/appointments', Arr::merge($query, array('rtype' => 'tomorrow')), array('dt')); ?>" class="<?php echo Arr::get($query, 'rtype') == 'tomorrow' ? "active" : ""; ?>"><?php echo __('Tomorrow'); ?></a>
        <a href="<?php echo App::helper('url')->getAccountUrl('account/appointments', Arr::merge($query, array('rtype' => 'date')), array('dt')); ?>" class="<?php echo Arr::get($query, 'rtype') == 'date' ? "active" : ""; ?>"><?php echo __('Date'); ?><?php if ($date): ?> (<?php echo $date; ?>)<?php endif; ?></a>
    </div>
    <?php if (Arr::get($query, 'rtype') == 'date'): ?>

	<div class="appointment_calender">
	    <div id="datepicker-inline"></div>
	</div>

    <?php endif; ?>
	<div id="received_list">
    <?php if ($hasReceivedappts): ?>
	<div class="general_table">
	    <table cellpadding="10" cellspacing="0" border="0" width="100%">
		<thead>
		    <tr>
			<th>#</th>
			<th><?php echo __('Date'); ?></th>
			<th><?php echo __('Appointment Reference'); ?></th>
			<th><?php echo __('Patient Name'); ?></th>
			<th align="center"><?php echo __('View');?></th>
		    </tr>
		</thead>
		<tbody>
		    <?php $sno = 1;
		    foreach ($_receivedAppts as $r): ?>
	    	    <tr>
	    		<td><?php echo $sno; ?></td>
	    		<td><?php echo $r->getReadableTime(); ?></td>
	    		<td><?php echo $r->getReferenceId(); ?></td>
	    		<td><?php echo $r->getName(); ?></td>
	    		<td >
	    		    <a href="<?php echo App::helper('url')->getAccountUrl('account/viewappointments',array('apptid' => $r->getReferenceId())); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('Edit'); ?>"><i class="fa fa-eye"></i></a> 
	    		</td>
	    	    </tr>
	    <?php $sno++;
	endforeach; ?> 
		</tbody>
	    </table>
	</div>
	<?php echo $this->getPaging(); ?>
    <?php else: ?>
    <div class="nodata_found"><?php echo __('You\'ve not received any appointments.'); ?></div>
    <?php endif; ?>
	</div>
</div>
<?php endif; ?>
<script>
    $(':checkbox').checkboxpicker();
    $(".inputtypes").change(function(){
	$("#setting_form").submit();
    });
    $("#datepicker-inline").datepicker({
	onSelect : function(date) {
	    var url = '<?php echo App::helper('url')->getAccountUrl('account/appointments', Arr::merge($query, array('rtype' => 'date')), array('dt')); ?>&dt='+date;
	    window.location.href=url;
	}
    });
<?php if ($choosedate): ?>
	//goToByScroll('received_list');
	$("#datepicker-inline").datepicker('setDate','<?php echo $choosedate; ?>')
<?php endif; ?>
</script>
