<!-- BEGIN MINI-PROFILE --> 
<?php 
$store_data = App::model('store/session');
$customer = $store_data->getCustomer();  
$profileimage = $customer->getProfileImageUrl();   
$adminlogo = App::getConfig('ADMIN_LOGO',Model_Core_Place::ADMIN); 
$storelogo = App::getConfig('STOREADMIN_LOGO',App::instance()->getPlace()->getId());
?>
<ul class="x-navigation">
    <li class="xn-logo">
        <a href="index.html">
	        <?php if($imagesrc = App::helper('image')->getResizeImage('w80',$adminlogo) ):?> 
	        	<img src="<?php echo $imagesrc;?>" alt="" />	
	        <?php else:?>
	        	ATLANT
	    	<?php endif;?> 
    	</a>
        <a href="#" class="x-navigation-control"></a>
    </li>                 
    <li class="xn-profile">
        <?php /* if($storelogo):?>
            <div class="">
                <img src="<?php echo App::helper('image')->getResizeImage('w200',$storelogo);?>" />
            </div>
        <?php endif; */?>
    	<?php if($profileimage):?> 
	        <a href="#" class="profile-mini">
	            <img src="<?php echo $profileimage;?>" alt="<?php echo $customer->getFirstName();?>" >
	        </a>
		<?php else:?> 
	        <a href="#" class="profile-mini">
	            <img src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>" alt="<?php echo $customer->getFirstName();?>" >
	        </a>
        <?php endif;?> 
        <div class="profile">
        	<?php if($profileimage):?>
            <div class="profile-image">
                <img src="<?php echo $profileimage;?>" alt="<?php echo $customer->getFirstName();?>" >
            </div>
        	<?php else:?> 
	        <div class="profile-image">
                <img src="<?php echo $this->getAssetsPathUrl('images/default_avatar_male.jpg');?>" alt="<?php echo $customer->getFirstName();?>" >
            </div>
            <?php endif;?>
            <div class="profile-data">
                <div class="profile-data-name"><?php echo $customer->getFirstName();?></div>
                <div class="profile-data-title"><?php echo $customer->getPrimaryEmailAddress();?></div>
            </div>
           <!--  <div class="profile-controls">
                <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
            </div> -->
        </div>         
        <div class="profile">
            <span class="label label-warning label-form">Demo Mode</span>
            <span class="label label-success label-form">Live</span>
        </div>                                                               
    </li>                                  
    <li class="xn-title">Navigation</li>
    <?php echo $this->getMenuLevel($this->getMenuConfig());?> 
</ul>


