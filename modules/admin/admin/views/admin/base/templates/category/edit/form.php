<?php
$placecategory = App::model('core/place_category',false)->load($this->getCategory()->getPlaceCategoryId());
 
?>
	<div class="tab-pane active" id="home3">
		
			  <div class="form-group">
                <label class="col-sm-2 control-label required-hightlight"><?php echo __('Place Category Name');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                          <input maxlength="100" type="text" name="category_name[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Place Category Name (:language)',array(':language'=> $language->getName()));?>" class="form-control" <?php if($this->isReadOnly()):?>readonly<?php endif;?> value="<?php echo $this->_getCategory()->getLabel('place_name',$langid);?>" />
                     
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
                </div>
            </div>

			  <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Place Category Description');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                       <textarea maxlength="250" class="form-control"   name="category_description[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Place Category Description (:language)',array(':language'=> $language->getName()));?>" class="form-control" ><?php echo $this->_getCategory()->getLabel('place_description',$langid);?></textarea>                     
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
                    <span class="help-text"><?php echo __('Max length 256');?></span>
                </div>
            </div>
			  
			   <div class="form-group">
				 <label class="col-sm-2 control-label"><?php echo __('Category URL');?></label>
				 <div class="col-sm-10">
				<?php $category_url = $this->getCategory()->getCategoryUrl();
				if ($this->getFormError('category_url') == "" && $this->getPostData('category_url') != "") {
				$category_url = $this->getPostData('category_url');
				}?>
				<input maxlength="100" type="text" class="form-control" id="category_url" <?php if($this->isReadOnly()):?>readonly<?php endif;?> name="category_url"  value="<?php echo $category_url;?>" /> 
				</div>
			  </div>
			  
	         <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Add tags for this category');?></label>
                <div class="col-sm-6">
                    <input maxlength="250" name="category_tags" id="ctgs" class="form-control" value="<?php echo $this->getCategory()->getCategoryTags(); ?>" />
                </div>
            </div><!-- form-group -->
			
			<div class="form-group">
                  <label class="col-sm-2 control-label"></label>
                <div class="col-sm-6">
                   <label><input type="checkbox" name="is_explore_frontend" id="is_explore_area" value="1" <?php echo ($placecategory->getIsExploreFrontend() == 't')?"checked":"";?> /> <?php echo __("Is this shown in frontend explore area");?>&nbsp;
						<a href="#" data-toggle="modal" data-target="#cmsblck"><?php echo __('What this?');?></a>
					</label>
                </div>
            </div><!-- form-group -->
            
            <div id="cmsblck" class="modal fade" tabindex="1" role="dialog" aria-hidden="false">
			<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close margr5" data-dismiss="modal">&times;</button>
			  </div>
			  <div class="modal-body">
			   <div class="">
						  <img src="<?php echo App::getBaseUrl('');?>assets/admin/base/images/pop_upimg3.png">
				</div>
			  </div>
			</div>
			</div>
			</div>
			
			<div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo __('Explore Hint');?></label>
                <div class="col-sm-6">
					<input maxlength="250" type="text" class="form-control" id="explore_hint"  name="explore_hint"  value="<?php echo $placecategory->getExploreHint();?>" />  
                </div>
            </div><!-- form-group -->
			
			<div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo __('Normal Marker');?></label>
                <div class="col-sm-6">
					<input type="file" name="explore_normal_marker_icon" />
					<?php  if($normalmarker = $placecategory->getNormalMarker()):?>
						<img src="<?php echo $normalmarker;?>" />
 					<?php endif;?>
					<span class="help-block"> <?php echo __('Image resolution should be 49x61px');?></span>
                </div>
            </div><!-- form-group -->
			
			<div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo __('Clustered Marker');?></label>
                <div class="col-sm-6">
					<input type="file" name="explore_cluster_marker_icon" />
					<?php  if($normalmarker = $placecategory->getClusterMarker()):?>
						<img src="<?php echo $normalmarker;?>" />
 					<?php endif;?>
					<span class="help-block"><?php echo __('Image resolution should be 49x61px');?></span>
                </div>
            </div><!-- form-group --> 
			
			<div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo __('Explore Icon');?></label>
                <div class="col-sm-6">
					<input type="file" name="explore_right_icon" />
					<?php  if($exploremarker = $placecategory->getExploreIcon()):?>
						<img src="<?php echo $exploremarker;?>" />
 					<?php endif;?>
					<span class="help-block"><?php echo __('Image resolution should be 40x40px');?></span>
                </div>
            </div><!-- form-group -->
            
	  			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Meta Title');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                          <input type="text" maxlength="100" name="meta_title[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Meta Title (:language)',array(':language'=> $language->getName()));?>" class="form-control" value="<?php echo $this->_getCategory()->getLabel('meta_title',$langid);?>" />
                     
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
                    <span class="help-text"><?php echo __('Max length 100');?></span>
                </div>
            </div>
	              
               <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Meta Description');?></label>
                <div class="col-sm-10">
				<?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                       <textarea class="form-control" maxlength="200"   name="meta_description[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Meta Description (:language)',array(':language'=> $language->getName()));?>" class="form-control" ><?php echo $this->_getCategory()->getLabel('meta_description',$langid);?></textarea>
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
            <span class="help-text"><?php echo __('Max length 200');?></span>
                </div>
            </div> 
            
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Meta Keywords');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                          <input type="text" maxlength="100" name="meta_keywords[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Meta Keywords (:language)',array(':language'=> $language->getName()));?>" class="form-control" value="<?php echo $this->_getCategory()->getLabel('meta_keywords',$langid);?>" />
                     
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
                    <span class="help-text"><?php echo __('Max length 100');?></span>
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
	  
	  <?php if(!$this->isReadOnly()):?> 
			<div class="form-group">
				<label  class="col-sm-2 control-label"><?php echo __('Status');?></label>
				<div class="col-sm-10">
				<?php $checked = "checked"; if($this->_getCategory()->getPlaceCategoryId()){ 
				if($this->_getCategory()->getStatus()){ $checked = "checked=checked"; } else { $checked = ""; } }?>
				<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
				</div>
				</div>
			<?php endif;?>
	</div>  
<script>
$(window).load(function() {
    $('#ctgs').tagsInput({width:'auto'});
});
</script>
