<?php
$crumbs = $this->getCrumbs();
if($crumbs && is_array($crumbs)):  ?>
<ul class="breadcrumb">
	<?php foreach($crumbs as $_crumbName=>$_crumbInfo): ?>
		<li  class="<?php echo $_crumbName ?>">
			<?php if(isset($_crumbInfo['first'])): ?>
				<i class="glyphicon glyphicon-home"></i>
			<?php endif; ?>
			<?php if(isset($_crumbInfo['link'])): ?>
			<?php $query=isset($_crumbInfo['query']) && is_array($_crumbInfo['query'])? $_crumbInfo['query'] :array();?>
				 <a href="<?php echo App::helper('admin')->getAdminUrl($_crumbInfo['link'],$query) ?>" title="<?php echo $_crumbInfo['title'] ?>"><?php echo __($_crumbInfo['label']) ?></a>
			<?php elseif(isset($_crumbInfo['last'])): ?>
				<?php echo __($_crumbInfo['label']) ?>
			<?php else: ?>
				<?php echo __($_crumbInfo['label']) ?>
			<?php endif; ?>
		<?php if(!isset($_crumbInfo['last'])): ?>
			<i class="icon-angle-right"></i>
		<?php endif; ?>
		</li>
    <?php endforeach; ?>
</ul>

<?php endif; ?>
 
