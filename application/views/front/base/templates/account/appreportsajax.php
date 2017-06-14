<?php
$_user = $this->getUsers();
$_reports = $this->getReports(); 
$totalitem = 0;
$query = $this->getRequest()->query();
$date = '';
$user = App::model('user/session');
?>  
<div class="report_mobile_view">
<?php $sno = ((Arr::get($query,'page',1)-1) * $this->getPerPage()) + 1;
	foreach ($_reports as $r):?>
    <div class="report-items">
    	<ul>
    	   <li><label><?php echo __('Patient Name'); ?>  : </label><span><?php echo $r->getReports()->getPatientName(); ?></span></li>
    	   <li><label><?php echo __('File Number'); ?> : </label><span><?php echo $r->getReports()->getFileNo(); ?></span></li>
    	   <li><label><?php echo __('Visit Reason'); ?> : </label><span><?php echo $r->getReports()->getVisitReason() ? $r->getReports()->getVisitReason() : '-'; ?></span></li>
    	   <li><label><?php echo __('Date'); ?> : </label><span><?php echo date("d M Y, h:i A", strtotime($r->getReportDate())); ?></span></li>		
    	</ul>
    	<div class="view_edit_icon">
    	    <a href="<?php echo $this->getUrl('report/viewapp', array('report_id' => $r->getId(), 'on_app' => 1, 'user' => $_user->getId(),'redirect' => $this->getRequest()->query('red'))); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('View'); ?>"><i class="fa fa-eye"></i><?php echo __('View');?></a> 
		<?php if ($_user->isDoctor()): ?>
		    <?php if ($r->getReportedId() == $this->getRequest()->query('id') && $this->getRequest()->query('id') != $r->getPatientId()) { ?>
	    	    <a href="<?php echo $this->getUrl('report/editapp', array('report_id' => $r->getId(),'on_app' => 1,'redirect' => $this->getRequest()->query('red'))); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('Edit'); ?>"><i class="fa fa-edit"></i><?php echo __('Edit');?></a> 
		    <?php } ?>
		<?php endif; ?>
    	</div>
        </div>	    
<?php $sno++;
endforeach; ?> 
</div>