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
		    <h2><?php echo $this->getTerm() ? $this->getTerm() : "All Labs";?> in <?php echo $this->getAreaText();?></h2>
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
			<?php foreach($_results as $labs):?>
			<?php $departments = $labs->getDepartments(); ?> 
			<?php $labss = $labs->getClinics(); $facilites = array_filter(explode(",",$labs->getFacilities()));?>
			<?php $timings = App::helper('time')->setTimeSets($labs->getTimings())->formatGroupTime();  ?>
		    <li>
			<div class="list_left_image">
			    <div class="image_94">
					<?php if($image = $labs->getThumbnail('w200',true)):?>
							<img src="<?php echo $image;?>" alt="<?php echo $labs->getClinicName();?>" />
				<?php endif;?>
			    </div>
			</div>
			<div class="list_mid_content">
			    <div class="list_title">
				<a href="<?php echo $labs->getUrl();?>" title="<?php echo $labs->getClinicName();?>"><?php echo $labs->getClinicName();?></a>
			    </div>
			    <div class="list_sug_tags">
					<ul>
						<?php foreach($departments as $department):?>
						<li><a href="javascript:searchkeywords('<?php echo $department->getDepartmentName();?>','<?php echo $department->getDepartmentType()== 1?'doctor':'labs';?>')"  title="<?php echo $department->getDepartmentName();?>"><?php echo $department->getDepartmentName();?></a></li>
						<?php endforeach;?> 
					</ul>
			    </div>
				<div class="list_experience">
					<p><?php echo $labs->getAddress();?></p>
				</div>
				<?php if(count($facilites)):?>
				<div class="list_clinic_facility">
					<ul>
						<?php foreach($facilites as $facility):?>
						<li><a href="#" title="<?php echo $facility;?>"><?php echo $facility;?></a></li>
						<?php endforeach;?> 			    
					</ul>
				</div>
				<?php endif;?>
			    <div class="list_experience">
					<?php if($labs->getExperience()):?>
						<p><?php echo __(':years years of experience',array(':years' => $labs->getExperience()));?></p>
					<?php endif;?>
				</div>
				
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
				<?php endif;?>
				<?php if($labs->hasSubscribed()):?>
					<div class="list_book_appoinment">
					<a href="<?php echo $labs->getUrl();?>" title="<?php echo __('View Details');?>"><?php echo __('View Details');?></a>
					</div>
				<?php endif;?>
			</div>
		    </li>
			<?php endforeach;?>
		</ul>
	    </div>
	    <!--full listing part End-->
		<?php else:?>
	    <div class="nodata_found"><?php echo __('We couldn\'t find labs for you');?></div>
		<?php endif;?>
		<?php echo $this->getPaging();?>
	    
	</div>	
    </div>
</div>
<!-- inner box End -->
