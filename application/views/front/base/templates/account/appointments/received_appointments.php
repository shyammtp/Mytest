<?php 
$apointments = $this->getAppointments();
$doctor = $apointments->getdoctor();
$patient = $apointments->getPatient();
$reports = $apointments->getPatientReports();
$date = $this->getAppointments()->getReadableTime(); 
$dates2= $this->getAppointments()->getReadableTime('Y-m-d'); 
$rotatedoctor = $this->getRotateDoctors(array($doctor->getId()));
$showrotate = true;
if($apointments->getRotateAppointmentId()) {
	$showrotate = false;
}
if($apointments->isRejected()) {
	$showrotate = false;
}
if($apointments->isClosed()) {
	if(!$apointments->isAccepted()) {
		$showrotate = false;
	}
}
?>

<?php if($apointments->getReportMessage()):?>
	<div class="report_state_message"> 
		<?php echo $apointments->getReportMessage();?>
	</div> 
<?php endif;?>
<div class="appointment_details">
    <div class="apointment_top_part">
	<div class="appointment_detail_daybox">
	    <span class="c_month" ><?php echo $apointments->getReadableTime('M'); ?></span>
	    <span class="c_date"><?php echo $apointments->getReadableTime('d'); ?></span>
	    <span class="c_day"><?php echo $apointments->getReadableTime('D'); ?></span>
	</div>
	<div class="appointment_top_right">
	    <h2><?php echo __('Received an appointment from :name on :date',array(':name' => $apointments->getName(),':date' => $date));?> (#<?php echo $apointments->getReferenceId();?>)</h2>
	    <?php if ($doctor->getVenue()): ?><p> at <?php echo $doctor->getVenue();?></p><?php endif;?>
	</div>
	<?php if($apointments->isClosed()):?>
	<div class="appointment_closed_icon"> 
		<div class="closed_state_message">
			<?php echo __('This appointment is Closed.');?>
		</div> 
	</div>
	<?php endif;?> 
    </div>
    <div class="apointment_mid_box">
	<h2><?php echo __('Appointment with '); ?><?php echo $doctor->getFullName(); ?>.</h2>
	<h3>@ <?php echo $date;?></h3>
	<?php if($doctor->getVenue()):?>
	<h4><?php echo $doctor->getVenue();?></h4>
	<?php endif;?>
	<ul>
	     <li><label><?php echo __('When');?></label><span><?php echo $date; ?></span></li>
	    <li><label><?php echo __('Where');?></label><span><?php echo $doctor->getVenue() ? $doctor->getVenue() : "-"; ?></span></li>
	    <li><label><?php echo __('Patient Name');?></label><span><?php echo $apointments->getName();?></span></li>
	    <li><label><?php echo __('Details');?></label><span><?php echo $apointments->getComments();?></span></li>	        
	</ul>
    </div>
	
    <div class="apointment_botom_form">
	<ul class="state_check">
		<?php if(!$apointments->isClosed()):?>
	    <li>
		<div class="box state_box">
		    <div class="apointment_botom_left">
			<div class="apointment_botom_title"><?php echo __('Accept'); ?></div>
		    </div>
		    <div class="apointment_botom_right">
			<input type="radio" <?php echo $apointments->isAccepted() ? "checked":"";?> name="astate" value="accept"> 
		    </div>
		    <form method="post" id="accept_appt" action="<?php echo $this->getUrl('settings/appointment',array('apptid' => $apointments->getReferenceId()));?>">
			<input type="hidden" name="accept" value="1" />
		    </form>	
		</div>			    
	    </li>
		<?php endif;?>
		
		<?php if(!$apointments->isClosed()):?>
	    <li>
		<div class="box state_box">			    
		    <div class="apointment_botom_left">
			<div class="apointment_botom_title"><?php echo __('Reject'); ?></div>
			<p><?php echo __('Give some reason below that why you are rejecting this appointment. After submitted, the respected user will receive a email notification / app notification that you have been discarded this appointment due to your following reasons.');?></p>
		    </div>
		    <div class="apointment_botom_right">
			<div class="rdio rdio-primary">
			    <input type="radio" <?php echo $apointments->isRejected() ? "checked":"";?> name="astate" value="reject"> 
			</div>
		    </div>			
		    <div class="body-cont" style="display: none;">
			<div class="general_form">
			    <form method="post" id="reject_appt" action="<?php echo $this->getUrl('settings/appointment',array('apptid' => $apointments->getReferenceId()));?>">
				<input type="hidden" name="is_reject"  class="type_dyna" value="0" />
				<ul>
				    <li><div class="input_fileds"><textarea name="reject_reason"></textarea></div></li>
				    <li><div class="input_fileds"><button type="submit"><?php echo __('Confirm'); ?></button></div></li>
				</ul>						
			    </form>
			</div>
		    </div>
		</div>
	    </li>		
		<?php endif;?> 
		
		
		<?php if(!$apointments->isClosed()):?>
	    <li>
		<div class="box state_box">
		    <div class="apointment_botom_left">
			<div class="apointment_botom_title"><?php echo __('Edit'); ?></div>
			<p><?php echo __('Editing this appointment time will create another appointment entry');?></p>
		    </div>
		    <div class="apointment_botom_right">
			<div class="rdio rdio-primary">
			    <input type="radio" name="astate" value="edit"> 
			</div>
		    </div>				
		    <div class="body-cont" style="display: none;">
<?php echo $this->childView('bookappointment', array('doctor' => $doctor,'apptid' => $apointments->getReferenceId(),'name_value' => $apointments->getName(),'comment_value' => $apointments->getComments())); ?>
		    </div>
		</div>
	    </li>
		<?php endif;?>
		<?php if($showrotate):?>
	    <li>
		<div class="box state_box">
		    <div class="apointment_botom_left">
			<div class="apointment_botom_title"><?php echo __('Rotate'); ?></div>
			<p><?php echo __('This patient will directly shifted to another doctor. Choose doctor below and add his/her timing to create a new appointment with him');?></p>
		    </div>
		    <div class="apointment_botom_right">
			<div class="rdio rdio-primary">
			    <input type="radio" name="astate" value="rotate"> 
			</div>
		    </div>			
		    <div class="body-cont" style="display: none;">
			<div class="general_form">
			    <form method="post" onsubmit="return submitrotate(this);"  action="<?php echo $this->getUrl('settings/rotatebook',array('apptid' => $apointments->getReferenceId()));?>">
				<input type="hidden" name="rotate_date" id="rotate_date" value="<?php echo Date::formatted_time('now','Y-m-d');?>"/>
				<div class="appointment_calender">
					<div id="datepicker-inlines"></div>
				</div>
				<ul class="rotate_forms">
				    <li> <input type="hidden" name="is_rotate" /><div class="input_fileds">
					<input type="text" name="keyword" id="search-keyword" value="<?php //echo $this->getTerm();?>" placeholder="<?php echo __('Search Doctors...');?>" />
					<input type="hidden" name="rotate_doctor" id="rotate_doctor" />
					<?php /*<select name="rotate_doctor" class="form-control">
						<option value="" selected="selected"><?php echo ' - '.__('Select Doctor').' - ';?></option>								
						<?php foreach($rotatedoctor as $id => $rotate):?>
							<option value="<?php echo $id;?>"><?php echo $rotate;?></option>
						<?php endforeach;?>
					</select> */ ?>
					<em id="msg"></em>
					</div>
					</li>
					
				    <li><div class="input_fileds"> <textarea name="rotate_reason"></textarea></div></li>
				    <li><div class="input_fileds"><button type="submit" id="rotate_btn"><?php echo __('Confirm'); ?></button></div></li>
				</ul>			  
			    </form>
			</div>
		    </div>
		</div>
	    </li>
		<?php endif;?>
	</ul>
	    
    </div> 
	<?php if(count($reports)):?>
    <div class="reportlist">
	<?php /* <div class="report_left">
	    <ul>
	    <?php $k = 1;
	    foreach ($reports as $report): ?>
		<?php if ($report->getReportType() == Model_Core_Report::LAB_REPORT_TYPE): ?>
		<li>
		    <p><?php echo __('Lab Report :id', array(':id' => $k)); ?></p><a target="_blank" href="<?php echo $this->getUrl('report/view', array('report_id' => $report->getId())); ?>"><i class="fa fa-eye"></i></a>
		</li>
		<?php $k++;endif; ?>
    <?php 
endforeach; ?>
	    </ul>
	</div> */ ?>
	<div class="report_left">
	     <ul>
	    <?php $j = 1;
	    foreach ($reports as $report): ?>
		<?php if ($report->getReportType() == Model_Core_Report::DOCTOR_REPORT_TYPE): ?>
		<li>
		    <p><?php echo __('Report :id', array(':id' => $j)); ?></p><a target="_blank" href="<?php echo $this->getUrl('report/view', array('report_id' => $report->getId())); ?>"><i class="fa fa-eye"></i></a>
			</li>
	    <?php $j++;endif; ?>
	<?php 
    endforeach; ?>
	     </ul>
	</div>
			    
    </div>
	<?php endif;?>
	<?php if($apointments->isClosed() && $apointments->isAccepted() && !$apointments->isRejected() && !$apointments->isRotated()):?>
	<div class="btn-group  input_fileds" style="margin-top:10px;"> 
		<button type="button" class="btn btn-primary" onclick="window.open('<?php echo $this->getUrl('report/generate',$this->getRequest()->query());?>')"><?php echo __('Generate New Report');?></button>
	</div>
	<?php endif;?>
</div> 
<script>
	$("#datepicker-inlines").datepicker({
            dateFormat: "yy-mm-dd",
			defaultDate : '<?php echo $dates2;?>',
			onSelect : function(date) {
				$("#rotate_date").val(date);
				dtimings($("#rotate_doctor").val());
			},
			minDate: new Date(),
			maxDate: new Date('<?php echo date("Y-m-d",strtotime('+1 Month'));?>'),
			dayNamesMin : ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        }) ;
	/*$(".state_check li").click(function(){
		$("input[name='astate']").prop('checked',false);
		var radio = $(this).find("input[name='astate']");
		radio.prop('checked',true);
		radioelementclick(radio);
		$(this).addClass('open');
		//radio.click();
	})*/
	$('#search-keyword').keypress(function(event) {
		if (event.which == 13) {
			event.preventDefault();
		}
	});
	function submitrotate(form)
	{
		var doctorid = $("input[name='rotate_doctor']").val();
		var timing = $("select[name='times'] option:selected").val(); 
		if (doctorid && timing) {
			return true;
		}
		alert('Invalid doctor/timing'); 
		return false;
	}
	var timing_rotateajax;
	$('#search-keyword').autocompletesingle({	  
		valueKey:'name',
		titleKey:'name', 
		source:[{
			url:'<?php echo $this->getUrl("account/getdoctors");?>?q=%QUERY%&d=<?php echo $doctor->getId();?>',	 
			type:'remote',
			getTitle:function(item){	 		
				return item['name']
			},
			getValue:function(item){ 
				return item['name']
			}
		}],
		itemStyle: {
			'font':'normal 12px/20px OpenSansRegular'
		},
		render : function (item, source, pid, query) {
				 var value = item[this.valueKey],
						title = item[this.titleKey],
					_value = '',
					_query = '',
					_title = '',
					hilite_hints = '',
					highlighted = '',
					c, h, i,
					spos = 0;
					
				if (this.highlight) {
					if (!this.accents) { 
						title = title.replace(new RegExp('('+query+')','i'),'<b>$1</b>');
					}else{ 
						_title = title.toLowerCase().replace(/[<>]+/g, ''),
						_query = query.toLowerCase().replace(/[<>]+/g, '');
						
						hilite_hints = _title.replace(new RegExp(_query, 'g'), '<'+_query+'>');
						for (i=0;i < hilite_hints.length;i += 1) {
							c = title.charAt(spos);
							h = hilite_hints.charAt(i);
							if (h === '<') {
								highlighted += '<b>';
							} else if (h === '>') {
								highlighted += '</b>';
							} else {
								spos += 1;
								highlighted += c;
							}
						}
						title = highlighted;
					}
				} 
				return '<div '+(value==query?'class="active"':'')+' data-value="'+encodeURIComponent(value)+'"><span class="left-suggest" style="font:normal 12px/20px OpenSansRegular;">' 
							+title+ 
						'</div>';
			}
		}).on('selected.xdsoft',function(e,datum){
			
			dtimings(datum.id);
			$("input[name='rotate_doctor']").val(datum.id);
		});
	
	function dtimings(val){
		var did = val;
		if (did == '') {
			$("#msg").html('');
			$("li.time_rotate").remove();
			return false;
		}
		if (timing_rotateajax) {
			timing_rotateajax.abort();
		}
		timing_rotateajax = $.ajax({
			url : '<?php echo $this->getUrl("view_doctor/timings",array('patient' => $apointments->getUserId()));?>&date='+$("#rotate_date").val(),
			type: 'get',
			data : {'id' : did},
			dataType:'json',
			beforeSend: function(){
				$("#msg").html('');
				$("li.time_rotate").remove();
			},
			success: function(resp) {
				console.log(resp);
				if (resp.error) {
					$("#msg").html("<i>"+resp.msg+"</i>");
					$("#rotate_btn").addClass('disabled').attr('disabled',true);
				}
				if (resp.success) {
					var select = '<li class="time_rotate"> <div class="input_fileds"><select name="times" class="form-control">';
					$.each(resp.slots.shift1,function(k,v){
						select += '<option value="'+v.time_24hr+'" '+((v.already_booked) ? "disabled":"")+'>'+v.time+'</option>'
					})
					select += '</select></div></li>';
					$("#msg").parents('.rotate_forms li:first').after(select);
					$("#rotate_btn").removeClass('disabled').attr('disabled',false);
				}
			}
		})
	}
	function radioelementclick(ele) {
		
		$(".type_dyna").val(0);
		$(".body-cont").hide();
		var val = ele.val();
		if (val == 'accept') {
			$("#accept_appt").submit();
		}
		if (val == 'reject') {
			ele.parents('.state_box').find('.body-cont').fadeIn();
			$("input[name='is_reject']").val(1); 
		}
		if (val == 'edit') { 
			ele.parents('.state_box').find('.body-cont').fadeIn();
		}
		if (val == 'rotate') { 
			ele.parents('.state_box').find('.body-cont').fadeIn();
		}
	}
	$("input[name='astate']").click(function(){
		radioelementclick($(this));
		
	});
</script>
