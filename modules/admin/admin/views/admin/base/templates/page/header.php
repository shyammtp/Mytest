<header> 
	 <?php $currentUrl = App::helper('url')->getCurrentUrlNoDomain();?>
	<div class="headerwrapper">
	<div class="header-left">
		<a href="<?php echo $this->getUrl('admin/dashboard/index');?>" class="logo">
			<img src="<?php echo $this->getLogo();?>" alt="" width="140" title="<?php echo App::getConfig('SITE_NAME',Model_Core_Place::ADMIN); ?>" />
		</a>
		
		<div class="pull-right">
			<a href="#" class="menu-collapse" title="Menu Toggle">
				<i class="fa fa-bars"></i>
				 
			</a>
		</div>
		
	</div><!-- header-left -->

	<div class="header-right">
		<div class="pull-right">
			<div class="btn-group btn-group-list btn-group-notification">
				<?php /** <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Notifications">
				  <i class="fa fa-bell-o" title="Notifications"></i> 
				  <span class="badge" title="Notifications"><?php echo count($notifications); ?></span>
				</button> **/?>
				<div class="dropdown-menu pull-right">
					<a href="#" class="link-right"><i class="fa fa-search"></i></a>
					<h5><?php echo __('Notification');?></h5>
					<ul class="media-list dropdown-list">
						<?php if(!empty($notifications)) { ?>
						<?php foreach($notifications as $notification) { ?>
						<?php if($notification['reply_status'] == true) { ?>
							<a href="<?php echo $this->getUrl('admin/system/reply_message',array('id'=>$notification['msgid'])); ?>">
						<?php } ?>
						<li class="media">
							<!--<img class="img-circle pull-left noti-thumb" src="images/photos/user1.png" alt="">-->
							<div class="media-body">
							  <strong><b><?php echo $notification['user']; ?></b>
							   <?php 
								  $stringSubject = strip_tags($notification['subject']);
								  $strsublen = strlen($stringSubject);
								  if($strsublen > 25) {
									  $strSubjectContent = substr($stringSubject,0,25).'....';
								  } else {
									  $strSubjectContent = $stringSubject;
								  }								  
								  ?>
							  </strong><?php echo $strSubjectContent; ?><strong>
								  <b>
								  <?php 
								  $string = strip_tags($notification['message']);
								  $strlen = strlen($string);
								  if($strlen > 25) {
									  $strMessage = substr($string,0,25).'....';
								  } else {
									  $strMessage = $string;
								  }
								  echo $strMessage;
								  ?>
								  </b></strong>
								  <?php 
									switch($notification['priority']) {
										case 'normal':
											$notificationpriority = 'default';
											break;
										case 'urgent':
											$notificationpriority = 'warning';
											break;
										case 'important':
											$notificationpriority = 'success';
											break;
										case 'error':
											$notificationpriority = 'danger';
											break;										 
									}										
								  ?>
								  <span class="label label-<?php echo $notificationpriority; ?>"><?php echo ucfirst($notification['priority']); ?></span>
								  
							  <small class="date"><i class="fa fa-calendar"></i><?php echo date("M d,Y h:i A", strtotime($notification['date'])); ?></small>
							</div>
						</li>
						<?php if($notification['reply_status'] == true) { ?>
							</a>
						<?php } ?>
						<?php } ?>
						<?php } else { ?>
						 <li class="media">No Notifications Found</li>
						<?php } ?>
					</ul>
					<div class="dropdown-footer text-center">
						<a href="<?php echo $this->getUrl('admin/system/inbox/'); ?>" class="link">See All Notifications</a>
					</div>
				</div><!-- dropdown-menu -->
			</div><!-- btn-group -->
	  
			<div class="btn-group btn-group-option">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Profile">
				  <i class="fa fa-caret-down" title="Profile"></i>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
				  <li><a href="<?php echo $this->getUrl('admin/users/editprofile',array('user'=> Encrypt::instance()->encode(App::model('admin/session')->getCustomer()->getUserId()), 'mode' => 'epf' ,'name'=>'3'));?>"><i class="glyphicon glyphicon-user"></i><?php echo __('My Profile');?></a></li>
				  <li><a href="<?php echo $this->getUrl('admin/users/viewprofile',array('user'=> Encrypt::instance()->encode(App::model('admin/session')->getCustomer()->getUserId()), 'mode' => 'epf'));?>"><i class="glyphicon glyphicon-star"></i><?php echo __('Activity Log');?></a></li> 
				  <?php /** 
				  <li><a href="#"><i class="glyphicon glyphicon-cog"></i> Account Settings</a></li>
				  
				  <li><a href="#"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
				  * **/ ?>
				  <li class="divider"></li>
				  <li><a href="<?php echo $this->getUrl('admin/index/logout');?>"><i class="glyphicon glyphicon-log-out"></i><?php echo __('Sign Out');?></a></li>
				</ul>
			</div><!-- btn-group -->

		</div><!-- pull-right -->

	</div><!-- header-right -->

</div><!-- headerwrapper -->
</header>
<script>
	$(function(){
		var currentpage = '<?php echo $currentUrl;?>';
		var pagetitle = "<?php echo addslashes($this->getRootBlock()->getBlock('head')->getTitle());?>";
		$(".add_quick_access").click(function(){
			var method = $(this).data('method');
			$.ajax({
				url:'<?php echo $this->getUrl('admin/settings/addquickacess');?>',
				type:'post',
				dataType:'json',
				data:{pageurl:currentpage, method:method,name:pagetitle},
				success:function(html){
					if (html.success) {
						alert(html.success);
						location.reload();
					}
					if (html.error) {
						alert(html.error);
					}
				}
			});
		});
	 $(document).on('click',"#search-lists li",function(e){
		  var link = $(this).data('link');
		  window.location.href=link;
	 });
	  $(".headsearch").bindWithDelay("keyup",function(e){
		  
	   if (e.keyCode === 27 || e.keyCode === 37 || e.keyCode === 38 || e.keyCode === 39) {
			return false;
	   }
	   var term = $(this).val();
	   if (term.length > 2) {
		  $.ajax({
			   url:'<?php echo $this->getUrl('admin/search/keyword');?>',
			   type:'get',
			   dataType:'html',
			   cache:true,
			   data:{q:term},
			   beforeSend:function(){
				   $("#hdsrch_btn").html('<img alt="" width="15" src="<?php echo $this->getAssetsPathUrl('images/loaders/loader13.gif');?>">');
			   },
			   success:function(html){
				   $("#search-lists").show().html(html);
				   $("#hdsrch_btn").html('<i class="glyphicon glyphicon-search"></i>');
			   }
		   });
	   } else {
		  $("#search-lists").hide();
	   }

	 }, 600);

	 $("#hdsrch_btn").click(function(){
	   var term = $(".headsearch").val();
	   if (term.length > 2) {
		  $.ajax({
			   url:'<?php echo $this->getUrl('admin/search/keyword');?>',
			   type:'get',
			   dataType:'html',
			   data:{q:term},
			   beforeSend:function(){
				   $("#hdsrch_btn").html('<img alt="" width="15" src="<?php echo $this->getAssetsPathUrl('images/loaders/loader13.gif');?>">');
			   },
			   success:function(html){
				   $("#search-lists").show().html(html);
				   $("#hdsrch_btn").html('<i class="glyphicon glyphicon-search"></i>');
			   }
		   });
	   } else {
		  $("#search-lists").hide();
	   }

	 });

	});
</script>
<script type="text/javascript">
 $(document).ready( function() {
    if ( $(window).width() < 900) {
		$('.menu-collapse').click(function(){
     $('div.mainwrapper').removeClass('collapsed');
 });
    }
 });
</script>
