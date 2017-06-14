<?php
if($this->getRequest()->query('adverts_id')) {
	$advertdata = $this->_getAdvert()->getData();
	$placetype = $advertdata['place_type'];
	$placeid = explode(",", $advertdata['place_id']);		
	if($this->getImageUrl($this->getRequest()->query('adverts_id'))) {
		$advertimage = App::getBaseUrl('uploads').$this->getImageUrl($this->getRequest()->query('adverts_id'));
	} else {
		$advertimage = '';
	}
} else {
	$advertimage = '';
}
?>
<div class="row">
	<div class="col-md-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs"></ul>
		<form method="post" class="form-horizontal tab-form" action="<?php echo $this->getUrl('admin/adverts/saveadvert',$this->getRequest()->query());?>" accept-charset="UTF-8">
		<?php $this->loadFormErrors(); ?>
		<input type="hidden" name="adverts_id" value="<?php echo $this->getRequest()->query('adverts_id');?>" />
		<div class="tab-content mb30">
			<div class="tab-pane active" id="home3">
							
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Title');?></label>
					<div class="col-sm-10">	
					<?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>                       
                        <input type="text" maxlength="250" class="form-control"   name="title[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Adverts Title (:language)',array(':language'=> $language->getName()));?>" class="form-control"  value="<?php echo $this->_getAdvert()->getLabel('title',$langid);?>" />
                        <div class="input-group-btn">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><?php echo $language->getName();?> <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right">
                                <?php foreach($this->getLanguage() as $sublangid => $sublanguage):?>
                                    <li><a href="javascript:SD.Language.fieldchange(<?php echo $sublangid;?>)"> <?php echo $sublanguage->getName();?></a></li>
                                <?php endforeach;?>
                            </ul>
                        </div><!-- input-group-btn -->
                    </div>
                    <?php $i++; endforeach;?>					
					<span>max length 250 only</span>							
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Description');?></label>
					<div class="col-sm-10">
						 
						<?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>						
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                       <textarea class="form-control" maxlength="250"   name="description[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Adverts Description (:language)',array(':language'=> $language->getName()));?>" class="form-control" ><?php echo $this->_getAdvert()->getLabel('description',$langid);?></textarea>     
                                      
                        <div class="input-group-btn">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"><?php echo $language->getName();?> <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right">
                                <?php foreach($this->getLanguage() as $sublangid => $sublanguage):?>
                                    <li><a href="javascript:SD.Language.fieldchange(<?php echo $sublangid;?>)"> <?php echo $sublanguage->getName();?></a></li>
                                <?php endforeach;?>
                            </ul>
                            
                        </div><!-- input-group-btn -->
                    </div>
                    <?php $i++; endforeach;?>
                    <span>max length 250 only</span>
					</div>
					
				</div>	
						
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Select a Place Category');?></label>
					<div class="col-sm-10">
						
						<select id="select-basic2" data-placeholder="Choose One" <?php if($this->getRequest()->query('adverts_id')) { ?> disabled <?php } ?> name="place_type" class="width300 select2-offscreen" style="width:100%">
							<option value=""><?php echo __('Choose One'); ?></option>
							<?php if(count($this->_getPlaceCategoryInfo())> 0) { foreach($this->_getPlaceCategoryInfo() as $placecat) { ?>
							<?php if($this->getRequest()->query('adverts_id')) { ?>
							<?php if($placetype == $placecat['place_category_id'])  { ?>
							<option selected="selected"  value="<?php echo $placecat['place_category_id'];?>"><?php echo $placecat['place_name'];?></option>
							<?php } ?>
								<option  value="<?php echo $placecat['place_category_id'];?>"><?php echo $placecat['place_name'];?></option>
							<?php } else { ?>								
								<option  value="<?php echo $placecat['place_category_id'];?>"><?php echo $placecat['place_name'];?></option>
							<?php } ?>							
							<?php } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label required-hightlight"><?php echo __('Select a Place Name');?></label>
					<div class="col-sm-10">
						<select multiple="multiple" <?php if($this->getRequest()->query('adverts_id')) { ?> disabled <?php } ?> id="select-basic3" data-placeholder="Choose One"  name="place_id[]" class="width300 select3-offscreen" style="width:100%">
							<?php if($this->getRequest()->query('adverts_id')) { ?>
								<?php foreach($this->getplaces($placetype) as $placename) { ?>								
								<?php if(in_array($placename['place_id'],$placeid)) { ?>
									<option selected="selected" value="<?php echo $placename['place_id']; ?>"><?php echo $placename['place_index']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $placename['place_id']; ?>"><?php echo $placename['place_index']; ?></option>
								<?php } ?>
									
								<?php } ?>
							<?php } else { ?>
								<option value=""><?php echo __('Choose One'); ?></option>
							<?php } ?>
														
						</select>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Image');?></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div id="container_image"></div>
                        </div><!-- input-group -->
                    </div>
                </div>
                
                <div class="form-group">
				<label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
				<div class="col-sm-10">
				<?php $checked = "";
				if($this->getAdvert()->getStatus()){ $checked = "checked=checked"; }?>
				<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
				</div>
				</div>
			 </div>
			<div class="panel-footer">
					<button class="btn btn-primary mr5"><?php echo __('Save');?></button>
					<button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
					<button type="reset" class="btn btn-default" onclick="setLocation('<?php echo $this->getUrl('admin/adverts/advert');?>')"><?php echo __('Cancel');?></button>
				</div>
        </div>
        	
				
			</div>
	    </form>
	</div>
</div>
</div>
<script>
$(function() {
	$("#select-basic2").select2();
	$("#select-basic3").select2();
	$("#container_image").PictureCut({
            InputOfImageDirectory         : "image",
            PluginFolderOnServer          : "/assets/js/media/picturecut/",
            FolderOnServer                : "/uploads/adverts/",
            EnableCrop                    : true,
            CropWindowStyle               : "Bootstrap",
            <?php if($advertimage):?>
            DefaultImageAttrs           :      {src:'<?php echo $advertimage;?>'},
            <?php endif;?>
            InputOfImageDirectory : 'category_image',
            MinimumWidthToResize: 350,
            MinimumHeightToResize : 350,
            ImageButtonCSS                :{'border' :'2px dashed rgb(204, 204, 204)','padding':'2px'},
            InputOfImageDirectoryAttr       :{value:'<?php //echo $advertimage;?>'}
     });
	$("#select-basic2").change(function() {
		var place_type_id = $(this).val();
		var sel = $('#select-basic3');
		sel.empty();
		$.ajax({
			type:"POST",
			url:"<?php echo $this->getUrl('admin/adverts/place'); ?>",
			data:{query:place_type_id},
			dataType:"json",
			success:function(data) {
				$.each(data, function(key, val) {
					sel.append($("<option>").attr('value',val.place_id).text(val.place_index));
				});	
			}
		});
	});
});
</script>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
