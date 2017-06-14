<!DOCTYPE html>
<head>
    <?php echo $this->childView('head');?>
</head>
<body class="<?php echo $this->getBodyClass();?>">

<?php echo $this->childView('noticemessages');?>
    <!--Header-->
    <?php echo $this->childView('header');?>
    <!--Header-->  
	<section class="content <?php echo $this->getBodySectionClass();?>" id="<?php echo $this->getBodySectionId();?>">		
			<?php //echo $this->childView('breadcrumbs');?>       
            <?php echo $this->childView('maincontent');?>   
    </section>
    <!--Footer-->  
        <?php echo $this->childView('footer');?>   
    <!--Footer-->
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
