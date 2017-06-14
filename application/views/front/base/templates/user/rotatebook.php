<?php $_doctor = $this->getDoctor(); ?>

<div class="book_appointment_calender">
    <div id="datepicker-inline"></div> 
</div>
<div class="book_appointment_avail_time">
			<h3>Select a Time</h3>
<div class="avail_time_list"> 
</div>
</div>

<div id="bookappointment" class="modal fade" role="dialog"> 
    <div class="modal-dialog">
	<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
	<!-- Modal content-->
	<div class="modal-content"> 
	    <div class="modal-body"> 
		<div class="appoinment_popup_title">
		    <h2><?php echo __('Appointment to :name', array(':name' => $_doctor->getFullName())); ?></h2>
		    <p>@<span id="formatted_time">--</span></p>
		</div>
		<div class="popup_form">
		    <form method="post" id="book_appt_form">
		    <input type="hidden" name="datetime" id="appointment_datetime"/>
		    <input type="hidden" name="user_id" value="<?php echo App::model('user/session')->getId(); ?>" id="appointment_patient"/>
		    <ul>
			<li>
			    <label>Name</label>
			    <div class="pop_input_fields">
				<input type="text" name="name" class="form-control" value="<?php echo $this->getNameValue();?>">
				<span class="help-block">Mention your name or family members to get appointment with this doctor.</span>
				<div id="appt_name"  class="error-msgs"></div>
			    </div>
			</li>
			<li>
			    <label>Description</label>
			    <div class="pop_input_fields">
				<textarea name="description" style="resize:none;" rows="10" class="form-control"><?php echo $this->getCommentValue();?></textarea>
				<span class="help-block">Give your detail description about the appointment and reasons.</span>
				<div id="appt_description" class="error-msgs"></div>
			    </div>
			</li>
			<li>
			    <label class="empty_label">&nbsp;</label>
			    <div class="pop_input_fields">
				 <button class="btn btn-primary mr5" type="button" id="book_it_btn"><?php echo __('Book it'); ?></button>
				 <div class="loader-g" style="display:none;"><?php echo __('Loading').'...';?></div>
					  
			    <div class="error-msgs" id="serv_msg"></div>
			    <div class="success-msgs" id="success_msg"></div>
			    </div>
			</li>
		    </ul>		    
		    </form>
		</div>   		
		
	    </div>		
	</div>	    
    </div>
</div>
<script>
    $(function(){
		var addeddate;
		loadTimeSlots('<?php echo Date::formatted_time('now','Y-m-d');?>');
        $('#datepicker-inline').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect : function(date) { 
               loadTimeSlots(date);
            },
			minDate: new Date(),
			maxDate: new Date('<?php echo date("Y-m-d",strtotime('+1 Month'));?>'),
			dayNamesMin : ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        });
		
		function loadTimeSlots(date) {
			addeddate = date;
			 $.ajax({
				url: '<?php echo $this->getUrl("view_doctor/timings",array('id'=> $_doctor->getId()));?>&date='+date+'&patient=<?php echo App::model('user/session')->getId();?>',
				type:'get',
				dataType:'json',
				success: function(resp) {
					var html = '<ul>';
					if (resp.success) {
						$.each(resp.slots.shift1, function(k,v){
							if (v.you_booked) {
								html += '<li class="you_booked_time"><a href="javascript:;" data-datetime="'+date+' '+v.time_24hr+'" data-time="'+v.time+'" title="'+v.time+'">'+v.time+'</a><div class="you_booked_time_info">\
				<p>You have booked on this time.</p>\
				</div></li>'; 
							} else {
								html += '<li class="'+(v.already_booked ? '' : 'booked_time')+'"><a href="javascript:;" data-datetime="'+date+' '+v.time_24hr+'" data-time="'+v.time+'" class="'+(v.already_booked ? '' : 'bookapt')+'" title="'+(v.already_booked ? 'Not Available' : v.time)+'">'+v.time+'</a></li>';
							}
						});
						$(".avail_time_list").html(html);
					}
					if (resp.error) {
						$(".avail_time_list").html("<div class='nodata_found'>"+resp.msg+"</div>");
					}
				}
			});
		}
		
		$(document.body).on('click',".bookapt",function(){
			var date = $(this).attr('data-datetime');
			var tdate = $(this).attr('data-time');
			var d = new Date(date); 
			var days = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
			var month = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
			var formatted_date = days[d.getDay()]+" "+d.getDate()+" "+month[d.getMonth()]+" "+d.getFullYear()+", "+tdate;
			$("#formatted_time").html(formatted_date);
			$("#appointment_datetime").val(date);
			$("#bookappointment").modal();
			//$(".form-control").val('').removeClass('error_ind');
			$(".error-msgs").html('');
		});
		
		$(document.body).on('click','#book_it_btn',function(){
			var data = $("#book_appt_form").serializeArray();
			var dataset = {};
			$.each(data, function(k,v){
				dataset[v.name] = v.value;
			});
			$.ajax({
				url: '<?php echo $this->getUrl("view_doctor/book",array('id'=> $_doctor->getId()));?>',
				data: dataset,
				type: 'post',
				dataType: 'json',
				beforeSend: function() {
					$(".loader-g").show();
				},
				success: function(res) {
					$(".loader-g").hide();
					$(".form-control").removeClass('error_ind');
					$(".error-msgs").html('');
					if (res.error) {
						if (res.errors.name) {
							$("#appt_name").text(res.errors.name);
							$("input[name='name']").addClass('error_ind');
						}
						if (res.errors.description) {
							$("#appt_description").text(res.errors.description);
							$("textarea[name='description']").addClass('error_ind');
						}
						if (res.errors.server) {
							$("#serv_msg").text(res.errors.server);
						}
					}
					if (res.success) {
						loadTimeSlots(addeddate);
						$(".form-control").val('');
						$("#book_it_btn").attr('disabled',true);
						$("#success_msg").html('<?php echo __("Appointment has been fixed");?>');
					}
				}
			});
			console.log(dataset);
		});
		
    })
</script>
