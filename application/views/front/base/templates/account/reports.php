<?php
$_user = $this->getUsers();
$_reports = $this->getReports(); 
$totalitem = 0;
$query = $this->getRequest()->query();
$date = '';
$user = App::model('user/session');
?>
<input type="hidden" id="rowcount" value="<?php echo $this->_totalItem;?>" />
<input type="hidden" id="pagenum" value="2" />

<div class="btn-group  input_fileds" style="margin-bottom:10px;">
		<button type="button" class="btn btn-primary" onclick="window.location.href='<?php echo App::helper('url')->getAccountUrl('account/appointments');?>'">&laquo; <?php echo __('Back to appointments');?></button>
	</div>
<div class="doctor_appointment_tab">
    <h3><?php echo __('Generated Reports', array(':count' => $totalitem)); ?></h3>
	<?php if($_user->isDoctor()):?>
	<form method="post" action="<?php echo $this->getUrl('report/search');?>">
	    <div class="general_form">
    		<ul>			
    		    <li>
    			<label><?php echo __('Patient Name'); ?></label>
    			<div class="input_fileds">
    			    <input type="text" name="patient_name" value="<?php echo $this->getRequest()->query("pt_name"); ?>" />
    			</div>
    		    </li>
    		    <li>
    			<label class="empty_label">&nbsp;</label>
    			<div class="input_fileds">
    			    <button type="submit" class="btn btn-primary"><?php echo __('Search'); ?></button>
    			    <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo App::helper('url')->getAccountUrl('account/reports'); ?>'"><?php echo __('Reset'); ?></button>
    			</div>
    		    </li>
    		    <li></li>
    		</ul>    			
    	    </div>
	</form>
	<?php endif;?>
	<div id="received_list">
    <?php if (count($_reports)): ?>
	
	<div class="Tota_reports"><?php echo $this->_totalItem;?> <?php echo __('records found');?></div>
	<div class="general_table">
	    <table cellpadding="10" cellspacing="0" border="0" width="100%">
		<thead>
		    <tr>
			<th>#</th> 
			<th><?php echo __('Patient Name'); ?></th>
			<th><?php echo __('File Number'); ?></th>
			<th><?php echo __('Visit Reason'); ?></th>
			<th><?php echo __('Date'); ?></th>
			<th align="center"><?php echo __('View');?></th>
			<?php if($_user->isDoctor()):?>
			<th align="center"><?php echo __('Edit');?></th>
			<?php endif;?>
		    </tr>
		</thead>
		<tbody id="results">
		    <?php $sno = 1;  
		    foreach ($_reports as $r):  ?>
	    	    <tr>
	    		<td><?php echo $sno; ?></td>
	    		<td><?php echo $r->getReports()->getPatientName(); ?></td>
	    		<td><?php echo $r->getReports()->getFileNo(); ?></td>
	    		<td><?php echo $r->getReports()->getVisitReason() ? $r->getReports()->getVisitReason() : '-'; ?></td>
	    		<td><?php echo date("d M Y, h:i A",strtotime($r->getReportDate())); ?></td>
	    		<td >
					<?php 
		$showview = false;			
if($_user->isDoctor()){
	if($r->getData('access') == 0) {
		$showview = true;
	}
} else {
	if($r->getData('report_access') == 1) {
		$showview = true;
	}
}
?>
<?php if($showview):?>
	    		    <a href="<?php echo $this->getUrl('report/view',array('report_id' => $r->getId())); ?>" target="_blank" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('View'); ?>"><i class="fa fa-eye"></i></a> 
	    		    <?php endif;?>
	    		</td>
	    		<?php if($_user->isDoctor()):?>
	    		<td >
					<?php if($r->getReportedId() == $user->getCustomer()->getId() && $user->getCustomer()->getId() != $r->getPatientId()){ ?>
	    		    <a href="<?php echo $this->getUrl('report/edit',array('report_id' => $r->getId(),'apptid' => $r->getAppointment()->getReferenceId())); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('Edit'); ?>"><i class="fa fa-edit"></i></a> 
	    		    <?php } ?>
	    		</td>
	    		<?php endif;?>
	    	    </tr>
	    <?php $sno++;
	endforeach; ?> 
		</tbody>
	    </table>
		<div id="loadmoreres"></div>
		<span id="loader-icon" style="display: none;"><?php echo __('Loading...');?></span>
	</div>
	<?php //echo $this->getPaging(); ?>
    <?php else: ?>
    <div class="nodata_found"><?php echo __('No reports found.'); ?></div>
    <?php endif; ?>
	</div>
</div> 
<script>
	$(function(){
		
		$(window).scroll(function(){ 
			if (isScrollIntoView('#loadmoreres')){ 
				if($("#pagenum").val() <= '<?php echo $this->getLastPage();?>') {
					getresult('<?php echo App::helper('url')->getAccountUrl('account/reportajax',$this->getRequest()->query());?>',parseInt($("#pagenum").val()));
					var pagenum = parseInt($("#pagenum").val()) + 1;
					$("#pagenum").val(pagenum);
				}
			}
		});
	});
	
	function isScrollIntoView(elem)
	{
		var $elem = $(elem);
		var $window = $(window);
	
		var docViewTop = $window.scrollTop();
		var docViewBottom = docViewTop + $window.height();
	
		var elemTop = $elem.offset().top -200;
		var elemBottom = elemTop + $elem.height();
	
		return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	}
	
	function getresult(url,pagenum) {
		$.ajax({
			url: url,
			type: "GET",
			data:  {rowcount:$("#rowcount").val(),page : pagenum},
			beforeSend: function(){
				$('#loader-icon').show();
			},
			complete: function(){
				$('#loader-icon').hide();
			},
			success: function(data){
				$("#results tr:last").after(data);
			},
			error: function(){} 	        
		});
	}
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
</script>
