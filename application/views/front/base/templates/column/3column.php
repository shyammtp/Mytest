<!DOCTYPE html>
<head>
    <?php echo $this->childView('head');?>
</head>
<body class="<?php echo $this->getBodyClass();?>">
<div class="main-wrapper">
    <header>
        <!--Header-->
        <?php echo $this->childView('header');?>
        <!--Header-->
    </header>
    <div id="minheight">
    <section class="content <?php echo $this->getBodySectionClass();?>" id="<?php echo $this->getBodySectionId();?>">
        <div class="breadcrumb_out">
            <?php echo $this->childView('breadcrumbs');?>
        </div>
        <div class="profile_left">
            <?php echo $this->childView('left');?>
        </div>
        <div class="center_content">			
            <?php echo $this->childView('maincontent');?>
        </div>
         <div class="right-side">
            <?php echo $this->childView('right');?>
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
