<?php echo $this->childView('searchbar'); ?>
<?php echo $this->childView('breadcrumbs'); ?>
<?php $_clinic = $this->getClinic();
$services = $_clinic->getServices(false);
$facilities = $_clinic->getFacilities(false);
$insurance = $_clinic->getInsurance();
$gallery = $_clinic->getGallerysImages();
$videos = $_clinic->getVideos();
$doctors = $_clinic->getDoctors();
$hasinfotab = false;
?>
<?php $timings = App::helper('time')->setTimeSets($_clinic->getTimings())->formatGroupTime();

if($_clinic->getAbout() || count($timings) || $_clinic->getPhoneNumbers() || count($services) || count($facilities)):
$hasinfotab = true;
endif;
?>
 
<!-- inner box Start -->
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="doctor_detail_top">
		<div class="detail_left_image">
		    <div class="image_94">
			<img src="<?php echo $_clinic->getThumbnail();?>" alt="<?php echo $_clinic->getClinicName();?>" />
		    </div>
		</div>
		<div class="detail_top_right">
		    <div class="list_title">
			<a href="javascript:;" style="cursor: default;" title="<?php echo $_clinic->getClinicName();?>"><?php echo $_clinic->getClinicName();?></a>
		    </div>		    
		    <div class="list_experience">
			<p><?php echo $_clinic->getSubText();?></p>
		    </div>
		     <div class="list_experience">
			<p><?php echo $_clinic->getAreaText();?>.<br/>
			<?php echo $_clinic->getAddress();?></p>
		    </div>
		    
		    <div class="detail_share">
			<ul>
			    <li><b><?php echo __('Share');?> : </b></li>
			    <li>
					
					<a target='_blank' href='http://www.facebook.com/share.php?u=<?php echo urlencode($_clinic->getUrl()); ?>' title="facebook" class="share_facebook"></a>
				</li>
			    <li>
					<a target='_blank' href="https://twitter.com/intent/tweet?text=<?php echo urlencode($_clinic->getUrl()); ?>" title="Twitter" class="share_twitter"></a></li>
			    <li>
					<a target='_blank' href="https://plus.google.com/share?url={<?php echo urlencode($_clinic->getUrl()); ?>}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Google Plus" class="share_gplus"></a></li>
			    <li><a target='_blank' href="mailto:?subject=I wanted you to see this site&amp;body=Check out this <?php echo urlencode($_clinic->getUrl()); ?>." title="Mail" class="share_mail"></a></li>
			</ul>
		    </div>
		</div>
	    </div>
	    <!--detail tab part head Start-->
	    <div class="detail_tab_head">
		<ul>
			<?php if($hasinfotab):?>
		    <li><a href="javascript:;" name="detail_tab_1" title="<?php echo __('Info');?>" class="<?php echo $hasinfotab?"active":"";?>"><?php echo __('Info');?></a></li>
			<?php endif;?>
			<?php if(count($doctors)):?>
		    <li><a href="javascript:;" name="detail_tab_2" class="<?php echo !$hasinfotab?"active":"";?>" title="<?php echo __('Doctors');?>" ><?php echo __('Doctors');?></a></li>
			<?php endif;?>
			<?php if(count($gallery) || count($videos)):?>
		    <li><a href="javascript:;" name="detail_tab_3" class="photo_video" title="<?php echo __('Photos & Videos');?>"><?php echo __('Photos & Videos');?></a></li>
			<?php endif;?>
			<?php if(count($insurance)):?>
		    <li><a href="javascript:;" name="detail_tab_4" title="<?php echo __('Insurance');?>"><?php echo __('Insurance');?></a></li>
			<?php endif;?>
		</ul>
	    </div>
	    <!--detail tab part head End-->
	    <!--detail tab part Start-->
	    <!--tab First start-->
	    <div class="detail_tab_main detail_tab_1" style="<?php echo $hasinfotab?"display: block;":"";?>">
		<div class="detail_info_tab">
			<?php if($_clinic->getAbout()):?>
		    <div class="clinic_info_details">
				<h3>About <?php echo $_clinic->getClinicName();?></h3>
				<p><?php echo $_clinic->getAbout();?></p>
			</div>
			<?php endif;?>
			<?php if(count($timings)):?>
		    <div class="list_available_time">
			<?php foreach($timings as $time):?>
			<div class="list_open_day">
			    <span><?php echo Arr::get($time,'day');?></span>
			    <p><?php echo Arr::get($time,'time');?></p>
			</div>
			<?php endforeach;?> 
		    </div>
			<?php endif;?>
			<?php if($_clinic->getPhoneNumbers()):?>
		    <div class="detail_pnumber" <?php if(!count($timings)):?> style="border-left:none; margin-left:0;" <?php endif;?>>
			<div class="list_open_day">
			    <span><?php echo __('Phone');?></span>
			    <p><?php echo implode("<br/>",$_clinic->getPhoneNumbers());?></p>
			</div>				
		    </div>
			<?php endif;?>
		    <div class="clinic_features">
			<?php if(count($services)):?>
			<div class="clinic_left_feature ">
			    <h3><?php echo __('Services');?></h3>
			    <div class="list_clinic_facility">
			    <ul>
				<?php foreach($services as $s):?>
				<li><p><?php echo $s;?></p></li>
				<?php endforeach;?> 	
			    </ul>
			    </div>
			</div>
			<?php endif;?>
			<?php if(count($facilities)):?>
			<div class="clinic_right_feature">
			    <h3><?php echo __('Facilities');?></h3>
			     <div class="list_clinic_facility">
			    <ul>
				<?php foreach($facilities as $f):?>
				<li><p><?php echo $f;?></p></li>
				<?php endforeach;?>  
			    </ul>
			     </div>
			</div>
			<?php endif;?>
		    </div>
		</div>
		
	    </div>
	     <!--tab Second start-->
	    <div class="detail_tab_main detail_tab_2"  style="<?php echo !$hasinfotab?"display: block;":"";?>">
		<div class="full_listing_part">
		<ul>
			<?php foreach($doctors as $doc): $doctor = App::model('user',false)->load($doc->getUserId());
			$doctimings = App::helper('time')->setTimeSets($doctor->getTimings())->formatGroupTime(); 
			 $departments = $doctor->getDepartments(); ?>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
				<img src="<?php echo $doctor->getProfileImageUrl('w100','h100',true);?>" alt="<?php echo $doctor->getFirstName();?>" title="<?php echo $doctor->getFirstName();?>" />
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="<?php echo  $doctor->getUrl();?>" title="<?php echo $doctor->getFirstName();?>"><?php echo $doctor->getFirstName();?></a>
			    </div>
				<?php if($doctor->getQualification()):?>
			    <div class="list_experience">
				<p><?php echo $doctor->getQualification();?></p>
			    </div>
				<?php endif;?>
			    <div class="list_sug_tags">
				<ul>
				   <?php foreach($departments as $department):?>
				    <li><a href="<?php echo App::helper('url')->getSearchKeywordUrl($department->getDepartmentName(),'doctor');?>" title="<?php echo $department->getDepartmentName();?>"><?php echo $department->getDepartmentName();?></a></li>
					<?php endforeach;?> 
				</ul>
			    </div>
				<?php if($doctor->getExperience()):?>
			    <div class="list_experience">
				<p><?php echo __(':years years of experience',array(':years' => $doctor->getExperience()));?></p>
			    </div>
			   <?php endif;?>
			</div>
			
			<div class="list_right_part">
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
				<?php if($doctor->hasSubscribed()):?>
			    <div class="list_book_appoinment">
				<a href="<?php echo $doctor->getUrl();?>" title="Book Appointment">Book Appointment</a>
			    </div>
				<?php endif;?>
			</div>
			
		    </li>
			<?php endforeach;?>
		     
		</ul>
	    </div>
	    </div>
	    <!--tab third start-->
	    <div class="detail_tab_main detail_tab_3"  >
			<?php echo $this->childView('photos',array('gallery_images'=>$gallery,'videos' => $videos));?>
	    </div>
	    <!--tab fourth start-->
	    <div class="detail_tab_main detail_tab_4"  >
		<?php if(count($insurance)):?>
		<div class="deatil_insurance_block">
		<table width="100%" cellpadding="10" cellspacing="0" border="0" >
		    <tbody>
				<?php foreach($insurance as $ins):?>
			<tr>
			    <td width="300">
					<?php if($logo = $ins->getLogo()):?>
					<img src="<?php echo  $ins->getLogo();?>" alt="<?php echo $ins->getInsuranceName();?>" />
					<?php endif;?>
				</td>
			    <td width="220"><a href="#" title="Jordan Insurance Company"><?php echo $ins->getInsuranceName();?></a></td>
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
	    //margin: 12,
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
		   
		},
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
