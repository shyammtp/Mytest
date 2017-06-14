<?php $gallery = $this->getGalleryImages(); 
$videos = $this->getVideos(); 
?>

<div class="detail_photos">
	<?php if(count($gallery)):?>
	<div class="deatil_photo_slider">
	<div id="sync2" class="owl-carousel">
		<?php foreach($gallery as $image): if($image['thumbnail'] == '1') { continue;} ?>
		<?php if($image['file'] && file_exists(DOCROOT.$image['file'])) {
				
				$imgsize = @getimagesize(DOCROOT.$image['file']);
				list($width, $height) =  $imgsize;
				$resizebyheight = false;
				if($height > $width) {
					$resizebyheight = true;
				}
				if($resizebyheight) { ?>
				<div class="item"><img src="<?php echo App::getBaseUrl('media').'cache/uploads/cache/h100/'.$image['file'];?>" alt="List Image" /></div>		
				<?php } else {  ?>				
				<div class="item"><img src="<?php echo App::getBaseUrl('media').'cache/uploads/cache/w100/'.$image['file'];?>" alt="List Image" /></div>
				<?php }  
			}
		?> 
		<?php endforeach;?> 			
	</div> 
	<div id="sync1" class="owl-carousel">
		<?php foreach($gallery as $image):  if($image['thumbnail'] == 1) { continue;}?>
		<?php if($image['file'] && file_exists(DOCROOT.$image['file'])) {
				
				$imgsize = @getimagesize(DOCROOT.$image['file']);
				list($width, $height) =  $imgsize;
				$resizebyheight = false;
				if($height > $width) {
					$resizebyheight = true;
				}
				if($resizebyheight) { ?>
				<div class="item"><img src="<?php echo App::getBaseUrl('media').'cache/uploads/cache/h800/'.$image['file'];?>" alt="List Image" /></div>		
				<?php } else {  ?>				
				<div class="item"><img src="<?php echo App::getBaseUrl('media').'cache/uploads/cache/w800/'.$image['file'];?>" alt="List Image" /></div>
				<?php }  
			}
		?> 
		<?php endforeach;?>  				 
	</div>    
	</div>
	<?php endif;?>
	<?php if(count($videos)): ?>
	<div class="deatil_video_slider">
	<h3><?php echo __('Videos');?></h3>
	<ul>
		<?php foreach($videos as $code => $v):?>
		<li>
		<span class="video_frame">
			<img src="<?php echo 'https://img.youtube.com/vi/'.$code.'/0.jpg';?>" alt="Video Image" width="195" />
		</span>
		<div class="video_list_content">
			<a href="#" data-toggle="modal" data-vid="<?php echo $code;?>" data-target="#myModal" class="vide" title="<?php echo Arr::get($v,'title');?>"><?php echo Arr::get($v,'title');?></a>
			<p><?php echo Arr::get($v,'description');?></p>
		</div>
		</li>
		<?php endforeach;?>  
	</ul>
	</div>
	<?php endif;?>
</div> 
 
 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
    <!-- Modal content-->
    <div class="modal-content"> 
      <div class="modal-body" id="videoembed">
        <p><?php echo __('Loading').'...';?></p>
      </div>
       
    </div>

  </div>
</div>
 
<script>
	$(".vide").on('click',function(){
		var ele = $(this);
		setTimeout(function() {
		var id = ele.attr('data-vid'); 
		var yurl = 'https://www.youtube.com/embed/'+id;
		var embedtag = '<embed id="embedvideo" width="100%" height="400" src="'+yurl+'">';
		$("#videoembed").html(embedtag);
		},1000);
	});
	
	 
</script>
