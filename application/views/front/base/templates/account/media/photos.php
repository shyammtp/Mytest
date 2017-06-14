<?php $_user = $this->getUsers(); ?> 
<div class="media-manager-sidebar">
    <div class="form-group">
	<input id="file-3" type="file" name="gallery_image" multiple=true>
	<div id="errorBlock" class="help-block"></div>
    </div>
</div>

<?php
$gimages = $this->getImages();
foreach ($gimages as $images):
    ?>
    <?php if (file_exists(DOCROOT . $images['file'])): $thumbnail = (bool) $images['thumbnail']; ?>
	<div class="image_box">
	    <div class="btn-group fm-group">
		<button type="button" class="btn btn-default dropdown-toggle fm-toggle custom-drop" data-toggle="dropdown">
		    <span class="caret"></span>
		</button>
		<ul class="dropdown-menu fm-menu pull-right" role="menu">
		    <li><a href="<?php echo App::getBaseUrl('uploads') . $images['file']; ?>" download="<?php echo App::getBaseUrl('uploads') . $images['file']; ?>" target="_blank"><i class="fa fa-download"></i><?php echo __('Download'); ?></a></li>
		    <li><a href="javascript:deleteimage('<?php echo base64_encode($images['file']); ?>','<?php echo $images['primary_id']; ?>')"><i class="fa fa-trash-o"></i> <?php echo __('Delete'); ?></a></li>
		    <?php /*if ($images['thumbnail'] == '0'): ?>
	    	    <li><a href="javascript:setthumbnail('<?php echo base64_encode($images['file']); ?>','<?php echo $images['primary_id']; ?>')"><i class="fa fa-file-image-o"></i> <?php echo $this->getPrimaryText() ? $this->getPrimaryText() : __('Set as thumbnail'); ?></a></li>
	<?php endif; */?>
		</ul>
	    </div><!-- btn-group -->
	    <div class="image_box_image" >
		<a href="<?php echo App::getBaseUrl('uploads') . 'cache/uploads/cache/thumb_500x500/' . $images['file']; ?>" data-rel="prettyPhoto" target="_blank">
		    <img src="<?php echo App::getBaseUrl('uploads') . 'cache/uploads/cache/thumb_500x500/' . $images['file']; ?>" class="" alt=""  />
		</a>
	    </div>
	    <?php if ($images['thumbnail'] == '1'): ?>
	        <div class="fa fa-thumb-tack" title="<?php echo __('Default thumbnail'); ?>"></div>
	<?php endif; ?>
	    <h5><?php echo basename($images['file']); ?></h5>
	    <p><?php echo __('Added: :date', array(':date' => date("M d, Y", strtotime($images['added_on'])))); ?></p>
	</div>
    <?php endif; ?>
<?php endforeach; ?>		



<script>
    $(window).load(function(){ 
        $("#file-3").fileinput({
            showUpload: true,
            showPreview : true,
            browseLabel:'<?php echo __('Browse'); ?>',
			removeLabel : '<?php echo __('Remove'); ?>',
			uploadLabel : '<?php echo __('Upload'); ?>',
			dropZoneTitle : '<?php echo __('Drag & drop files here'); ?> &hellip;',
            browseIcon: '&nbsp;',
            browseClass: "btn btn-primary",
			cancelClass : "btn btn-primary btn-file cancelfileinputclass", 
            allowedFileExtensions : ['jpg','png','gif','jpeg'],
            uploadUrl: '<?php echo $this->getUploadLink(); ?>',
            uploadExtraData: [
                {id: '<?php //echo $this->getUsers()->getUserId();  ?>'}
            ],
            elErrorContainer: '#errorBlock'
        });
	$('#file-3').on('filebatchuploadcomplete', function(event, data, previewId, index) {
	    console.log('Image upload complete');
	    window.location.href = '<?php echo $this->getRedirectLink(); ?>';
	    //location.reload();
	});
    });

    function deleteimage(image, id) {
	var conf = confirm("<?php echo __('Are you sure want to delete?'); ?>");
	if (conf) {
	    $.ajax ({
		url:"<?php echo $this->getDeletegalleryLink(); ?>",
		type:'get',
		dataType:'json',
		data: {image:image,id:id},
		success:function(jsondata) {
		    console.log(jsondata);
		    if(jsondata.success) {
			window.location.href="<?php echo $this->getRedirectLink(); ?>";
		    }
		}
	    });
	}
    }


    function setthumbnail(image, id) {
	$.ajax ({
	    url:"<?php echo $this->getPrimaryLink(); ?>",
	    type:'get',
	    dataType:'json',
	    data: {image:image,id:id},
	    success:function(jsondata) {
		if(jsondata.success) {
		    window.location.href="<?php echo $this->getRedirectLink(); ?>";
		}
	    }
	});
    }

    $(function(){

	jQuery('.thmb').hover(function() {
	    var t = jQuery(this);
	    t.find('.fm-group').show();
	}, function() {

	    var t = jQuery(this);
	    if(!t.closest('.thmb').hasClass('checked')) {
		t.find('.fm-group').hide();
	    }
	});

    });
</script> 