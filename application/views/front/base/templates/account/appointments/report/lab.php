<?php 
$apointments = $this->getAppointments();
$doctor = $apointments->getdoctor();
$patient = $apointments->getPatient();
$date = $this->getAppointments()->getReadableTime(); 
?>



<form method="post" name="lab-report" action="<?php echo $this->getUrl('report/save',$this->getRequest()->query());?>">
     <div class="table_left_algin">
    <table width="100%" cellpadding="10" cellspacing="0" border="0">
	<tr>
	    <td width="100%" valign="top">
		<textarea rows="6" name="lab_name" class="labname inv-field" style="" placeholder="<?php echo __('Enter the lab details (name, address)');?>"></textarea>
	    </td>	   
	</tr>	
    </table>
     </div>
    <div class="table_right_algin">
    <table width="100%" cellpadding="5" cellspacing="0" border="0" valign="top" align="right" class="table_report_main">
		    <tr>
			<td width="150"><label><?php echo __('Patient Name');?></label></td>
			<td width="5"><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input  type="text" value="<?php echo $apointments->getName();?>" name="patient_name" value="" placeholder="<?php echo __('Enter the patient name');?>" class="inv-field" /></td>
		    </tr>
		    <tr>
			<td><label><?php echo __('Physician');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input type="text" name="physician" value="" placeholder="<?php echo __('Enter the physician');?>" class="inv-field" /></td>
		    </tr>
		    <tr>
			<td><label><?php echo __('Visited Date');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input type="text" name="visit_date" value="<?php echo $apointments->getReadableTime();?>" placeholder="<?php echo __('Enter the date');?>" class="inv-field" /></td>
		    </tr>
		    <tr>
			<td><label><?php echo __('Patient Name');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input type="text" value="<?php echo $apointments->getName();?>" name="patient_name" value="" placeholder="<?php echo __('Enter the patient name');?>" class="inv-field" /></td>
		    </tr>
		     <tr>
			<td><label><?php echo __('Patient ID');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input type="text" name="patient_id" value="" placeholder="<?php echo __('Enter patient id');?>" class="inv-field" /></td>
		    </tr>
		     <tr>
			<td><label><?php echo __('Date of Birth');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input  type="text" name="date_of_birth"  value="" placeholder="<?php echo __('Date of birth');?>" class="inv-field" /></td>
		    </tr>
		     <tr>
			<td><label><?php echo __('Age');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input type="text" name="age" value="" placeholder="<?php echo __('Age');?>" class="inv-field" /></td>
		    </tr>
		    <tr>
			<td><label><?php echo __('Sex');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input type="text" name="sex"  value="" placeholder="<?php echo __('Sex');?>" class="inv-field" /></td>
		    </tr>
		    <tr>
			<td><label><?php echo __('Reported Date');?></label></td>
			<td><p style="font:bold 14px arial;color:#333;">:</p></td>
			<td><i class="fa fa-edit"></i><input  type="text" name="report_date" value="<?php echo Date::formatted_time('now','d M Y, h:iA');?>" placeholder="<?php echo __('Report Date');?>" class="inv-field" /></td>
		    </tr>
		</table>
    </div>
    <div class="reports-table">
	<div class="tools" id="three"> 
	<ul>	
		<li><a id="addRow" href="#" title="<?php echo __('Add Row');?>">+</a></li>
		<li><a id="delRow" href="#" title="<?php echo __('Delete Row');?>">-</a></li>
	</ul>
</div>
	<table class="table table-striped" width="100%" style="border:1px solid #ddd;width:100%;">		    
	    <thead>
		<tr> 
		    <td style="border-right:1px solid #ddd;"><input value="<?php echo __('Test Name'); ?>" name="heading1" ></td>
		    <td style="border-right:1px solid #ddd;"><input value="<?php echo __('Normal'); ?>" name="heading2"></td>
		    <td style="border-right:1px solid #ddd;"><input value="<?php echo __('Abnormal'); ?>" name="heading3"></td> 
		    <td style="border-right:1px solid #ddd;"><input value="<?php echo __('Units'); ?>" name="heading4"></td> 
		</tr>
	    </thead>
	    <tbody>
		<tr> 
		    <td style="border-right:1px solid #ddd;"><input name="column[field1][]" value=""></td>
		    <td style="border-right:1px solid #ddd;"><input name="column[field2][]" value=""></td>
		    <td style="border-right:1px solid #ddd;"><input name="column[field3][]" value=""></td>     
		    <td style="border-right:1px solid #ddd;"><input name="column[field4][]" value=""></td>       
		</tr> 
	    </tbody> 
	</table>
    </div>
    <table width="100%" cellpadding="10" cellspacing="0" border="0">
	<tr>
	    <td align="center" > 
		<textarea rows="6" name="comments" style="border:1px solid #ddd;width:100%;height: 150px;" class="labname inv-field" placeholder="<?php echo __('Comments'); ?>"></textarea>
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
		<input type="text" name="prepared_by"  class="inv-field" style="border:1px solid #ddd;width:100%;height: 50px;" />
	    </td>
	</tr>	
    </table>
    <table width="100%" cellpadding="10" cellspacing="0" border="0">
	<tr>
	    <td align="center" > 
		<div class="input_fileds" style="float: none;">
		    <button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
		</div>
	    </td>
	</tr>
    </table>

</form>
<script>
	var insertRow = function() {

		$(".reports-table table").find('tbody')
			.append($('<tr>') 
			.append($('<td style="border-right:1px solid #ddd;">').append($('<input>').attr('value', '').attr('name', 'column[field1][]')))
			.append($('<td style="border-right:1px solid #ddd;">').append($('<input>').attr('value', '').attr('name', 'column[field2][]')))
			.append($('<td style="border-right:1px solid #ddd;">').append($('<input>').attr('value', '').attr('name', 'column[field3][]')))
			.append($('<td style="border-right:1px solid #ddd;">').append($('<input>').attr('value', '').attr('name', 'column[field4][]'))) 
		);	    
	}
	
	
// Add new Row
$("#addRow").click(function() {
	if (isNaN(parseInt($("tr:last-child td:first-child").text())))
	{
		 
	}
	else if (parseInt($("tr:last-child td:first-child").text())>24){
		return false;
	}
	insertRow(); 
    return false;	
});
$("#delRow").click(function() {
	$(".reports-table table tbody tr:last").remove(); 
	return false;
})
</script>