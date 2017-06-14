<?php
$maincategory = $this->getStore()->getStoreMainCategory();
$subcategory = $this->getStore()->getStoreSubCategory();
$tabids = array('gin','pr_sr','tgs','gal');
$disabled = false;
if(!$this->getStore()->getStoreId()) {
    $disabled = true;
}
if($this->getStore()->getStoreId()):?>
<?php endif;?>
<ul class="nav nav-tabs nav-tabs-simple">
    <li class="<?php echo !in_array($this->getRequest()->query('tab'),$tabids) || $this->getRequest()->query('tab')=='gin'?"active":"";?>"><a href="#gin" data-toggle="tab"><strong><?php echo __('General Information');?></strong></a></li>
    <?php /* ?><li class="<?php echo $this->getRequest()->query('tab')=='pr_sr'?"active":"";?> <?php echo $disabled ?"disabled":"";?>"><a href="#pr_sr" <?php if(!$disabled):?>data-toggle="tab"<?php endif;?>><strong><?php echo __('Product / Services');?></strong></a></li> <?php */ ?>
    <li class="<?php echo $this->getRequest()->query('tab')=='gal'?"active":"";?> <?php echo $disabled?"disabled":"";?>"><a href="#gal" <?php if(!$disabled):?>data-toggle="tab"<?php endif;?>><strong><?php echo __('Gallery');?></strong></a></li>
    
</ul>
<div class="tab-content tab-content-simple mb30">
    <div class="tab-pane <?php echo !in_array($this->getRequest()->query('tab'),$tabids) || $this->getRequest()->query('tab')=='gin'?"active":"";?>" id="gin"><?php echo $this->childView('general_info');?></div>
    <?php /* ?><div class="tab-pane <?php echo $this->getRequest()->query('tab')=='pr_sr'?"active":"";?>" id="pr_sr"><?php echo $this->childView('productservice');?></div><?php */ ?>
    <div class="tab-pane <?php echo $this->getRequest()->query('tab')=='gal'?"active":"";?>" id="gal"><?php echo $this->childView('gallery');?></div>

</div>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
