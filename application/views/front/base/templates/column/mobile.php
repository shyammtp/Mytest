<!DOCTYPE html>
<head>
    <?php echo $this->childView('head');?>
</head>
<body class="<?php //echo $this->getBodyClass();?>">

   <?php echo $this->childView('maincontent');?>
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
