<?php
$_user = $this->getUsers();
$_reports = $this->getReports(); 
$totalitem = 0;
$query = $this->getRequest()->query();
$date = '';
$user = App::model('user/session');
?>  
<?php $sno = ((Arr::get($query,'page',1)-1) * $this->getPerPage()) + 1;
	foreach ($_reports as $r):?>
		<tr>
		<td><?php echo $sno; ?></td>
		<td><?php echo $r->getReports()->getPatientName(); ?></td>
		<td><?php echo $r->getReports()->getFileNo(); ?></td>
		<td><?php echo $r->getReports()->getVisitReason() ? $r->getReports()->getVisitReason() : '-'; ?></td>
		<td><?php echo date("d M Y, h:i A",strtotime($r->getReportDate())); ?></td>
		<td >
			<a href="<?php echo $this->getUrl('report/view',array('report_id' => $r->getId())); ?>" target="_blank" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('View'); ?>"><i class="fa fa-eye"></i></a> 
		</td>
		<?php if($_user->isDoctor()):?>
		<td >
			<?php if($r->getReportedId() == $user->getCustomer()->getId() && $user->getCustomer()->getId() != $r->getPatientId()){ ?>
			<a href="<?php echo $this->getUrl('report/edit',array('report_id' => $r->getId())); ?>" data-toggle="tooltip" title="" class="tooltips" data-original-title="<?php echo __('Edit'); ?>"><i class="fa fa-edit"></i></a> 
			<?php } ?>
		</td>
		<?php endif;?>
		</tr>
<?php $sno++;
endforeach; ?> 
	