<?php
$apointments = $this->getAppointments();
$doctor = $apointments->getdoctor();
$patient = $apointments->getPatient();
$date = $this->getAppointments()->getReadableTime();
$mobilenumber = $patient->getPhoneNumbers();
$onapp = $this->getRequest()->query('on_app');
?>

<form method="post" name="lab-report" action="<?php echo $this->getUrl('report/save', $this->getRequest()->query()); ?>" enctype="multipart/form-data">
    <table width="100%" cellpadding="10" cellspacing="0" border="0">
	<tr>
	    <td><h2 style="font:bold 18px arial;color:#333;"><?php echo __('Medical Report for'); ?> <?php echo $apointments->getName(); ?></h2></td>
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
		    <i class="fa fa-edit" ></i><input  type="text" value="<?php echo Arr::get($mobilenumber, 0); ?>" name="mobile_no" value="" placeholder="<?php echo __('Enter the mobile number'); ?>" class="inv-field" />
		</div>
	    </td>
	    <td width="33%">
		<label><?php echo __('File No'); ?> </label>	  
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input readonly  type="text" value="<?php echo Text::random(); ?>" name="file_no" value="" placeholder="" class="inv-field" />
		</div>
	    </td>	   
	    <td width="33%"><label><?php echo __('Patient Name'); ?> :</label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input  type="text" value="<?php echo $apointments->getName(); ?>" name="patient_name" value="" placeholder="<?php echo __('Enter the patient name'); ?>" class="inv-field" />
		</div>
	    </td>
	</tr>	
	<tr>
	    <td><label><?php echo __('Weight'); ?> :</label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input type="text"  name="weight" value="" placeholder="<?php echo __('Weight'); ?>" class="inv-field" />
		</div>
	    </td>
	    <td><label><?php echo __('Height'); ?> :</label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input type="text"  name="height" value="" placeholder="<?php echo __('Height'); ?>" class="inv-field" />
		</div>
	    </td>
	    <td><label><?php echo __('Age'); ?> :</label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input type="text"  name="age" value="" placeholder="<?php echo __('Age'); ?>" class="inv-field" />
		</div>
	    </td>
	</tr>	
	<tr>	  
	    <td>
		<label><?php echo __('Visited Date'); ?> :</label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input type="text" name="visit_date" value="<?php echo $apointments->getReadableTime(); ?>" placeholder="<?php echo __('Enter the date'); ?>" class="inv-field" />
		</div>
	    </td>	
	    <td><label><?php echo __('Date of Birth'); ?> :</label>
		<div class="input_boxes">
		    <i class="fa fa-edit"></i><input type="text" name="date_of_birth"  value="<?php echo date("Y/m/d", strtotime($patient->getDateOfBirth())); ?>" placeholder="<?php echo __('Date of birth'); ?>" class="inv-field" />
		</div>
	    </td>	   
	    <td>
		<label><?php echo __('Reported Date'); ?></label>
		<div class="input_boxes">
		    <i class="fa fa-edit"></i><input type="text" name="report_date" value="<?php echo Date::formatted_time('now', 'd M Y, h:iA'); ?>" placeholder="<?php echo __('Report Date'); ?>" class="inv-field" />
		</div>
	    </td>	
	</tr>
	<tr>
	    <td><label><?php echo __('Sex'); ?></label></td>
	    <td><input type="radio" checked="checked" name="sex" value="Male" /><label><?php echo __('Male'); ?></label></td>
	    <td><input type="radio" name="sex" value="Female" /><label><?php echo __('Female'); ?></label>		</td>
	</tr>
	<tr>
	    <td><label><?php echo __('Visit Type'); ?></label> </td>
	    <td><input type="radio" checked="checked" name="visit_type" value="First time" /><label><?php echo __('First time'); ?></label></td>
	    <td><input type="radio" name="visit_type" value="Usual" /><label><?php echo __('Usual'); ?></label></td>
	</tr>
	<tr>
	    <td><label><?php echo __('Patient access to see the report'); ?></label></td>
	    <td><input type="radio" checked="checked" name="report_access" value="1" /><label><?php echo __('Yes'); ?></label></td>
	    <td><input type="radio" name="report_access" value="0" /><label><?php echo __('No'); ?></label>		</td>
	</tr>
	<tr>
	    <td valign="top" colspan="3"><label ><?php echo __('Visit Reason'); ?></label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><input type="text"  name="visit_reason" value="" placeholder="<?php echo __('Visit Reason'); ?>" class="inv-field" />
		</div>
	    </td>
	</tr>
	<tr>
	    <td valign="top" colspan="3"><label ><?php echo __('Clinic Diagonsis and Notes'); ?></label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><textarea rows="20" name="comments"  class="labname inv-field" placeholder="<?php echo __('Clinical Diagnosis and notes'); ?>"></textarea>
		</div>
	    </td>
	</tr>
	<tr>
	    <td valign="top" colspan="3"><label ><?php echo __('Prescription'); ?></label>
		<div class="input_boxes">
		    <i class="fa fa-edit" ></i><textarea rows="20" name="prescription"  class="labname inv-field" placeholder="<?php echo __('Prescription'); ?>"></textarea>
		</div>
	    </td>
	</tr>
	<tr>
		<td valign="top" colspan="3"><label><?php echo __('Upload files max 6');?></label>
		<div class="input_boxes">
<i class="fa fa-edit"></i> <input type="file" name="uploadfile[]"> <br>
				<i class="fa fa-edit"></i> <input type="file" name="uploadfile[]"> <br>
				<i class="fa fa-edit"></i> <input type="file" name="uploadfile[]"> <br>
				<i class="fa fa-edit"></i> <input type="file" name="uploadfile[]"> <br>
				<i class="fa fa-edit"></i> <input type="file" name="uploadfile[]"> <br>
				 <i class="fa fa-edit"></i><input type="file" name="uploadfile[]">
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
		<input type="text" name="prepared_by" value="<?php echo $doctor->getFullName(); ?>"  class="inv-field" style="border:1px solid #ddd;width:100%;height: 50px;" />
	    </td>
	</tr>
    </table>
    <table width="100%" cellpadding="10" cellspacing="0" border="0">
	<tr>
	    <td align="center" > 
		<div class="input_fileds" style="float: none;">
		    <!--<button type="submit" class="btn btn-primary"><?php echo __('Edit'); ?></button>-->
		    <button type="submit" class="btn btn-primary"><?php echo __('Save'); ?></button>
		    <!--<button type="submit" class="btn btn-primary"><?php echo __('Export'); ?></button>-->
		</div>
	    </td>
	</tr>
    </table>
</form> 
