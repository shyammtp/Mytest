<?php $customer = App::model('admin/session')->getCustomer(); $profileimage = $customer->getProfileImageUrl(); ?>
<div class="media profile-left">
	<a class="pull-left profile-thumb">
		<?php if($profileimage):?>
		<span class="sidebar-profile-thumb-circle" style="background-image:url('<?php echo $profileimage;?>');background-repeat: no-repeat;"></span>
		<!--<img class="img-circle" src="<?php echo $profileimage;?>" alt="" >-->
		<?php else:?>
		<img class="img-circle" src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>" alt="" >
		<?php endif;?>
	</a>
	<div class="media-body">
		<h4 class="media-heading"><?php echo $customer->getFirstName();?></h4>
		  <a href="<?php echo $this->getUrl('admin/users/editprofile/',array('user'=> Encrypt::instance()->encode($customer->getUserId()), 'mode' => 'epf'));?>" class="text-muted"><?php echo __('Edit Profile');?></a>
	</div>
</div><!-- media -->

<h5 class="leftpanel-title"><?php echo __('Navigation');?></h5>
<ul class="nav nav-pills nav-stacked">
	<?php echo $this->getMenuLevel($this->getMenuConfig());?>

</ul>
<!-- END SIDEBAR MENU -->

