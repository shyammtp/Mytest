<?php  
	$gimages = $this->getVideos(); 
?> 
<div class="row">

	<div class="col-sm-12">
	  <div class="media-manager-sidebar">
		
		<form method="post" action="<?php echo $this->getFormAction();?>">
			
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Title</label>
						<input type="text" name="title" maxlength="150" value="<?php echo $this->getVideo('title');?>" class="form-control">
					</div><!-- form-group -->
				</div><!-- col-sm-6 -->
				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Description</label>
						<input type="text" name="description" maxlength="255" value="<?php echo $this->getVideo('description');?>" class="form-control">
					</div><!-- form-group -->
				</div><!-- col-sm-6 -->
			</div>

			<div class="form-group">
			   <div class="input-group mb15">
					<input type="text" name="video" value="<?php echo $this->getVideo('video');?>" class="form-control">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary">Add</button>
					</span>
				</div>
				<div id="errorBlock" class="help-block">Please enter a valid youtube URL. Eg: https://www.youtube.com/watch?v=XXXXXXXXXXX</div>
			</div>
		</form>
		<div class="mb30"></div>

	  </div>
	</div><!-- col-sm-3 -->

	<div class="col-sm-12">
	  <div class="row media-manager">

		<?php foreach($gimages as $code => $vid):?> 
		<div class="col-xs-6 col-sm-4 col-md-3 image">
		  <div class="thmb">
			<div class="btn-group fm-group">
				<button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
				  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu fm-menu pull-right" role="menu">
				  
				  <li><a href="<?php echo $this->getUrl($this->getDeleteLink(),array_merge(array('vid' => $code),$this->getRequest()->query()));?>"><i class="fa fa-trash-o"></i> <?php echo __('Delete');?></a></li>
				  
				</ul>
			</div><!-- btn-group -->
			<div class="thmb-prev" style="height: 130px; overflow: hidden;">
			  <a href="javascript:;" class="vide" data-vid="<?php echo $code;?>">
				<img src="<?php echo 'https://img.youtube.com/vi/'.$code.'/0.jpg';?>" class="img-responsive" alt="" width="210"  />
			  </a>
			</div> 
			 <h5 class="fm-title" title='<?php echo Arr::get($vid,'title');?>'><?php echo Arr::get($vid,'title');?></h5>
            <small class="text-muted" title='<?php echo Arr::get($vid,'description');?>'><?php echo Text::limit_words(Arr::get($vid,'description'),5);?></small>
		  </div><!-- thmb -->
		</div><!-- col-xs-6 -->
		
		<?php endforeach; ?>

	  </div><!-- row -->


	</div><!-- col-sm-9 -->
  </div>
<script>
	$(".vide").on('click',function(){ 
		var id = $(this).attr('data-vid'); 
		var yurl = 'https://www.youtube.com/embed/'+id;
		var embedtag = '<embed id="embedvideo" width="100%" height="400" src="'+yurl+'">';
		$("#embed").html(embedtag);
		setTimeout(function(){
			goToByScroll('embed');
		},1000);
	});
	
	 
</script>
<div id="embed"></div>  
