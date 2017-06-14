<?php
$crumbs = $this->getCrumbs();
if($crumbs && is_array($crumbs)):  ?>
<div class="fixed_outer">
	<div class="fixed_inner">	
		<div class="breadcrumb">
			<ul>
				<?php foreach($crumbs as $_crumbName=>$_crumbInfo): ?>
					<?php $query = array();
					if(isset($_crumbInfo['query'])):
						$query = $_crumbInfo['query'];
					endif;?>
					<li  class="<?php echo $_crumbName ?>">
						<?php if(isset($_crumbInfo['first'])): ?> 
						<?php endif; ?>
						<?php if(isset($_crumbInfo['link'])): ?>
						<?php if(isset($_crumbInfo['relative']) && $_crumbInfo['relative']==true): ?>
							 <a href="<?php echo $_crumbInfo['link']; ?>" title="<?php echo __($_crumbInfo['title']) ?>"><?php echo __($_crumbInfo['label']) ?></a>
								<?php echo isset($_crumbInfo['after']) && $_crumbInfo['after'] ? $_crumbInfo['after']: "";?>
							 <?php else:?>
							<?php if(isset($_crumbInfo['account'])): ?>
							 <a href="<?php echo App::helper('url')->getAccountUrl($_crumbInfo['link'],$query) ?>" title="<?php echo __($_crumbInfo['title']) ?>"><?php echo __($_crumbInfo['label']) ?></a>
							 <?php else:?>
							 <a href="<?php echo $this->getUrl($_crumbInfo['link'],$query) ?>" title="<?php echo __($_crumbInfo['title']) ?>"><?php echo __($_crumbInfo['label']) ?></a>
							 <?php endif;?>
							 <?php echo isset($_crumbInfo['after']) && $_crumbInfo['after'] ? $_crumbInfo['after']: "";?>
							 <?php endif;?>
						<?php elseif(isset($_crumbInfo['last'])): ?>
							<p><?php echo __($_crumbInfo['label']) ?></p>
							<?php echo isset($_crumbInfo['after']) && $_crumbInfo['after'] ? $_crumbInfo['after']: "";?>
						<?php else: ?>
							<p><?php echo __($_crumbInfo['label']) ?></p>
						<?php endif; ?>  
					<?php if(!isset($_crumbInfo['last'])): ?> 
						<i class="icon-angle-right"></i>
					<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul> 
		</div>	
    </div>
</div>
<?php endif; ?> 