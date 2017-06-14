<?php 
if($this->getClinic()->getClinicId()):
	$gimages = $this->getGalleryImages($this->getClinic()->getClinicId());
	
?>
    <div class="row">

        <div class="col-sm-12">
			<form method="post" id="clinic_form" class="tab-form attribute_form" action="<?php echo $this->getUrl('clinic/saveclinic',$this->getRequest()->query());?>" accept-charset="UTF-8" enctype="multipart/form-data" >
          <div class="media-manager-sidebar">

            <div class="form-group">
                <input id="file-3" type="file" name="company_image" multiple=true>
                <div id="errorBlock" class="help-block"></div>
            </div>

            <div class="mb30"></div>

          </div>
        </div><!-- col-sm-3 -->

        <div class="col-sm-12">
          <div class="row media-manager">

            <?php foreach($gimages as $images):?>
            <?php if(file_exists(DOCROOT.$images['file'])): $thumbnail = (bool)$images['thumbnail'];?>
            <div class="col-xs-6 col-sm-4 col-md-3 image">
              <div class="thmb">
                <div class="btn-group fm-group">
                    <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu fm-menu pull-right" role="menu">
                      <li><a href="<?php echo App::getBaseUrl('uploads').$images['file'];?>" download="<?php echo App::getBaseUrl('uploads').$images['file'];?>" target="_blank"><i class="fa fa-download"></i><?php echo __('Download');?></a></li>
                      <li><a href="javascript:deleteimage('<?php echo base64_encode($images['file']);?>','<?php echo $images['user_id'];?>')"><i class="fa fa-trash-o"></i> <?php echo __('Delete');?></a></li>
                      <?php if($images['thumbnail'] == 'f'):?>
                      <li><a href="javascript:setthumbnail('<?php echo base64_encode($images['file']);?>','<?php echo $images['user_id'];?>')"><i class="fa fa-file-image-o"></i> <?php echo __('Set as thumbnail');?></a></li>
                      <?php endif;?>
                    </ul>
                </div><!-- btn-group -->
                <div class="thmb-prev" style="height: 130px; overflow: hidden;">
                  <a href="<?php echo App::getBaseUrl('uploads').'cache/uploads/cache/thumb_500x500/'.$images['file'];?>" data-rel="prettyPhoto" target="_blank">
                    <img src="<?php echo App::getBaseUrl('uploads').'cache/uploads/cache/thumb_500x500/'.$images['file'];?>" class="img-responsive" alt=""  />
                  </a>
                </div>
                <?php if($images['thumbnail'] == 't'):?>
                <div class="fa fa-thumb-tack" title="<?php echo __('Default thumbnail');?>" style="position: absolute;color:rgb(255, 106, 57); top:12px; font-size: 18px; left:12px;"></div>
                <?php endif;?>
                <h5 class="fm-title"><?php echo basename($images['file']);?></h5>
                <small class="text-muted"><?php echo __('Added: :date',array(':date' => date("M d, Y",strtotime($images['added_on']))));?></small>
              </div><!-- thmb -->
            </div><!-- col-xs-6 -->
            <?php endif;?>
            <?php endforeach;?>

          </div><!-- row -->

		</form>
        </div><!-- col-sm-9 -->
      </div>
<script>
$(window).load(function(){
        $("#file-3").fileinput({
            showUpload: true,
            showPreview : true,
            browseLabel:'<?php echo __('Browse');?>',
            browseIcon: '&nbsp;',
            browseClass: "btn btn-primary",
            allowedFileExtensions : ['jpg','png','gif','jpeg'],
            uploadUrl: '<?php echo $this->getUrl('clinic/uploadgallery',array('id' => $this->getClinic()->getClinicId()));?>',
            uploadExtraData: [
                {id: '<?php echo $this->getClinic()->getClinicId();?>'}
            ],
            elErrorContainer: '#errorBlock'
        });
    $('#file-3').on('filebatchuploadcomplete', function(event, data, previewId, index) {
        console.log('Image upload complete');
        window.location.href="<?php echo $this->getUrl('clinic/edit',array('name'=> true,'tab' => 'gal'));?>";
        //location.reload();
    });
});

function deleteimage(image, id) {
    var conf = confirm("<?php echo __('Are you sure want to delete?');?>");
    if (conf) {
        $.ajax ({
            url:"<?php echo $this->getUrl('clinic/deletegallery');?>",
            type:'get',
            dataType:'json',
            data: {image:image,id:id},
            success:function(jsondata) {
                console.log(jsondata);
                if(jsondata.success) {
                      window.location.href="<?php echo $this->getUrl('admin/users/edit',array('__current'=> true,'tab' => 'gal'));?>";
                }
            }
        });
    }
}


function setthumbnail(image, id) {
    $.ajax ({
        url:"<?php echo $this->getUrl('admin/users/setthumbnail');?>",
        type:'get',
        dataType:'json',
        data: {image:image,id:id},
        success:function(jsondata) {
            if(jsondata.success) {
                 window.location.href="<?php echo $this->getUrl('admin/users/edit',array('__current'=> true,'tab' => 'gal'));?>";
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
<?php else:?>
<div class="alert alert-warning">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong><?php echo __('Warning!');?></strong>
    <?php echo __('Please add doctor details first');?>
</div>
<?php endif;?>
