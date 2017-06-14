<form method="post" action="<?php echo $this->getUrl('domain/store/save',$this->getRequest()->query());?>">
<?php $this->loadFormErrors(); ?>
<?php if($this->getWebsite()->getWebsiteId()):?>
<input type="hidden" name="website_id" value="<?php echo $this->getWebsite()->getWebsiteId();?>" />
<?php endif;?>
<?php if($this->getStore()->getStoreId()):?>
<input type="hidden" name="store_id" value="<?php echo $this->getStore()->getStoreId();?>" />
<?php endif;?>
<?php echo Form::hidden('form_key', Security::token());?>
<div class="row">
    <div class="col-md-12">
      <div class="grid simple">
        <div class="grid-title no-border">
          <h4>General <span class="semi-bold">Information</span></h4>
          <div class="tools"> <a href="javascript:;" class="collapse"></a>  </div>
        </div>
        <div class="grid-body no-border"> <br>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
              <div class="form-group">
                <label class="form-label"><?php echo __('Store Code');?></label>
                <span class="help">e.g. "Unique code"</span>
                <div class="controls">
                  <input type="text" class="form-control" name="store_index" value="<?php echo $this->getStore()->getStoreIndex();?>">
                  <span class="error"><?php echo $this->getFormError('store_index');?></span>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo __('Store Name');?></label>
                <span class="help">e.g. "You store name or store with city"</span>
                <div class="controls">
                  <input type="text" class="form-control" name="name" value="<?php echo $this->getStore()->getName();?>">
                  <span class="error"><?php echo $this->getFormError('name');?></span>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Website Id</label>
                <span class="help">e.g. "Choose a website"</span>
                <div class="controls">
                    <?php echo $this->websiteOptions();?>
                </div>
              </div> 
               
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="grid simple">
        <div class="grid-title no-border">
          <h4>Store <span class="semi-bold">Information</span></h4>
          <div class="tools"> <a href="javascript:;" class="collapse"></a>  </div>
        </div>
        <div class="grid-body no-border"> <br>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
              <div class="form-group">
                <label class="form-label"><?php echo __('Store Description');?></label>
                <span class="help">"Detailed description of your store"</span>
                <div class="controls">
                  <textarea class="form-control" name="description"><?php echo $this->getStore()->getStoreInfo()->getDescription();?></textarea>
                </div>
              </div>  
            </div>
          </div>
          
            <div class="form-actions">
               <div class="pull-right">
                 <button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> <?php echo __('Save');?></button>  
                 <button class="btn btn-white btn-cons" onclick="cancelSave()" type="button"><?php echo __('Cancel');?></button>
               </div>
             </div> 
        </div>
      </div> 
    </div> 
</div>
</form>
<script>
    function cancelSave()
    {
        <?php if($this->getRequest()->query('popup')):?>
            //window.opener.callparent();
            self.close();
        <?php else:?>
            setLocation('<?php echo $this->getUrl('domain/list/website');?>')
        <?php endif;?>
    }
    <?php if($this->getRequest()->query('saved') =='true' && $this->getRequest()->query('popup')):?>
    window.opener.callparent();
    self.close();
    <?php endif;?>
</script>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
