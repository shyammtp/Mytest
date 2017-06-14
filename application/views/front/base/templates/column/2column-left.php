<!DOCTYPE html>
<head>
    <?php echo $this->childView('head');?>
</head>
<body class="<?php echo $this->getBodyClass();?>"> 
<?php echo $this->childView('noticemessages');?>
<div class="main-wrapper">
    <!--Header-->
    <?php echo $this->childView('header');?>
    <!--Header-->
    <div id="minheight">
	<section class="content <?php echo $this->getBodySectionClass();?>" id="<?php echo $this->getBodySectionId();?>">
        <div class="breadcrumb_out">
            <?php echo $this->childView('breadcrumbs');?>
        </div>
        <div class="profile_left">
            <?php echo $this->childView('left');?>
        </div>
        <div class="center_content_long">
            <?php echo $this->childView('maincontent');?>
        </div>
    </section>
	</div>
    <!--Footer-->
    <footer>
        <?php echo $this->childView('footer');?>
    </footer>
    <!--Footer-->
</div>
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
