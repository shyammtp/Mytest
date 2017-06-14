<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <?php echo $this->childView('head');?>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
</head>
<body class="<?php echo $this->getBodyClass();?>">
    
    <?php echo $this->childView('header');?>
    <?php echo $this->getPageTitle();?>
    <?php echo $this->childView('noticemessages');?>
    <?php echo $this->childView('maincontent');?> 
    <?php echo $this->childView('footer');?> 
    <?php echo $this->childView('bottomincludes');?>
</body>
</html>
 
