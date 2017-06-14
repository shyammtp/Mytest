<div class="fixed_outer">
    <div class="fixed_inner">	
	<div class="full_white_box">
	    <div class="login_title">
		<h2> <?php echo __('Welcome to '); ?> <span class="clr2"><?php echo App::getConfig('SITE_NAME', Model_Core_Place::ADMIN); ?></span> </h2>		 
	    </div>
	    <div class="cms_content">
		<p>
		   <?php echo __('Book health appointments in seconds'); ?> 
		</p>
		<p>
		   <?php echo __('Over 9 people are already using '); ?><?php echo App::getConfig('SITE_NAME', Model_Core_Place::ADMIN); ?> 
		</p>
		<?php echo $this->getRootBlock()->createBlock('Cms/Block', 'welcome')->setIdentifier('welcome')->toHtml(); ?>
	    </div>
	</div>
    </div>
</div>

