<?php $_results = $this->getResults();?>

<!-- bread Crumb End -->
<script type="text/javascript">
    $(document).ready(function(){
	$('.grid_list_button ul li a').click(function(){
	    $('.grid_list_button ul li a').removeClass('active');
	    $(this).addClass('active');
	   
	});
	$('.grid_list_button ul li a.grid_btn').click(function(){
	 $('.full_listing_part').addClass('grid_view');
	});
	$('.grid_list_button ul li a.list_btn').click(function(){
	 $('.full_listing_part').removeClass('grid_view');
	});
    });
</script>
<!-- inner box Start -->
<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="listing_head_title">
		<div class="list_search_title">
		   <p><?php echo $this->getTotal().__(' matches found for :');?></p>
		    <h2><?php echo $this->getTerm();?> <?php echo $this->getAreaText() ? __("in ").$this->getAreaText():"";?></h2>
		</div>
		<div class="grid_list_button">
		    <ul>
			<li><a href="javascript:;" title="<?php echo __('List');?>" class="list_btn active"><?php echo __('List');?></a></li>
			<li><a href="javascript:;" title="<?php echo __('Grid');?>" class="grid_btn"><?php echo __('Grid');?></a></li>
		    </ul>
		</div>
	    </div>
		<?php if($_results):?>
	    <!--full listing part start-->
	    <div class="full_listing_part">
		<ul>
			<?php foreach($_results as $doctor):?>
			<?php $departments = $doctor->getDepartments(); ?>
			<?php $insurance = $doctor->getInsurance(); ?>
			<?php $clinics = $doctor->getClinics(); ?>
			<?php $timings = App::helper('time')->setTimeSets($doctor->getTimings())->formatGroupTime(); ?>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
					<?php if($image = $doctor->getProfileImageUrl('w400','h400',true)):?>
							<img src="<?php echo $image;?>" alt="<?php echo $doctor->getFullName();?>" />
					<?php endif;?>
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="<?php echo $doctor->getUrl();?>" title="<?php echo $doctor->getFullName();?>"><?php echo $doctor->getFullName();?> </a> 
				<?php if($doctor->getMobile()):?><span style="font: normal 12px/20px OpenSansRegular; color#333;">(<?php echo $doctor->getMobile();?>)</span><?php endif;?>
					<?php if($doctor->getQualification()):?><div class="list_experience"> <p><?php echo $doctor->getQualification();?></p></div><?php endif;?>
				</div>
			    <div class="list_sug_tags">
				<ul>
					<?php foreach($departments as $department):?>
				    <li><a href="javascript:searchkeywords('<?php echo $department->getDepartmentName();?>','doctor')" title="<?php echo $department->getDepartmentName();?>"><?php echo $department->getDepartmentName();?></a></li>
					<?php endforeach;?> 
				</ul>
			    </div>
				<?php if($doctor->getExperience()):?>
			    <div class="list_experience">
					<p><?php echo __(':years years of experience',array(':years' => $doctor->getExperience()));?></p>
				</div>
				<?php endif;?>
				
				
				<?php if(count($insurance)):  ?>
				<div class="list_insurance_tags">
					<ul>
						<?php $count = 0; foreach($insurance as $insuranc): ?>
						<li><a href="<?php echo App::helper('url')->getSearchKeywordUrl($this->getTerm(),'doctor',$insuranc->getUrlKey());?>" title="<?php echo $insuranc->getInsuranceName();?>"><?php echo $insuranc->getInsuranceName();?><?php echo count($insurance) > 1 && $count < 2 ? ",":"";?></a></li>
						<?php if($count == 2) { break;}?>
						<?php $count++; endforeach;?>
						<?php if(count($insurance) > 2):?>
						<li><p>and</p></li>
						<?php endif;?>
						<?php $count = 0;$stat = 0; foreach($insurance as $insuranc):?>
						<?php if($count >= 2) { $stat++;}?>
						<?php $count++; endforeach;?> 
						<?php if($stat):?>
						<li><a href="<?php echo $doctor->getUrl();?>" title="<?php echo $stat.' '.__('more');?>"><?php echo $stat.' '.__('more');?></a></li>
						<?php endif;?>
					</ul>
				</div>
				<?php if($doctor->getAddress()){ ?>
				<div class="list_address_tags">
				<p><?php  echo __('Address'); ?> - <?php  echo $doctor->getAddress();?>
				</p>
				</div>
				<?php } ?>
				<?php endif;?>
				<?php if(count($clinics)):?> 
				<div class="list_lab_tags">
				<ul>
				    <?php $count = 0; foreach($clinics as $clinic):?>
				    <li><a href="<?php echo $clinic->getUrl();?>" title="<?php echo $clinic->getClinicName();?>"><?php echo $clinic->getClinicName();?><?php echo count($clinics) > 1 && $count+1 < 2 ? ",":"";?></a></li>
					<?php if($count == 1) { break; }?>
					<?php $count++; endforeach;?>
					<?php if(count($clinics) > 2):?>
				    <li><p>and</p></li>
					<?php endif;?>
					<?php $count = 0; $stat = 0; foreach($clinics as $clinic):?>
					<?php if($count >= 2) { $stat++; }?>
					<?php $count++; endforeach;?>
					<?php if($stat):?>
				    <li><a href="<?php echo $doctor->getUrl();?>" title="<?php echo $stat.' '.__('more');?>"><?php echo $stat.' '.__('more');?></a></li>
					<?php endif;?>
					 
				</ul>
				</div>
				<?php endif;?>
			</div>
			<div class="list_right_part">
			<?php if(count($timings)):?>
			    <div class="list_available_time">
				<?php foreach($timings as $time):?>
					<div class="list_open_day">
						<span><?php echo Arr::get($time,'day');?></span>
						<p><?php echo Arr::get($time,'time');?></p>
					</div>
				<?php endforeach;?> 
			    </div>
				<?php if($doctor->hasSubscribed()):?>
					<div class="list_book_appoinment">
					<a href="<?php echo $doctor->getUrl();?>" title="<?php echo __('Book Appointment');?>"><?php echo __('Book Appointment');?></a>
					</div>
				<?php endif;?>
			<?php endif;?>
			</div>
		    </li>
			<?php endforeach;?>
		</ul>
	    </div>
	    <!--full listing part End-->
		<?php else:?>
	    <div class="nodata_found"><?php echo __('We couldn\'t find doctors for you');?></div>
		<?php endif;?>
		<?php echo $this->getPaging();?>
	    
	</div>	
    </div>
</div>
<!-- inner box End -->
