<?php
$report = $this->getReport();
$reportdata = $report->getReports();
$patientreports = $report->setExcludeReportId($this->getRequest()->query('report_id'))->getPatientReports();
$currenturl = $this->getUrl('report/view', array('report_id' => $report->getId()));
$isapp = $this->getRequest()->query('on_app');
$device = $this->getRequest()->query('device');
$isandroid = ($device == 'android') ? true  : false;
 $redirect = Encrypt::instance()->decode($this->getRequest()->query('redirect'));
?>
<style>    
    .main-wrapper {padding: 10px;}
</style>
<?php if (!$this->getData('only_report')): ?>
    <style type="text/css" media="print">
        .non-print {display: none;}
        #header {display: none;}
        #footer {display: none;}
    </style>
<?php endif; ?> 
<?php if($isapp):?>
<a href="<?php echo $redirect ? $redirect : $this->getUrl('report/backtopage');?>"  style="background:  #1896D0;white-space: nowrap;border-radius: 5px;padding: 10px 20px;display: inline-block;margin:10px 10px 10px 0 ;float: right;font:bold 14px arial;color:#fff;"><?php echo __('Back to Reports');?></a>
<?php endif;?>
<?php /* if ($report->getReportType() == Model_Core_Report::LAB_REPORT_TYPE): ?>

  <div class="non-print" style="border:1px solid #1896D0;border-radius: 5px;padding: 10px 20px;float: left;margin:10px;">
  <a href="javascript:;" id="print" style="font:bold 20px/20px arial;color:#1896D0;"><?php echo __('Print'); ?></a>
  </div>
  <table width="700" border="0" bgcolor="#fff" cellpadding="10" align="center" style="border:2px solid #1896D0;background: #fff;">
  <tr>
  <td align="center" colspan="3">
  <h2 style="font:bold 20px/30px arial;color:#1896D0;border-bottom: 1px solid #1896D0"> <?php echo $reportdata->getData('lab_name'); ?></h2>
  </td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Patient Name'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('patient_name'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Physician'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('physician'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Visited Date'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('visit_date'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Patient ID'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('patient_id'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Date of Birth'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('date_of_birth'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Age'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('age'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Sex'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('sex'); ?></span></td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Reported Date'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('report_date'); ?></span></td>
  </tr>
  <tr>
  <td colspan="3">
  <table width="100%" style="border:1px solid #ddd;" cellpadding="10" align="center">
  <thead>
  <tr>
  <th style="border-bottom: 1px solid #ddd;"><label style="font:bold 14px arial;color:#333;"><?php echo $reportdata->getData('heading1'); ?></label></th>
  <th style="border-bottom: 1px solid #ddd;"><label style="font:bold 14px arial;color:#333;"><?php echo $reportdata->getData('heading2'); ?></label></th>
  <th style="border-bottom: 1px solid #ddd;"><label style="font:bold 14px arial;color:#333;"><?php echo $reportdata->getData('heading3'); ?></label></th>
  <th style="border-bottom: 1px solid #ddd;"><label style="font:bold 14px arial;color:#333;"><?php echo $reportdata->getData('heading4'); ?></label></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($reportdata->getColumn() as $c): ?>
  <tr>
  <td style="border-bottom: 1px solid #ddd;"><span style="font:normal 14px arial;color:#333;"><?php echo Arr::get($c, 'column1'); ?></span></td>
  <td style="border-bottom: 1px solid #ddd;"><span style="font:normal 14px arial;color:#333;"><?php echo Arr::get($c, 'column2'); ?></span></td>
  <td style="border-bottom: 1px solid #ddd;"><span style="font:normal 14px arial;color:#333;"><?php echo Arr::get($c, 'column3'); ?></span></td>
  <td style="border-bottom: 1px solid #ddd;"><span style="font:normal 14px arial;color:#333;"><?php echo Arr::get($c, 'column4'); ?></span></td>
  </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
  </td>
  </tr>
  <tr>
  <td width="180"><label style="font:bold 14px arial;color:#333;"><?php echo __('Comments'); ?></label></td>
  <td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
  <td><span style="font:normal 14px arial;color:#333;"><?php echo $reportdata->getData('comments'); ?></span></td>
  </tr>
  <tr>
  <td align="center" colspan="2" style="border-top: 1px solid #1896D0">
  <label style="font:bold 14px arial;color:#333;"><?php echo __('Powered by'); ?> </label><img src="<?php echo $this->getLogo(); ?>" width="100" />
  </td>
  <td align="right" style="border-top: 1px solid #1896D0">
  <label style="font:bold 14px arial;color:#333;"><?php echo __('Examined and report prepared by'); ?></label>
  <br/>
  <label style="font:bold 14px arial;color:#333;"><?php echo $reportdata->getData('prepared_by'); ?></label>
  </td>
  </tr>
  </table>

  <script>
  $("#print").click(function(){
  window.print();
  })
  </script>
  <?php endif; */ ?>

<?php if (!$this->getData('only_report')): ?>
    <?php
    $historyreport = 0;
    foreach ($patientreports as $pt): if ($pt->getId() == $report->getId()) { /* continue; */
	} $historyreport++;
    endforeach;
    ?>
    <div class="non-print" style="">
		<?php if ($historyreport > 0): ?>
	    <div class="print_before_text">
        <form method="<?php if($isandroid){ ?>get<?php } else {?>post<?php } ?>" id="export_checked" action="<?php echo $this->getUrl('report/export', array('all' => 1, 'report_id' => $report->getId(), 'return' => base64_encode($currenturl))); ?>">
        <input type="hidden" name="report_id" value="<?php echo $report->getId();?>" />
        <input type="hidden" name="all" value="<?php echo 1;?>" />
        <input type="hidden" name="return" value="<?php echo base64_encode($currenturl);?>" />
        <input type="hidden" name="device" value="<?php echo $this->getRequest()->query('device');?>" />
            <div style="max-height:300px; overflow: auto;">
		<ul>
		    <?php
		    foreach ($patientreports as $pt): if ($pt->getId() == $report->getId()) { /* continue; */
			}
			?>
		    <li><input type="checkbox" name="export_check[]" value="<?php echo $pt->getId();?>" />
            <?php if($isapp):?>
            <a href="<?php echo $this->getUrl('report/viewapp',array('report_id'=> $pt->getId(),'user' => $this->getRequest()->query('user'),'on_app' => 1));?>" title=""><?php echo $pt->getReports()->getData('visit_reason') ? $pt->getReports()->getData('visit_reason') : ($pt->getReports()->getData('patient_name') ? $pt->getReports()->getData('patient_name') : $pt->getReports()->getData('file_no')); ?> on <?php echo date("d M Y,h:iA", strtotime($pt->getReportDate())); ?></a>
            <?php else:?>
            <a href="<?php echo $this->getUrl('report/view',array('report_id'=> $pt->getId()));?>" title=""><?php echo $pt->getReports()->getData('visit_reason') ? $pt->getReports()->getData('visit_reason') : ($pt->getReports()->getData('patient_name') ? $pt->getReports()->getData('patient_name') : $pt->getReports()->getData('file_no')); ?> on <?php echo date("d M Y,h:iA", strtotime($pt->getReportDate())); ?></a>
            <?php endif;?>
            
            </li>
	<?php endforeach; ?>
		</ul>
        </div>
        
		<div class="export_btn">
		   <button type="submit" class="btn btn-primary" style="background:  #1896D0;border-radius: 5px;padding:0px 20px;float: left;margin:20px 10px 10px 0px;height: 40px;font:bold 14px/40px arial;color:#fff;" href=""><?php echo __('Export Checked'); ?></button>  <?php /*  <a style="background:  #1896D0;border-radius: 5px;padding: 10px 20px;float: left;margin:10px 0;font:bold 14px arial;color:#fff;" href="<?php echo $this->getUrl('report/export', array('all' => 1, 'report_id' => $report->getId(), 'return' => base64_encode($currenturl))); ?>"><?php echo __('Export All'); ?></a> */ ?>
		</div>
        </form>
	    </div>
    <?php endif; ?>
    </div>            
<?php endif; ?>

<?php if ($report->getReportType() == Model_Core_Report::DOCTOR_REPORT_TYPE): ?>

    <?php if (!$this->getData('only_report')): ?>
	<?php if(!$isapp){?>
	<div class="non-print"  style="margin:20px auto 0 auto;max-width:600px;text-align: center;">
	    <a href="javascript:;" id="print" style="background:  #1896D0;border-radius: 5px;padding: 10px 20px;float: right;margin:10px 10px 10px 0px;font:bold 14px arial;color:#fff;"><?php echo __('Print'); ?></a>
	</div>
    <?php } ?>
    <?php endif; ?>
    <div class="main_print_table" style="float: left;margin:0 auto;width:100%;position: relative;padding-top: 4px;">
	<div style="max-width:600px;margin:0 auto;border:1px solid #1896D0;background: #fff;">
    <table width="100%" border="0"  cellpadding="0" cellspacing="0" align="center" > 
	<tr>
        <td align="center" colspan="3">
    	<h2 style="font:bold 20px/30px arial;color:#1896D0;border-bottom: 1px solid #1896D0"><?php echo __('Medical Report for'); ?> <?php echo $reportdata->getData('patient_name'); ?> <?php if ($this->getData('pdf_export')): ?><?php echo date("d, M Y h:i A", strtotime($report->getReportDate())); ?><?php endif; ?></h2>
        </td>
	</tr>
        <tr>
    	<td width="33%" valign="top" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333333;width:100%;font-family: arial;padding: 0 0 0 0;margin:0 0 0 0;"><?php echo __('Mobile Number'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('mobile_no'); ?></span>
    	</td>
    	<td width="33%" valign="top" align="left">
    	    <div  style="font-weight:bold;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo __('File No'); ?> :</div >
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('file_no'); ?></span>
    	</td>

    	<td width="33%" valign="top" align="left">
    	    <div  style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Patient Name'); ?> :</div >
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('patient_name'); ?></span>
    	</td>
        </tr>
        <tr>
    	<td valign="top" align="left">
    	    <div  style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Weight'); ?> :</div >
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('weight'); ?></span>
    	</td>
    	<td valign="top" align="left">
    	    <div  style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Height'); ?> :</div >
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('height'); ?></span>
    	</td>
    	<td valign="top" align="left">
    	    <div  style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Age'); ?> :</div >
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('age'); ?></span>
    	</td>     
        </tr>
        <tr>
    	<td valign="top" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Visited Date'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('visit_date'); ?></span>
    	</td>
    	<td valign="top" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Date of Birth'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('date_of_birth'); ?></span>
    	</td>

    	<td valign="top" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Sex'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('sex'); ?></span>
    	</td>
        </tr>
        <tr>
    	<td valign="top" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Visit Type'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('visit_type'); ?></span>
    	</td>
    	<td valign="top" align="left"> 
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Reported Date'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"><?php echo $reportdata->getData('report_date'); ?></span>
    	</td>
    	<td valign="top" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"></div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;font-family: arial;"></span>
    	</td>
        </tr>	
        <tr>
    	<td colspan="3" align="left"><div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Visit Reason'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;margin-top: 5px;font-family: arial;"><?php echo $reportdata->getData('visit_reason'); ?></span>
    	</td>	
        </tr>
        <tr>
    	<td colspan="3" align="left"><div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Clinical Diagnosis and notes'); ?> :</div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;margin-top: 5px;font-family: arial;"><?php echo $reportdata->getData('comments'); ?></span>
    	</td>   	

        </tr>
        <tr>
    	<td colspan="3" align="left">
    	    <div style="font-weight:bold;font-size: 12px;color:#333;width:100%;font-family: arial;"><?php echo __('Prescription'); ?></div>
    	    <span style="font-weight:normal;font-size: 12px;color:#333333;width:100%;margin-top: 5px;font-family: arial;"><?php echo $reportdata->getData('prescription'); ?></span>
    	</td>	
        </tr>
	<tr>
	    <td colspan="3" align="left">
		<h2 style="border-bottom: 1px solid #1896D0"></h2>
	    </td>
	</tr>
        <tr>
    	<td align="center" >
    	    <div style="font-weight:normal;font-size: 12px;color:#333333;color:#333;font-family: arial;"><?php echo __('Powered by'); ?> </div><img src="<?php echo $this->getLogo(); ?>" width="100" />
    	</td>
    	<td align="right"  colspan="2">
    	    <div style="font-weight:normal;font-size: 12px;color:#333;font-family: arial;"><?php echo __('Examined and report prepared by'); ?></div>    	    
    	    <div style="font-weight:bold;font-size: 12px;color:#333;font-family: arial;"><?php echo $reportdata->getData('prepared_by'); ?></div>         
    	</td>
        </tr>
    </table>
	</div>
    <?php $gimages = $this->getGalleryImages($report->getId()); if(count($gimages)):?>
        <div class="non-print attachment_list" style="">
	    <div class="attachment_list_inner">
            <h3><?php echo __('Attachments');?></h3>
            <ul>
                <?php foreach ($gimages as $images):?>
                    <?php if (file_exists(DOCROOT . $images['file'])): $thumbnail = (bool) $images['thumbnail']; ?>
                    <li><a href="<?php echo App::getBaseUrl('uploads') . $images['file']; ?>"  download="<?php echo App::getBaseUrl('uploads') . $images['file']; ?>" target="_blank"><?php echo basename($images['file']); ?></a></li> 
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
	    </div>
        </div>
    <?php endif;?>
    
    </div>
    
    <?php if (!$this->getData('only_report')): ?>
	<script> 
        <?php if(!$isapp):?>
	    $("#print").click(function(){
		window.print();
	    });
        <?php endif;?>
        
        $("#export_checked").submit(function(){
            var checked = $("input[name='export_check[]']:checked").length;
            if (checked <= 0) {
                alert('<?php echo __("Check any one");?>');
                return false;
            }
            return true;
        });
	</script>

    <?php endif; ?>
<?php endif; ?>
