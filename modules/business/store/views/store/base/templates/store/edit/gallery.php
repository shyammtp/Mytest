<?php if($this->getStore()->getStoreId()):
$gimages = $this->getGalleryImages($this->getStore()->getStoreId());
?>
    <div class="row">

        <div class="col-sm-12">
          <div class="media-manager-sidebar">

            <div class="form-group">
                <input id="file-3" type="file" name="store_image" multiple=true>
                <div id="errorBlock" class="help-block"></div>
            </div>

            <div class="mb30"></div>

          </div>
        </div><!-- col-sm-3 -->

        <div class="col-sm-12">
          <div class="row media-manager">

            <?php foreach($gimages as $images):?>
            <?php if(file_exists(DOCROOT.$images['file'])):?>
            <div class="col-xs-6 col-sm-4 col-md-3 image">
              <div class="thmb">
                <div class="btn-group fm-group">
                    <button type="button" class="btn btn-default dropdown-toggle fm-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu fm-menu pull-right" role="menu">
                      <li><a href="<?php echo App::getBaseUrl().$images['file'];?>" target="_blank"><i class="fa fa-download"></i> Download</a></li>
                      <li><a href="javascript:deleteimage('<?php echo base64_encode($images['file']);?>','<?php echo $images['store_id'];?>')"><i class="fa fa-trash-o"></i><?php echo __('Delete');?></a></li>
                      <?php if($images['thumbnail'] == 'f'):?>
                      <li><a href="javascript:setthumbnail('<?php echo base64_encode($images['file']);?>','<?php echo $images['store_id'];?>')"><i class="fa fa-file-image-o"></i> <?php echo __('Set as thumbnail');?></a></li>
                      <?php endif;?>
                    </ul>
                </div><!-- btn-group -->
                <div class="thmb-prev" style="height: 130px; overflow: hidden;">
                  <a href="<?php echo App::getBaseUrl().'cache/uploads/cache/thumb_500x500/'.$images['file'];?>" data-rel="prettyPhoto">
                    <img src="<?php echo App::getBaseUrl().'cache/uploads/cache/thumb_500x500/'.$images['file'];?>" class="img-responsive" alt=""  />
                  </a>
                </div>
                <?php if($images['thumbnail'] == 't'):?>
                <div class="fa fa-thumb-tack" title="<?php echo __('Default thumbnail');?>" style="position: absolute; top:12px; color:rgb(255, 106, 57);font-size: 18px; left:12px;"></div>
                <?php endif;?>
                <h5 class="fm-title"><a href="#"><?php echo basename($images['file']);?></a></h5>
                <small class="text-muted"><?php echo __('Added: :date',array(':date' => date("M d, Y",strtotime($images['added_on']))));?></small>
              </div><!-- thmb -->
            </div><!-- col-xs-6 -->
            <?php endif;?>
            <?php endforeach;?>

          </div><!-- row -->


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
            uploadUrl: '<?php echo $this->getUrl('admin/store/uploadgallery',array('id' => $this->getStore()->getStoreId()));?>',
            uploadExtraData: [
                {id: '<?php echo $this->getStore()->getStoreId();?>'}
            ],
            elErrorContainer: '#errorBlock'
        });
    $('#file-3').on('filebatchuploadcomplete', function(event, data, previewId, index) {
        console.log('Image upload complete');
        window.location.href="<?php echo $this->getUrl('admin/store/edit',array('id'=>$this->getStore()->getStoreId(),'tab' => 'gal'));?>";
        //location.reload();
    });
});

function deleteimage(image, id) {
    var conf = confirm("<?php echo __('Are you sure want to delete?');?>");
    if (conf) {
        $.ajax ({
            url:"<?php echo $this->getUrl('admin/store/deletegallery');?>",
            type:'get',
            dataType:'json',
            data: {image:image,id:id},
            success:function(jsondata) {
                console.log(jsondata);
                if(jsondata.success) {
                    window.location.href="<?php echo $this->getUrl('admin/store/edit',array('id'=>$this->getStore()->getStoreId(),'tab' => 'gal'));?>";
                }
            }
        });
    }
}

function setthumbnail(image, id) {
    $.ajax ({
        url:"<?php echo $this->getUrl('admin/store/setthumbnail');?>",
        type:'get',
        dataType:'json',
        data: {image:image,id:id},
        success:function(jsondata) {
            if(jsondata.success) {
                 window.location.href="<?php echo $this->getUrl('admin/store/edit',array('id'=>$this->getStore()->getStoreId(),'tab' => 'gal'));?>";
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
    <?php echo __('Please add store first');?>
</div>
<?php endif;?>
