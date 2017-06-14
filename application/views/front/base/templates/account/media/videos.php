<?php $_user = $this->getUsers();
	$gimages = $this->getVideos(); 
?> 
<div class="general_form">
    <form method="post" action="<?php echo $this->getFormAction(); ?>">
	<input type="hidden" name="videopost" value="1" />
	<ul>
	    <li>
		<label><?php echo __('Title');?></label>
		<div class="input_fileds">
		    <input type="text" name="title" maxlength="150" value="<?php echo $this->getVideo('title'); ?>" class="form-control">
		</div>
	    </li>
	    <li>
		<label><?php echo __('Description');?></label>
		<div class="input_fileds">
		    <input type="text" name="description" maxlength="255" value="<?php echo $this->getVideo('description'); ?>" class="form-control">
		</div>
	    </li>
	    <li>	
		<label><?php echo __('Youtube URL');?></label>
		<div class="input_fileds">
		    <input type="text" name="video" value="<?php echo $this->getVideo('video'); ?>" class="form-control">
		</div>
	    </li>
	    <li>	
		<label class="empty_label">&nbsp;</label>
		<div class="input_fileds">
		    
		    <button type="submit" class="btn btn-primary"><?php echo __('Add');?></button>
		    <div id="errorBlock" class="help-block"><?php echo __('Please enter a valid youtube URL. Eg: https://www.youtube.com/watch?v=XXXXXXXXXXX');?></div>
		</div>
	    </li>	    
	</ul>
    </form>
</div>


<div class="video_listing">    
	<?php foreach ($gimages as $code => $vid): ?> 
    	<div class="image_box">
    	    <div class="thmb">
    		<div class="btn-group fm-group">
    		    <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
    			<span class="caret"></span>
    		    </button>
    			<ul class="dropdown-menu fm-menu pull-right" role="menu">
    				    
    			<li><a href="<?php echo $this->getUrl($this->getDeleteLink(), array_merge(array('vid' => $code), $this->getRequest()->query())); ?>"><i class="fa fa-trash-o"></i> <?php echo __('Delete'); ?></a></li>
    				      
    		    </ul>
    		</div><!-- btn-group -->
    		<div class="thmb-prev" style="height: 130px; overflow: hidden;">
    		    <a href="javascript:;" class="vide" data-vid="<?php echo $code; ?>">
    			<img src="<?php echo 'https://img.youtube.com/vi/' . $code . '/0.jpg'; ?>" class="img-responsive" alt="" width="210"  />
    		    </a>
    		</div> 
    		<h5><?php echo Arr::get($vid, 'title'); ?></h5>
    		<p><?php echo Arr::get($vid, 'description'); ?></p>
    	    </div><!-- thmb -->
    	</div><!-- col-xs-6 -->    		    
	<?php endforeach; ?>			    
  
</div>
<script>
	$(".vide").on('click',function(){ 
		var id = $(this).attr('data-vid'); 
		var yurl = 'https://www.youtube.com/embed/'+id;
		var embedtag = '<embed id="embedvideo" width="100%" height="400" src="'+yurl+'">';
		$("#embed").html(embedtag);
		setTimeout(function(){
			goToByScroll('embed');
		},500);
	});
	
	 
</script>
<div class="clearfix"></div>
<div id="embed"></div>  
