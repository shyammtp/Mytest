<?php if($this->getWebsite()->checkhasOwner()):
$owner = $this->getWebsite()->getOwner()->getCustomer();
?>
    <?php echo __('Name');?>: <?php echo $owner->getFirstname();?> <br/>
    <?php echo __('Email');?>: <?php echo $owner->getEmail();?> <br/> 
    <?php echo __('Username');?>: <?php echo $owner->getUsername();?> <br/> 
<?php else:?>
<form method="post" action="<?php echo $this->getUrl('domain/customer/save',Arr::merge($this->getRequest()->query(),array('tab' => 'owner')));?>">
<?php if($this->getWebsite()->getWebsiteId()):?>
<input type="hidden" name="website_id" value="<?php echo $this->getWebsite()->getWebsiteId();?>" />
<?php else:?>
<div class="alert alert"> <a class="close" data-dismiss="alert" href="#"></a><?php echo __('Warning: Create a website first');?></div>
<?php endif;?>
<?php echo Form::hidden('form_key', Security::token());?>
<div class="row">
    <div class="col-md-12">
      <div class="grid simple">
       
        <div class="grid-body no-border"> <br>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
              <div class="form-group">
                <label class="form-label"><?php echo __('Username');?></label>
                <span class="help">e.g. "You user name"</span>
                <div class="controls">
                  <input type="text" class="form-control" name="customer[username]" value="<?php //echo $this->getStore()->getStoreIndex();?>">
                  <span class="error"><?php echo $this->getFormError('username');?></span>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label"><?php echo __('Firstname');?></label> 
                <div class="controls">
                  <input type="text" class="form-control" name="customer[firstname]" value="<?php //echo $this->getStore()->getName();?>">
                  <span class="error"><?php echo $this->getFormError('firstname');?></span>
                </div>
              </div>
                <div class="form-group">
                <label class="form-label"><?php echo __('Email');?></label>
                <span class="help">e.g. "Enter your valid email"</span>
                <div class="controls">
                  <input type="text" class="form-control" name="customer[email]" value="<?php //echo $this->getStore()->getName();?>">
                  <span class="error"><?php echo $this->getFormError('Email');?></span>
                </div>
              </div>
                <div class="form-group">
                <label class="form-label"><?php echo __('Password');?></label> 
                <div class="controls">
                  <input type="text" class="form-control" name="customer[password]" value="<?php //echo $this->getStore()->getName();?>">
                  <span class="error"><?php echo $this->getFormError('password');?></span>
                </div>
              </div>
               
            </div>
          </div>
          
           <div class="form-actions">
               <div class="pull-right">
                 <button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> <?php echo __('Save');?></button>  
               </div>
             </div>
        </div>
      </div>
    </div>
</div>
 
         

</form>
<?php endif;?>