<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>     
    <?php echo $this->addThemeJs('js/jquery-1.11.1.min.js');?>
</head>
<body class="<?php echo $this->getBodyClass();?>"> 
    <?php echo $this->childView('maincontent');?>  
</body>
</html>
 
