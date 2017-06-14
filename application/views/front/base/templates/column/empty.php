<!DOCTYPE html>
<head>
    <?php echo $this->childView('head');?>
</head>
<body class="<?php echo $this->getBodyClass();?>">
<div class="main-wrapper"> 
   <?php echo $this->childView('maincontent');?>
</div>
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
