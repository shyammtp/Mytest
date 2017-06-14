<?php
$crumbs = $this->getCrumbs();
if($crumbs && is_array($crumbs)):  ?>
<ul class="breadcrumb">
	
	<?php foreach($crumbs as $_crumbName=>$_crumbInfo): ?>
		<li  class="<?php echo $_crumbName ?>">
			<?php if(isset($_crumbInfo['first'])): ?>
				<i class="icon-custom-home"></i>
			<?php endif; ?>
			<?php if(isset($_crumbInfo['link'])): ?>
				 <a href="<?php echo App::helper('store')->getStoreUrl($_crumbInfo['link']) ?>" title="<?php echo $_crumbInfo['title'] ?>"><?php echo $_crumbInfo['label'] ?></a>
			<?php elseif(isset($_crumbInfo['last'])): ?>
				<?php echo $_crumbInfo['label'] ?>
			<?php else: ?>
				<?php echo $_crumbInfo['label'] ?>
			<?php endif; ?>  
		<?php if(!isset($_crumbInfo['last'])): ?> 
			<i class="icon-angle-right"></i>
		<?php endif; ?>
		</li>
    <?php endforeach; ?>
</ul>

<?php endif; ?>
