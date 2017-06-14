<?php $_user = $this->getUsers();
?>
<div class="edit_photo_page">
	    <h2><?php echo __('Photos'); ?></h2>
	    <div class="edit_photo_image">
		<?php
		echo $this->childView('photos', array('images' => $this->getGalleryImages($_user->getId()),
		    'upload_link' => $this->getUrl('settings/uploadgallery', array('id' => $_user->getId())),
		    'redirect_link' => App::helper('url')->getAccountUrl('account/media'),
		    'deletegallery_link' => $this->getUrl('settings/deletegallery'),
		    'primary_link' => $this->getUrl('settings/setthumbnail')
		));
		?>
	    </div>
	
	    <h2><?php echo __('Youtube Videos'); ?></h2>
	    <div class="edit_videos">
		<?php echo $this->childView('videos', array('videos' => $_user->getVideos(), 'video' => $_user->getVideo(), 'form_action' => $this->getUrl('settings/addvideo', $this->getRequest()->query()), 'delete_link' => 'settings/deletevideo')); ?>
	    </div>
</div>