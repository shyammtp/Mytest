<?php
$report = $this->getReport();
$reportdata = $report->getReports();
$patientreports = $report->getPatientReports();
$currenturl = $this->getUrl('report/view', array('report_id' => $report->getId()));
$isapp = $this->getRequest()->query('on_app');
$redirect = Encrypt::instance()->decode($this->getRequest()->query('redirect'));
?>
 
<div class="fixed_outer">
	<div class="fixed_inner"> 
	     <div class="report_view_box">
			<form method="post" name="lab-report" action="<?php echo $this->getUrl('report/save', $this->getRequest()->query()); ?>" accept-charset="UTF-8" enctype="multipart/form-data">
				<table width="100%" cellpadding="10" cellspacing="0" border="0">
				<tr>
					<td><h2 style="font:bold 18px arial;color:#333;"><?php echo __('Medical Report for'); ?> <?php echo $reportdata->getData('patient_name'); ?></h2></td>
				</tr> 	   
				</table>
				<table width="20%" cellpadding="10" cellspacing="0" border="0" align="right" class="export_all_box" style="display: none">
				<tr> 
					<td colspan="2" align="center"><h2 style="font:bold 18px arial;color:#333;"><?php echo __('Medical History'); ?></h2></td>	   
				</tr> 	   
				<tr>
					<td align="center"><a href="#" title=""><?php echo __('Visit reason1 with date'); ?> </a></td>
					<td align="center"><a href="#" title=""><?php echo __('Visit reason n with date'); ?></a></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
					<div class="input_fileds" style="float: none;">
						<button type="submit" class="btn btn-primary"><?php echo __('Export all'); ?></button>
					</div>
					</td>
				</tr>
				</table>
				<table width="100%" cellpadding="10" cellspacing="0" border="0" class="table_report_main">
				<tr>
					<td width="33%">
					<label><?php echo __('Mobile No'); ?> </label>	
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input  type="text" value="<?php echo Arr::get($reportdata->getData('mobile_no'), 0); ?>" name="mobile_no" value="" placeholder="<?php echo __('Enter the mobile number'); ?>" class="inv-field" />
					</div>
					</td>
					<td width="33%">
					<label><?php echo __('File No'); ?> </label>	  
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input readonly  type="text" value="<?php echo $reportdata->getData('file_no'); ?>" name="file_no" value="" placeholder="" class="inv-field" />
					</div>
					</td>	   
					<td width="33%"><label><?php echo __('Patient Name'); ?> :</label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input  type="text" value="<?php echo $reportdata->getData('patient_name'); ?>" name="patient_name" value="" placeholder="<?php echo __('Enter the patient name'); ?>" class="inv-field" />
					</div>
					</td>
				</tr>	
				<tr>
					<td><label><?php echo __('Weight'); ?> :</label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input type="text"  name="weight" value="<?php echo $reportdata->getData('weight'); ?>" placeholder="<?php echo __('Weight'); ?>" class="inv-field" />
					</div>
					</td>
					<td><label><?php echo __('Height'); ?> :</label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input type="text"  name="height" value="<?php echo $reportdata->getData('height'); ?>" placeholder="<?php echo __('Height'); ?>" class="inv-field" />
					</div>
					</td>
					<td><label><?php echo __('Age'); ?> :</label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input type="text"  name="age" value="<?php echo $reportdata->getData('age'); ?>" placeholder="<?php echo __('Age'); ?>" class="inv-field" />
					</div>
					</td>
				</tr>	
				<tr>	  
					<td>
					<label><?php echo __('Visited Date'); ?> :</label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input type="text" name="visit_date" value="<?php echo $reportdata->getData('visit_date'); ?>" placeholder="<?php echo __('Enter the date'); ?>" class="inv-field" />
					</div>
					</td>	
					<td><label><?php echo __('Date of Birth'); ?> :</label>
					<div class="input_boxes">
						<i class="fa fa-edit"></i><input type="text" name="date_of_birth"  value="<?php echo $reportdata->getData('date_of_birth'); ?>" placeholder="<?php echo __('Date of birth'); ?>" class="inv-field" />
					</div>
					</td>	   
					<td>
					<label><?php echo __('Reported Date'); ?></label>
					<div class="input_boxes">
						<i class="fa fa-edit"></i><input type="text" name="report_date" value="<?php echo $reportdata->getData('report_date'); ?>" placeholder="<?php echo __('Report Date'); ?>" class="inv-field" />
					</div>
					</td>	
				</tr>
				<tr class="tbl_radio">
					<td><label><?php echo __('Sex'); ?></label></td>
					<td><input type="radio" <?php if($reportdata->getData('sex')=='Male'){ ?> checked="checked" <?php } ?> name="sex" value="Male" /><label><?php echo __('Male'); ?></label></td>
					<td><input type="radio" <?php if($reportdata->getData('sex')=='Female'){ ?> checked="checked" <?php } ?> name="sex" value="Female" /><label><?php echo __('Female'); ?></label>		</td>
				</tr>
				<tr class="tbl_radio">
					<td><label><?php echo __('Visit Type'); ?></label> </td>
					<td><input type="radio" <?php if($reportdata->getData('visit_type')=='First time'){ ?> checked="checked" <?php } ?>  name="visit_type" value="First time" /><label><?php echo __('First time'); ?></label></td>
					<td><input type="radio" <?php if($reportdata->getData('visit_type')=='Usual'){ ?> checked="checked" <?php } ?> name="visit_type" value="Usual" /><label><?php echo __('Usual'); ?></label></td>
				</tr>
				<tr class="tbl_radio">
					<td><label><?php echo __('Patient access to see the report'); ?></label></td>
					<td><input type="radio" <?php if($reportdata->getData('report_access')=='1'){ ?> checked="checked" <?php } ?> name="report_access" value="1" /><label><?php echo __('Yes'); ?></label></td>
					<td><input type="radio" <?php if($reportdata->getData('report_access')=='0'){ ?> checked="checked" <?php } ?> name="report_access" value="0" /><label><?php echo __('No'); ?></label>		</td>
				</tr>
				<tr>
					<td valign="top" colspan="3"><label ><?php echo __('Visit Reason'); ?></label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><input type="text"  name="visit_reason" value="<?php echo $reportdata->getData('visit_reason'); ?>" placeholder="<?php echo __('Visit Reason'); ?>" class="inv-field" />
					</div>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="3"><label ><?php echo __('Clinic Diagonsis and Notes'); ?></label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><textarea rows="20" name="comments"  class="labname inv-field" placeholder="<?php echo __('Clinical Diagnosis and notes'); ?>"><?php echo $reportdata->getData('comments'); ?></textarea>
					</div>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="3"><label ><?php echo __('Prescription'); ?></label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i><textarea rows="20" name="prescription"  class="labname inv-field" placeholder="<?php echo __('Prescription'); ?>"><?php echo $reportdata->getData('prescription'); ?></textarea>
					</div>
					</td>
				</tr>
					
				<tr>
					<td valign="top" colspan="3"><label ><?php echo __('Select file'); ?></label>
					<div class="input_boxes">
						<i class="fa fa-edit" ></i>
						<div class="media-manager-sidebar">
							<div class="form-group">
							<input id="file-3" type="file" name="gallery_image" multiple=true>
							<div id="errorBlock" class="help-block"></div>
							</div>
						</div>
						<?php
						$gimages = $this->getGalleryImages($report->getId());
						foreach ($gimages as $images):
						?>
						<?php if (file_exists(DOCROOT . $images['file'])): $thumbnail = (bool) $images['thumbnail']; ?>
						<div class="image_box">
							<div class="btn-group fm-group">
							<button type="button" class="btn btn-default dropdown-toggle fm-toggle custom-drop" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu fm-menu pull-right" role="menu">
								<li><a href="<?php echo App::getBaseUrl('uploads') . $images['file']; ?>" download="<?php echo App::getBaseUrl('uploads') . $images['file']; ?>" target="_blank"><i class="fa fa-download"></i><?php echo __('Download'); ?></a></li>
								<li><a href="javascript:deleteimage('<?php echo base64_encode($images['file']); ?>','<?php echo $images['primary_id']; ?>')"><i class="fa fa-trash-o"></i> <?php echo __('Delete'); ?></a></li>
								
							</ul>
							</div><!-- btn-group -->
							
							<h5><?php echo basename($images['file']); ?></h5>
							<p><?php echo __('Added: :date', array(':date' => date("M d, Y", strtotime($images['added_on'])))); ?></p>
						</div>
						<?php endif; ?>
						<?php endforeach; ?>		

					</div>
					</td>
				</tr>	
				
				</table>
				<table width="100%" cellpadding="10" cellspacing="0" border="0" style="border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;" class="copy_rights_bottom">
				<tr>
					<td> 
					<p style="font:bold 14px arial;color:#333;"> <?php echo __('Powered by'); ?> </p></td>
					<td align="center">
					<img src="<?php echo $this->getLogo(); ?>" width="100" /></p>
					</td>
					<td align="right" width="280">
					<label style="font:bold 14px arial;color:#333;"><?php echo __('Examined and report prepared by'); ?></label>		
					</td>
					<td>
					<input type="text" name="prepared_by" value="<?php echo $reportdata->getData('prepared_by'); ?>"  class="inv-field" style="border:1px solid #ddd;width:100%;height: 50px;" />
					</td>
				</tr>
				</table>
				<table width="100%" cellpadding="10" cellspacing="0" border="0">
				<tr>
					<td align="center" > 
					<div class="input_fileds" style="float: none;">
						<!--<button type="submit" class="btn btn-primary"><?php echo __('Edit'); ?></button>-->
						<button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
						<?php if($isapp && $redirect):?>
						<a href="<?php echo $redirect;?>" style="height: 40px;padding: 0 20px;font: normal 13px/40px OpenSansSemibold;vertical-align: middle;" class="btn btn-default"><?php echo __('Cancel');?></a>
						<?php endif;?>
						<!--<button type="submit" class="btn btn-primary"><?php echo __('Export'); ?></button>-->
					</div>
					</td>
				</tr>
				</table>
			</form> 
		</div>
	</div>
</div>
<script>
    $(window).load(function(){ 
        $("#file-3").fileinput({
            showUpload: true,
            showPreview : false,
            browseLabel:'<?php echo __('Browse'); ?>',
			removeLabel : '<?php echo __('Remove'); ?>',
			uploadLabel : '<?php echo __('Upload'); ?>',
			dropZoneTitle : '<?php echo __('Drag & drop files here'); ?> &hellip;',
            browseIcon: '&nbsp;',
            browseClass: "btn btn-primary",
			cancelClass : "btn btn-primary btn-file cancelfileinputclass", 
            allowedFileExtensions : ['jpg','png','gif','jpeg','pdf','csv','xls'],
            uploadUrl: '<?php echo $this->getUrl('account/uploadgallery',array('report_id' => $report->getId()));?>',
            uploadExtraData: [
                {id: '<?php //echo $this->getUsers()->getUserId();  ?>'}
            ],
            elErrorContainer: '#errorBlock'
        });
	$('#file-3').on('filebatchuploadcomplete', function(event, data, previewId, index) {
	    console.log('Image upload complete');
	    window.location.href = '<?php echo $this->getRedirectLink(); ?>';
	    //location.reload();
	});
    });

    function deleteimage(image, id) {
	var conf = confirm("<?php echo __('Are you sure want to delete?'); ?>");
	if (conf) {
	    $.ajax ({
		url:"<?php echo $this->getUrl('account/deletegallery',array('report_id' => $report->getId()));?>",
		type:'get',
		dataType:'json',
		data: {image:image,id:id},
		success:function(jsondata) {
		    console.log(jsondata);
		    if(jsondata.success) {
			window.location.href="<?php echo $this->getRedirectLink(); ?>";
		    }
		}
	    });
	}
    }


    function setthumbnail(image, id) {
	$.ajax ({
	    url:"<?php echo $this->getPrimaryLink(); ?>",
	    type:'get',
	    dataType:'json',
	    data: {image:image,id:id},
	    success:function(jsondata) {
		if(jsondata.success) {
		    window.location.href="<?php echo $this->getRedirectLink(); ?>";
		}
	    }
	});
    }

    $(function(){

	jQuery('.thmb').hover(function() {
	    var t = jQuery(this);
	    t.find('.fm-group').show();
	}, function() {

	    var t = jQuery(this);
	    if(!t.closest('.thmb').hasClass('checked')) {
		t.find('.fm-group').hide();
	    }
	});

    });
</script>
