<?php //echo $this->childView('searchbar'); ?> 
<?php echo $this->childView('breadcrumbs');
$_doctor = $this->getDoctor();
$departments = $_doctor->getDepartments();
$gallery = $_doctor->getGallerysImages();
$insurance = $_doctor->getInsurance();
$videos = $_doctor->getVideos();
$clinics = $_doctor->getClinics(); 
$doctimings = App::helper('time')->setTimeSets($_doctor->getTimings())->formatGroupTime();
$bookedappt = $this->getBookedAppointments();
?> 
<!-- inner box Start -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo App::getConfig('GOOGLE_MAP_APIKEY',Model_Core_Place::ADMIN);?>"></script>
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="doctor_detail_top <?php if($_doctor->getData('latitude') && $_doctor->getData('longitude')){ ?> map_block <?php } ?>">
		<div class="detail_left_image">
		    <div class="image_94">
			<img src="<?php echo $_doctor->getProfileImageUrl('w400','h400',true);?>" alt="<?php echo $_doctor->getFullName();?>" />
		    </div>
		</div>
		<div class="detail_top_right">
		    <div class="list_title">
			<a href="javascript:;" title="<?php echo $_doctor->getFullName();?>"><?php echo $_doctor->getFullName();?></a>
			<?php if($_doctor->getQualification()):?><div class="list_experience"> <p><?php echo $_doctor->getQualification();?></p></div><?php endif;?>
		    </div>
			<?php if(count($departments)):?>
				<div class="list_sug_tags">
				<ul>
					<?php foreach($departments as $department):?>
					<li><a href="<?php echo App::helper('url')->getSearchKeywordUrl($department->getDepartmentName(),($department->getDepartmentType()== 1?'doctor':'labs'));?>" title="<?php echo $department->getDepartmentName();?>"><?php echo $department->getDepartmentName();?></a></li>
					<?php endforeach;?>
				</ul>
				</div>
			<?php endif;?>
			<?php if($_doctor->getExperience() > 0):?>
		    <div class="list_experience">
			<p><?php echo __(':years years of experience',array(':years' => $_doctor->getExperience()));?></p>
		    </div>
			<?php endif;?>
			<?php if(count($clinics)):?>
		    <div class="list_lab_tags">
			<ul>
				<?php $count = 1; foreach($clinics as $clinic): ?>
			    <li><a href="<?php  echo $clinic->getUrl(); //echo App::helper('url')->getSearchKeywordUrl($clinic->getClinicName(),$clinic->getTypeUrl());?>" title="<?php echo $clinic->getClinicName();?>"><?php echo $clinic->getClinicName();?><?php if($count !=count($clinics)){?>,<?php } ?> </a></li>
				<?php $count++; endforeach;?> 		

			</ul>
		    </div>
			<?php endif;?>
		    <div class="list_experience">
			<p><?php echo $_doctor->getAbout();?></p>
		    </div>
		    <div class="detail_share">
			<ul>
			    <li><b><?php echo __('Share');?> : </b></li>
			    <li>
					
					<a target='_blank' href='http://www.facebook.com/share.php?u=<?php echo urlencode($_doctor->getUrl()); ?>' title="facebook" class="share_facebook"></a>
				</li>
			    <li>
					<a target='_blank' href="https://twitter.com/intent/tweet?text=<?php echo urlencode($_doctor->getUrl()); ?>" title="Twitter" class="share_twitter"></a></li>
			    <li>
					<a target='_blank' href="https://plus.google.com/share?url={<?php echo urlencode($_doctor->getUrl()); ?>}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Google Plus" class="share_gplus"></a></li>
			    <li><a target='_blank' href="mailto:?subject=I wanted you to see this site&amp;body=Check out this <?php echo urlencode($_doctor->getUrl()); ?>." title="Mail" class="share_mail"></a></li>
			</ul>
		    </div>
		</div>
			<?php if($_doctor->getData('latitude') && $_doctor->getData('longitude')){ ?> 
				<div class="detail_info_tab_map">
						<span><?php echo __('Location'); ?></span>
						<div  id="mapCanvas" style=" height:150px;"></div>  
				</div>
			<?php } ?>
	    </div>
	    <!--detail tab part head Start-->
	    <div class="detail_tab_head">
		<ul>
		    <li><a href="javascript:;" name="detail_tab_1" title="<?php echo __('Info');?>" class="active"><?php echo __('Info');?></a></li>
			<?php if(count($gallery) || count($videos)):?>
		    <li><a href="javascript:;" name="detail_tab_2" class="photo_video" title="<?php echo __('Photos & Videos');?>"><?php echo __('Photos & Videos');?></a></li>
			<?php endif;?>
			<?php if(count($insurance)):?>
		    <li><a href="javascript:;" name="detail_tab_3" title="<?php echo __('Insurance');?>"><?php echo __('Insurance');?></a></li>
			<?php endif;?>
		</ul>
	    </div>
	    <!--detail tab part head End-->
	    <!--detail tab part Start-->
	    <!--tab First start-->
	    <div class="detail_tab_main detail_tab_1" style="display: block;">
			
		<div class="detail_info_tab">
			<?php if($_doctor->getAbout() || $_doctor->getVenue()):?>
		    <div class="detail_box_outer">
				<?php if($_doctor->getAbout()):?>
				 <div class="detail_box_about">
				<span><?php echo __('About'); ?></span>
					<p><?php echo $_doctor->getAbout();?></p>
				 </div>
				 <?php endif;?>
				 <?php if($_doctor->getVenue()):?>
			    <div class="detail_box_venue">
			    <span><?php echo __('Venue'); ?></span>
			    <p><?php echo $_doctor->getVenue();?></p>
			    </div>
			    <?php endif;?>
		    </div>
			<?php endif;?>
		   
			<?php if($doctimings):?>
				<div class="list_available_time">
				<?php foreach($doctimings as $tim):?>
						<div class="list_open_day">
						 <span><?php echo Arr::get($tim,'day');?></span>
							<p><?php echo Arr::get($tim,'time');?></p>
						</div>
				<?php endforeach;?>  
				</div>
			<?php endif;?>
			<?php if(count($_doctor->getPhoneNumbers())):?>
		    <div class="detail_pnumber" style="<?php if(!$doctimings):?>border:none; margin:0;<?php endif;?>">
				<div class="list_open_day">
					<span><?php echo __('Phone'); ?></span>
					<p><?php echo implode("<br/>",$_doctor->getPhoneNumbers());?></p>
				</div>	
			</div>
		    <?php endif;?>
			
		</div>
		
		<?php if($this->isBookedAlready()):?>
		<div class="already-booked-ind">
			<?php if($bookedappt->getAppointmentState() == Model_Core_Appointments::STATE_ACCEPT
						|| $bookedappt->getAppointmentState() == Model_Core_Appointments::STATE_NEW):?>
				<?php echo __('You have been booked already with this doctor on :date',array(':date' => $bookedappt->getReadableTime()));?>.
			<?php endif;?>
			<?php if($bookedappt->getAppointmentState() == Model_Core_Appointments::STATE_REJECT ):?>
				<span style="color:red; font:normal 16px/50px OpenSansSemibold;"><?php echo __('Your appointment has been rejected with this doctor on :date',array(':date' => $bookedappt->getReadableTime()));?>.</span>
			<?php endif;?>
			<?php if($bookedappt->getAppointmentState() == Model_Core_Appointments::STATE_ROTATE ):?>
				<span style="font:normal 16px/50px OpenSansSemibold;"><?php echo __('Your appointment shifted to another doctor');?>.</span>
			<?php endif;?>
			<a href="<?php echo App::helper('url')->getAccountUrl('account/viewappointments',array('apptid' => $bookedappt->getReferenceId()));?>"><?php echo __('View the appointment');?></a>
		</div>
		<?php endif;?>
		<div class="book_appoinment_btn">
		    <a href="javascript:;"  title="<?php echo __('Book Appointment');?>"><?php echo __('Book Appointment');?></a>
		</div>
		<div class="book_appointment_block">
			<?php if (App::model('user/session')->isLoggedIn()) { ?>
				<?php echo $this->childView('bookappointment',array('doctor' => $_doctor));?>
			<?php }else{ ?>
				<div class="list_title">
					<a href='<?php echo $this->getUrl('signin',array('return' => Request::detect_uri())); ?>'><?php echo __('Please login to book the appointment'); ?></a>
				</div>	
			<?php } ?>		
		</div>
	    </div>
	    <!--tab second start-->
	    <div class="detail_tab_main detail_tab_2"  >
			<?php echo $this->childView('photos',array('gallery_images'=>$gallery,'videos' => $videos));?>
	    </div>
	    <!--tab Third start-->
	    <div class="detail_tab_main detail_tab_3"  >
		<?php if(count($insurance)):?>
		<div class="deatil_insurance_block">
		<table width="100%" cellpadding="10" cellspacing="0" border="0" >
		    <tbody>
				<?php foreach($insurance as $ins):?>
			<tr>
			    <td width="300">
					<?php  if($logo = $ins->getLogo()):?>
					<img src="<?php echo  $ins->getLogo();?>" alt="<?php echo $ins->getInsuranceName();?>" />
					<?php endif;?>
				</td>
			    <td width="220"><a style="cursor: default;"   title="<?php echo $ins->getInsuranceName();?>"><?php echo $ins->getInsuranceName();?></a></td>
			    <td width="480"><p><?php echo $ins->getDescription();?></p></td>						    
			</tr>
			<?php endforeach;?> 
		    </tbody>
		    
		</table>
		</div>
		<?php endif;?>
		</div>
		
	    <!--detail tab part End-->
	</div>
    </div>
</div>


<script type="text/javascript">
<?php if($_doctor->getData('latitude') && $_doctor->getData('longitude')){ ?> 	
	function initialize() {
	  var latLng = new google.maps.LatLng(<?php echo $_doctor->getData('latitude');?>,<?php echo $_doctor->getData('longitude');?>);
	  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
		zoom: 12,
		center: latLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	  var marker = new google.maps.Marker({
		position: latLng,
		title: 'Point A',
		map: map
	  }); 
	}
	
	// Onload handler to fire off the app.
	google.maps.event.addDomListener(window, 'load', initialize);
	
<?php } ?>	
	
    $(document).ready(function(){
	$('.detail_tab_head ul li a').click(function(){
	    var main_tab = $(this).attr('name');
	    var total_main_tab = $('.detail_tab_main').length
	    if($('div').hasClass(main_tab)) {
		$('.'+main_tab).show();
	    }
	    var tab_indentifier = main_tab.split('_');
	    for(var i =1;i<=total_main_tab;i++) {
		if(i!=tab_indentifier[2]){
		    $('.detail_tab_'+i).hide();
		}
	    }
	    $('.detail_tab_head ul li a').removeClass('active');
	    $(this).addClass('active');
	});  
	$('.book_appoinment_btn a').click(function(){
	    $('.book_appointment_block').toggle();	    
	    $('.book_appoinment_btn a').toggleClass('active');
	 
	});
    });   

</script>
<script>
    $(document).ready(function() {
	$('.detail_tab_head ul li a.photo_video').click(function(){
	var $sync1 = $("#sync1"),
	$sync2 = $("#sync2"),
	flag = false,
	duration = 300;	 
	$sync1
	.owlCarousel({
	    items: 1,		
	    nav: false,
rtl : <?php echo App::getCurrentLanguageId() == 2 ? "true":"false";?>,	    
	})
	.on('change.owl.carousel', function (e) {
	    if (e.namespace && e.property.name === 'position' && !flag) {
		flag = true;
		$sync2.trigger('to.owl.carousel', [e.relatedTarget.relative(e.property.value), duration, true]);
		flag = false;	    
	    }
	});	 
	$sync2
	.owlCarousel({
	    items: 6,
	   // margin: 12,
	    nav: true,
	    rtl : <?php echo App::getCurrentLanguageId() == 2 ? "true":"false";?>,
	    //loop: true
 responsive:{	
		
		700:{
		    items:5,
		    nav:true
		   
		},
		400:{
		    items:4,
		    nav:true
		   
		}		,
		0:{
		    items:2,
		    nav:true
		   
		}
	    }	    
	})
	.on('click', '.owl-item', function (e) {
	    e.preventDefault();
	    $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);
	})
	.on('change.owl.carousel', function (e) {
	    if (e.namespace && e.property.name === 'position' && !flag) {
		flag = true;
		$sync1.trigger('to.owl.carousel', [e.relatedTarget.relative(e.property.value), duration, true]);
		flag = false;
	    }
	});	
	    	});
    }); 
</script>
