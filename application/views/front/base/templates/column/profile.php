<!DOCTYPE html>
<head>
    <?php echo $this->childView('head');?>
</head>
<body class="<?php echo $this->getBodyClass();?>">

<?php echo $this->childView('noticemessages');?>
    <!--Header-->
    <?php echo $this->childView('header');?>
    <!--Header-->
	<?php echo $this->childView('breadcrumbs');?> 
	<?php echo $this->childView('topmenu');?>
	
	<section class="content <?php echo $this->getBodySectionClass();?>" id="<?php echo $this->getBodySectionId();?>">		
		<div class="fixed_outer">
			<div class="fixed_inner">	
				<div class="full_white_box"> 
				<?php echo $this->childView('maincontent');?> 
				</div>	
			</div>
		</div>  
    </section>
    <!--Footer-->  
        <?php echo $this->childView('footer');?>   
    <!--Footer-->
<?php echo $this->childView('bottomincludes');?>
</body>
</html>
