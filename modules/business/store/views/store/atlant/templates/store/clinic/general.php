<?php 
$tabids = array('gin','gal','tim','vid');
$disabled = false;
?>

<ul class="nav nav-tabs nav-tabs-simple"> 
    <li class="<?php echo !in_array($this->getRequest()->query('tab'),$tabids) ||  $this->getRequest()->query('tab')=='gin'?"active":"";?>"><a href="<?php echo $this->getUrl('clinic/editclinic',Arr::merge($this->getRequest()->query(),array('tab' => 'gin')));?>" class="ctab"><strong><?php echo __('General Information');?></strong></a></li>
	
    <li class="<?php echo $this->getRequest()->query('tab')=='gal'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="<?php echo $this->getUrl('clinic/editclinic',Arr::merge($this->getRequest()->query(),array('tab' => 'gal')));?>"  class="ctab"><strong><?php echo __('Gallery');?></strong></a></li>
	<li class="<?php echo $this->getRequest()->query('tab')=='vid'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="<?php echo $this->getUrl('clinic/editclinic',Arr::merge($this->getRequest()->query(),array('tab' => 'vid')));?>"  class="ctab"><strong><?php echo __('Youtube Videos');?></strong></a></li>
	
    <li class="<?php echo $this->getRequest()->query('tab')=='tim'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="<?php echo $this->getUrl('clinic/editclinic',Arr::merge($this->getRequest()->query(),array('tab' => 'tim')));?>"  class="ctab"><strong><?php echo __('Time Schedule');?></strong></a></li>
	
</ul>
<div class="tab-content tab-content-simple mb30"> 
    <div class="tab-pane <?php echo !in_array($this->getRequest()->query('tab'),$tabids) || $this->getRequest()->query('tab')=='gin'?"active":"";?>" id="gin"><?php echo $this->childView('clinicedit');?></div>
   
    <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='gal'?"active":"";?>" id="gal">
		<?php if($this->getClinic()->getId()): ?>
			<?php echo $this->childView('gallery',array('images' => $this->getGalleryImages($this->getClinic()->getId()),
														'upload_link' => $this->getUrl('clinic/uploadgallery',array('id' => $this->getClinic()->getId())),
														'redirect_link' => $this->getUrl('clinic/editclinic',array('id' => $this->getClinic()->getId(),'tab' => 'gal','type'=>$this->getRequest()->query('type'))),
														'deletegallery_link' => $this->getUrl('clinic/deletegallery'),
														'primary_link' =>  $this->getUrl('clinic/setthumbnail'),
														'primary_text' => __('Set a :place_name thumbnail',array(':place_name' => App::registry('place_name'))),
														));?>
		<?php else:?>
			<div class="alert alert-warning">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
				<strong><?php echo __('Warning!');?></strong>
				<?php echo __('Please add :place_name details first',array(':place_name' => App::registry('place_name')));?>
			</div>
		<?php endif;?>
	</div>
      <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='vid'?"active":"";?>" id="vid">
		<?php if($this->getClinic()->getId()): ?>
			<?php echo $this->childView('videos',array('videos' => $this->getClinic()->getVideos(),'video' => $this->getClinic()->getVideo(),'form_action' => $this->getUrl('clinic/addvideo',$this->getRequest()->query()),'delete_link' => 'clinic/deletevideo' ));?>			
		<?php else:?>
			<div class="alert alert-warning">
				<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
				<strong><?php echo __('Warning!');?></strong>
				<?php echo __('Please add :place_name details first',array(':place_name' => App::registry('place_name')));?>
			</div>
		<?php endif;?>

	</div>
    <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='tim'?"active":"";?>" id="tim"><?php echo $this->childView('schedule');?></div>
	
</div>


