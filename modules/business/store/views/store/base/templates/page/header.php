 <header>
	
	 <?php  
		$session = App::model('store/session');
		$place = '';
		$url = '';
		$customer = App::model('store/session')->getCustomer();  
		$currentUrl = App::helper('url')->getCurrentUrlNoDomain();  
		$place=__('Edit Info'); 
		$url=$this->getUrl('store/edit/',array('id' => App::instance()->getPlace()->getEntityPrimaryId()));
		$customer = App::model('store/session')->getCustomer(); 
	 ?>  
	<div class="headerwrapper">
	<div class="header-left">
		<a href="<?php echo $this->getUrl('dashboard/index');?>" class="logo" style="height:45px;overflow:hidden;">
			<img src="<?php echo $this->getLogo();?>" alt="<?php //echo $placeinfo->getPlaceName();?>" width="140"  />
		</a>
		<div class="pull-right">
			<a href="#" class="menu-collapse">
				<i class="fa fa-bars"></i>
			</a>
		</div>
	</div><!-- header-left -->

	<div class="header-right">
		<div class="custom-button col-md-2">
		
		 <?php $languages = App::model('core/language')->getOptionArray();?>
		<div class="custom-button col-md-4">
			<div class="btn-group mr5">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				  <?php echo App::getCurrentLang()->getName();?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				<?php if(count($languages)):?>
					<?php foreach($languages as $value => $label):?>
						<li class="<?php echo App::getCurrentLang()->getLanguageCode() == $value? "active":"";?>"><a href="<?php echo $this->getUrl('',array('__current' => true,'___lang' => $value));?>"><i class="glyphicon glyphicon-globe"></i>&nbsp;<?php echo $label;?></a></li>
					<?php endforeach;?>
				  <?php endif;?> 
				</ul>
			  </div> 
		</div> 
		
		
		
			<div class="pull-right">
			<div class="btn-group btn-group-option">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				  <i class="fa fa-caret-down"></i>
				</button>				
				<ul class="dropdown-menu pull-right" role="menu">
				  <li> <a href="<?php echo $this->getUrl('users/editprofile',array('user'=> Encrypt::instance()->encode(App::model('store/session')->getCustomer()->getUserId()), 'mode' => 'epf'));?>"><i class="glyphicon glyphicon-user"></i><?php echo __('My Profile');?></a></li>
				  
				 
				  <!--<li><a href="#"><i class="glyphicon glyphicon-star"></i><?php //echo __('Activity Log');?></a></li>-->
				  <?php //if(App::model('store/session')->getIsOwner()){ ?>
				  
				  <?php //} ?>
				  <li class="divider"></li>
				  <li><a href="<?php echo $this->getUrl('index/logout');?>"><?php echo __('Sign Out');?></a></li>
				</ul>
			</div><!-- btn-group -->

		</div><!-- pull-right -->

	</div><!-- header-right -->

</div><!-- headerwrapper -->


</header>


<script type="text/javascript">
 $(document).ready( function() {
    if ( $(window).width() < 900) {
		$('.menu-collapse').click(function(){
     $('div.mainwrapper').removeClass('collapsed');
 });
    }
    $( "#renw_sub_buttn" ).click(function() {
	  $('.sub_form').show();
	  $('#renw_sub_buttn').hide();
	});
    $( "#renw_sub_buttn1" ).click(function() {
	  $('.sub_form1').show();
	  $('#renw_sub_buttn1').hide();
	});
 });
</script>

<script type="text/javascript">
$(document).on('click', function(e){
   if (! $(e.target).closest('.popover.in').length &&  (! $(e.target).closest('#switch-acc').length))
       $('.popover').hide();
});
</script>
 <header>
	
	 <?php  
		$session = App::model('store/session');
		$place = '';
		$url = '';
		$customer = App::model('store/session')->getCustomer();  
		$currentUrl = App::helper('url')->getCurrentUrlNoDomain();  
		$place=__('Edit Info'); 
		$url=$this->getUrl('store/edit/',array('id' => App::instance()->getPlace()->getEntityPrimaryId()));
		$customer = App::model('store/session')->getCustomer(); 
	 ?>  
	<div class="headerwrapper">
	<div class="header-left">
		<a href="<?php echo $this->getUrl('dashboard/index');?>" class="logo" style="height:45px;overflow:hidden;">
			<img src="<?php echo $this->getLogo();?>" alt="<?php //echo $placeinfo->getPlaceName();?>" width="140"  />
		</a>
		<div class="pull-right">
			<a href="#" class="menu-collapse">
				<i class="fa fa-bars"></i>
			</a>
		</div>
	</div><!-- header-left -->

	<div class="header-right">
		<div class="custom-button col-md-12">
		
		 <?php /* $languages = App::model('core/language')->getOptionArray();?>
		<div class="custom-button col-md-4">
			<div class="btn-group mr5">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
				  <?php echo App::getCurrentLang()->getName();?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
				<?php if(count($languages)):?>
					<?php foreach($languages as $value => $label):?>
						<li class="<?php echo App::getCurrentLang()->getLanguageCode() == $value? "active":"";?>"><a href="<?php echo $this->getUrl('',array('__current' => true,'___lang' => $value));?>"><i class="glyphicon glyphicon-globe"></i>&nbsp;<?php echo $label;?></a></li>
					<?php endforeach;?>
				  <?php endif;?> 
				</ul>
			  </div> 
		</div>  */ ?>
		
		
		
			<div class="pull-right">
			<div class="btn-group btn-group-option">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				  <i class="fa fa-caret-down"></i>
				</button>				
				<ul class="dropdown-menu pull-right" role="menu">
				  <li> <a href="<?php echo $this->getUrl('users/editprofile',array('user'=> Encrypt::instance()->encode(App::model('store/session')->getCustomer()->getUserId()), 'mode' => 'epf'));?>"><i class="glyphicon glyphicon-user"></i><?php echo __('My Profile');?></a></li>
				  
				 
				  <!--<li><a href="#"><i class="glyphicon glyphicon-star"></i><?php //echo __('Activity Log');?></a></li>-->
				  <?php //if(App::model('store/session')->getIsOwner()){ ?>
				  
				  <?php //} ?>
				  <li class="divider"></li>
				  <li><a href="<?php echo $this->getUrl('index/logout');?>"><?php echo __('Sign Out');?></a></li>
				</ul>
			</div><!-- btn-group -->

		</div><!-- pull-right -->

	</div><!-- header-right -->

</div><!-- headerwrapper -->


</header>


<script type="text/javascript">
 $(document).ready( function() {
    if ( $(window).width() < 900) {
		$('.menu-collapse').click(function(){
     $('div.mainwrapper').removeClass('collapsed');
 });
    }
    $( "#renw_sub_buttn" ).click(function() {
	  $('.sub_form').show();
	  $('#renw_sub_buttn').hide();
	});
    $( "#renw_sub_buttn1" ).click(function() {
	  $('.sub_form1').show();
	  $('#renw_sub_buttn1').hide();
	});
 });
</script>

<script type="text/javascript">
$(document).on('click', function(e){
   if (! $(e.target).closest('.popover.in').length &&  (! $(e.target).closest('#switch-acc').length))
       $('.popover').hide();
});
</script>
