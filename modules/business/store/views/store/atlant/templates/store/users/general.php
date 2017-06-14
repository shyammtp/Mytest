<?php 
$tabids = array('gin','gal','vid','tim');
$disabled = false;

?>

<ul class="nav nav-tabs nav-tabs-simple"> 
    <li class="<?php echo !in_array($this->getRequest()->query('tab'),$tabids) ||  $this->getRequest()->query('tab')=='gin'?"active":"";?>"><a href="<?php echo $this->getUrl('users/edit',Arr::merge($this->getRequest()->query(),array('tab' => 'gin')));?>" class="ctab"><strong><?php echo __('General Information');?></strong></a></li>
	
   <?php /* <li class="<?php echo $this->getRequest()->query('tab')=='gal'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="<?php echo $this->getUrl('users/edit',Arr::merge($this->getRequest()->query(),array('tab' => 'gal')));?>"  class="ctab"><strong><?php echo __('Gallery');?></strong></a></li>
	
	<li class="<?php echo $this->getRequest()->query('tab')=='vid'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="<?php echo $this->getUrl('users/edit',Arr::merge($this->getRequest()->query(),array('tab' => 'vid')));?>"  class="ctab"><strong><?php echo __('Youtube Videos');?></strong></a></li>
	
    <li class="<?php echo $this->getRequest()->query('tab')=='tim'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="<?php echo $this->getUrl('users/edit',Arr::merge($this->getRequest()->query(),array('tab' => 'tim')));?>"  class="ctab"><strong><?php echo __('Time Schedule');?></strong></a></li>  */ ?>
	
	 
</ul>
<div class="tab-content tab-content-simple mb30"> 
    <div class="tab-pane <?php echo !in_array($this->getRequest()->query('tab'),$tabids) || $this->getRequest()->query('tab')=='gin'?"active":"";?>" id="gin"><?php echo $this->childView('doctor_edit');?></div>
   <?php /*
    <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='gal'?"active":"";?>" id="gal">
		<?php if($this->getUsers()->getUserId()): ?>
			<?php echo $this->childView('gallery',array('images' => $this->getGalleryImages($this->getUsers()->getUserId()),
														'upload_link' => $this->getUrl('users/uploadgallery',array('id' => $this->getUsers()->getUserId())),
														'redirect_link' => $this->getUrl('users/edit',array('id' => $this->getUsers()->getUserId(),'name'=> true,'tab' => 'gal')),
														'deletegallery_link' => $this->getUrl('users/deletegallery'),
														'primary_link' =>  $this->getUrl('users/setthumbnail')
														));?>
		<?php else:?>
			<div class="alert alert-warning">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
				<strong><?php echo __('Warning!');?></strong>
				<?php echo __('Please add doctor details first');?>
			</div>
		<?php endif;?>
	</div>
    <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='vid'?"active":"";?>" id="vid">
		<?php if($this->getUsers()->getUserId()): ?>
			<?php echo $this->childView('videos',array('videos' => $this->getUsers()->getVideos(),'video' => $this->getUsers()->getVideo(),'form_action' => $this->getUrl('users/addvideo',$this->getRequest()->query()),'delete_link' => 'users/deletevideo' ));?>			
		<?php else:?>
			<div class="alert alert-warning">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
				<strong><?php echo __('Warning!');?></strong>
				<?php echo __('Please add doctor details first');?>
			</div>
		<?php endif;?>

	</div>
    
    <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='tim'?"active":"";?>" id="tim"><?php echo $this->childView('schedule');?></div>
	*/?>
</div>


