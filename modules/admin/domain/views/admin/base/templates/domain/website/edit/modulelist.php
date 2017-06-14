<div class="row"> 
    <?php $this->loadFormErrors(); ?>
  <div class="col-md-12">
    <h3>Website Modules</h3>
    <p>You can drag and drop the modules to be installed and uninstalled</p>
    <p>
      <?php /* <button type="button" id="newmod_btn" class="btn btn-primary btn-sm btn-small">Add a new Module</button> */ ?>
    </p>
    <?php /*<div class="newmodule_form" id="newmodule_form" style="display: none;">
        <form method="post" id="newmod_form" action="<?php echo $this->getUrl('domain/list/savemodule');?>">
        <input type="hidden" name="website_id" value="<?php echo $this->getRequest()->query('id');?>" /> 
        <?php echo Form::hidden('form_key', Security::token());?>
        <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">
              <div class="form-group">
                <label class="form-label"><?php echo __('Module');?></label>
                <span class="help">e.g. Folder name of your module</span>
                <div class="controls">
                  <input type="text" id="module" class="form-control" name="module" value="">
                  <span class="error"><?php echo $this->getFormError('module');?></span>
                </div>
              </div>
                <div class="form-group">
                    <label class="form-label"><?php echo __('Module Name');?></label> 
                    <div class="controls">
                      <input type="text" id="module_name" class="form-control" name="module_name" value="">
                       <span class="error"><?php echo $this->getFormError('module_name');?></span>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label"><?php echo __('Info');?></label> 
                    <div class="controls">
                      <textarea class="form-control" id="info" name="info"></textarea>
                       <span class="error"><?php echo $this->getFormError('info');?></span>
                    </div>
                  </div>
                <div class="form-group">
                    <label class="form-label"><?php echo __('Author');?></label> 
                    <div class="controls">
                      <input type="text" class="form-control" name="author" value="">
                       <span class="error"><?php echo $this->getFormError('author');?></span>
                    </div>
                  </div>
                <div class="form-group row-fluid">
                    <div class="checkbox check-success">
                      <input id="checkbox3" type="checkbox" name="status" value="1">
                      <label for="checkbox3"><?php echo __('Enable');?></label>
                    </div>
                  </div>
              
            </div> 
          </div> 
        <div class="pull-right">
          <button class="btn btn-danger btn-cons" type="submit"><i class="icon-ok"></i> <?php echo __('Save');?></button>  
          <button class="btn btn-white btn-cons" type="button" id="cancel_modform"><?php echo __('Cancel');?></button>
        </div>
        <div class="clearfix"></div>
        </form>     
    </div> */ ?>
     <?php $Ninstalled = $this->getNotInstalledModules();?>
     <?php $installed = $this->getInstalledModules();?>
        <div class="row column-seperation">
            <div class="col-md-6">
                <h4><?php echo __('Installed Modules');?></h4>
                <p>Modules which are installed to the website. </p>
                <div id="web_modules" style="border:1px solid #eee; min-height:100px; padding:6px; border-radius:4px;">
                    <?php foreach($installed as $modules):?>
                    <div class="col-md-12 single-colored-widget vertical green draggable" data-modid="<?php echo $modules->id;?>" data-modname="<?php echo $modules->module;?>"> 
                        <div class="heading borderright bordertop borderbottom">
                          <div class="pull-left">
                            <h4> <span class="semi-bold"><?php echo is_null($modules->module_name)? $modules->module:$modules->module_name;?></span></h4>
                            <p><?php echo $modules->info;?></p> 
                          </div>
                          <div class="pull-right"> <span class="small-text muted">v<?php echo $modules->version;?></span> </div>
                          <div class="clearfix"> </div>
                        </div>
                      </div>
                    <?php endforeach;?>  
                </div>
            </div>
            <div class="col-md-6">
                <h4><?php echo __('Not Installed Modules');?></h4>
                 <p>Modules are not installed to this website</p>
                <div id="existing_modules"  style="border:1px solid #eee; min-height:100px!important; padding:6px; border-radius:4px;">
                    <?php foreach($Ninstalled as $modules):?>
                        <div class="col-md-12 single-colored-widget vertical green draggable" data-modid="<?php echo $modules->id;?>" data-modname="<?php echo $modules->module;?>"> 
                        <div class="heading borderright bordertop borderbottom">
                          <div class="pull-left">
                            <h4><span class="semi-bold"><?php echo is_null($modules->module_name)? $modules->module:$modules->module_name;?></span></h4>
                            <p><?php echo $modules->info;?></p> 
                          </div>
                          <div class="pull-right"> <span class="small-text muted">v<?php echo $modules->version;?></span> </div>
                          <div class="clearfix"> </div>
                        </div>
                      </div>
                    <?php endforeach;?>
                </div>
            </div> 
        </div>
  </div>
   
  
</div>

<style type="text/css">
    .vertical {
        border-top: none !important;
        padding-left: 0px!important;
        margin-right: 0px!important;
        margin:6px;
        background: #fff;
    }
    .vertical.green {
        border-left: 4px solid #0aa699;

    }
    .vertical.purple {
        border-left: 4px solid #a272b2; 
    }
    .bordertop{border-top: 1px solid #dddddd;}.borderright{border-right: 1px solid #dddddd;}.borderbottom{border-bottom: 1px solid #dddddd;}
    #empty { color:#ccc;} 
</style>
<script>
var BB = {
    url: '<?php echo App::helper('url')->getUrl('domain/list/managemods');?>',
    webid: '<?php echo $this->getRequest()->query('id');?>'
} 
</script>
