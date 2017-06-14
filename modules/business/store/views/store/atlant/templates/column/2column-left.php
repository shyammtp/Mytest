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
<body class="<?php echo $this->getClassNames();?> page-container-boxed">
 <div class="page-container">
 	<!-- START PAGE SIDEBAR -->
    <div class="page-sidebar"  id="main-menu">
    	<?php echo $this->childView('leftmenu');?>
    	<?php echo $this->childView('additional');?>
    </div>
    <!-- PAGE CONTENT -->
    <div class="page-content"> 
    	<?php echo $this->childView('header');?>
		<?php echo $this->childView('breadcrumbs');?> 
    	<?php echo $this->childView('noticemessages');?>
    	<?php echo $this->childView('maincontent');?>
    </div>
    <?php echo $this->childView('additional2');?>
    <?php //echo $this->childView('footer');?>
 </div> 
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
