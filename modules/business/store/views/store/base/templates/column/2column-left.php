<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	
    <?php echo $this->childView('head');?>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
	<link rel="shortcut icon" href="<?php echo App::getBaseUrl().App::getConfig("FAVICON",Model_Core_Place::ADMIN);?>" type="image/x-icon">
</head>
<body class="<?php echo $this->getClassNames();?>">
<!-- BEGIN TOP NAVIGATION BAR -->
        <?php echo $this->childView('header');?>
<!-- END TOP NAVIGATION BAR -->

<!-- BEGIN CONTAINER -->

<section>
    <div class="mainwrapper">
		<div class="page-container row-fluid">
			<!-- BEGIN SIDEBAR -->
			<div class="leftpanel" id="main-menu">
				<?php echo $this->childView('leftmenu');?>
			</div>
			<?php /*<div class="footer-widget" style="display: block;">
				<div class="transparent progress-small no-radius no-margin pull-left">
					Test Store @ 2015
				</div>
				<div class="pull-right">

				<a href="http://www.ndotblinkbee1.com/storeadmin/index/logout/?token=7322c59551800c5b9274b56b5ae9926d" title="Logout"><i class="fa fa-power-off"></i></a></div>
			</div> */ ?>
			<?php echo $this->childView('additional');?>
			<!-- END SIDEBAR -->

			<!-- BEGIN PAGE -->
			<div class="page-content mainpanel">
				<div class="pageheader">
					<div class="media">
						<div class="media-body">
							<?php echo $this->childView('breadcrumbs');?> 
							<h4><?php echo $this->getTitleIcon();?><?php echo $this->getPageTitle();?></h4>
						</div>
					</div><!-- media -->
				</div><!-- pageheader -->
				<div class="contentpanel">
					<?php echo $this->childView('noticemessages');?>
					<?php echo $this->childView('maincontent');?>
				</div>
				<div class="clearfix"></div>
				<?php echo $this->childView('additional2');?>
			</div>
			<!-- BEGIN PAGE -->
		</div>
	</div>
</section>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="footer">
    <?php echo $this->childView('footer');?>
</div>
<div class="loader-com">Loading...</div> 
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
