<?php
$_user = $this->getUsers();
$_reports = $this->getReports();
$totalitem = 0;
$query = $this->getRequest()->query();
$date = '';
$reset = $this->getRequest()->query();
if(isset($reset['pt_name'])) {
unset($reset['pt_name']);
}
 $current = $this->getUrl('',array('__current' => true));

?>

<style>
		.main-wrapper {padding:10px;}
</style>
<input type="hidden" id="rowcount" value="<?php echo $this->_totalItem;?>" />
<input type="hidden" id="pagenum" value="2" />
<div class="doctor_appointment_tab">
    <h3><?php echo __('Generated Reports', array(':count' => $totalitem)); ?></h3>
	<?php if($_user->isDoctor()):?>
	<form method="post" action="<?php echo $this->getUrl('report/search',Arr::merge($this->getRequest()->query(),array('on_app' => 1)));?>">
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
    			    <button type="button" class="btn btn-default" onclick="window.location.href='<?php echo $this->getUrl('report/user',$reset); ?>'"><?php echo __('Reset'); ?></button>
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
	    <div class="report_mobile_view">
    		
			<?php $sno = 1;
			foreach ($_reports as $r):
			$apptid = $r->getAppointment()->getReferenceId(); 
			    ?>
			    <div class="report-items"> 
				<ul>
				<li><label><?php echo __('Patient Name'); ?> : </label><span><?php echo $r->getReports()->getPatientName(); ?></span></li>
				<li><label><?php echo __('File Number'); ?> : </label> <span><?php echo $r->getReports()->getFileNo(); ?></span></li>
				<li><label><?php echo __('Visit Reason'); ?> : </label> <span><?php echo $r->getReports()->getVisitReason() ? $r->getReports()->getVisitReason() : '-'; ?></span></li>
				<li><label><?php echo __('Date'); ?> : </label> <span><?php echo date("d M Y, h:i A", strtotime($r->getReportDate())); ?></span></li>
				</ul>
				<div class="view_edit_icon">
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
				    <a href="<?php echo $this->getUrl('report/viewapp', array('report_id' => $r->getId(), 'on_app' => 1, 'user' => $_user->getId(),'redirect' => Encrypt::instance()->encode($current),'device' => $this->getRequest()->query('device'))); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('View'); ?>"><i class="fa fa-eye"></i><?php echo __('View');?></a> 
				    <?php endif;?>
				    <?php if ($_user->isDoctor()): ?>
					<?php if ($r->getReportedId() == $this->getRequest()->query('id') && $this->getRequest()->query('id') != $r->getPatientId()) { ?>
					    <a href="<?php echo $this->getUrl('report/editapp', array('report_id' => $r->getId(),'on_app' => 1,'redirect' => Encrypt::instance()->encode($current),'apptid' => $apptid)); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('Edit'); ?>"><i class="fa fa-edit"></i><?php echo __('Edit');?></a> 
					<?php } ?>
	<?php endif; ?></div>	    
				    
			    </div><?php $sno++;
    endforeach;
    ?>  
    		
    	    </div>
	</div>
	
		<div id="loadmoreres"></div>
		<span id="loader-icon" style="display: none;"><?php echo __('Loading...');?></span>
	<?php //echo $this->getPaging(); ?>
    <?php else: ?>
    <div class="nodata_found"><?php echo __('No reports found.'); ?></div>
    <?php endif; ?>
	</div>
</div> 
<script>
	$(function(){
		
		$(window).scroll(function(){ 
			if ($('body').scrollTop() == $(document).height() - $(window).height()){ 
				if($("#pagenum").val() <= '<?php echo $this->getLastPage();?>') { 
					getresult('<?php echo $this->getUrl('account/appreportajax',Arr::merge(array('red' => Encrypt::instance()->encode($current)),$this->getRequest()->query()));?>',parseInt($("#pagenum").val()));
					var pagenum = parseInt($("#pagenum").val()) + 1;
					$("#pagenum").val(pagenum);
				}
			}
		});
	})
	
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
				$(".report-items:last").after(data);
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
