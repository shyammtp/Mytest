	<div class="tab-pane active" id="home3">
		
			<?php if($this->getRequest()->query('parent')){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Parent Category');?></label>
					<div class="col-sm-10">
							<select name="parent_id" style="width:100%" data-placeholder="Choose One" class="width300 form-control">

							<?php foreach($this->_getCategoryInfo($this->getRequest()->query('parent'),2) as $categoryid => $categoryname):?>
							<option  value="<?php echo $categoryname['id'];?>"><?php echo ucfirst($categoryname['name']);?></option>
							<?php endforeach;?>
							</select>
					</div>
				</div>
            <?php } ?>
            
			  <div class="form-group">
                <label class="col-sm-2 control-label required-hightlight"><?php echo __('Place Category Name');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                          <input type="text" name="category_name[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Place Category Name (:language)',array(':language'=> $language->getName()));?>" class="form-control" value="<?php echo $this->_getCategory()->getLabel('place_name',$langid);?>" />
                     
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
                       <textarea class="form-control" maxlength="250"  name="category_description[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Place Category Description (:language)',array(':language'=> $language->getName()));?>" class="form-control" ><?php echo $this->_getCategory()->getLabel('place_description',$langid);?></textarea>                     
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
                    <span class="help-text">Max length 250</span>
                </div>
            </div>
			  
			   <div class="form-group">
				 <label class="col-sm-2 control-label"><?php echo __('Category URL');?></label>
				 <div class="col-sm-10">
				<?php $category_url = $this->_getCategory()->getCategoryUrl();
				if ($this->getFormError('category_url') == "" && $this->getPostData('category_url') != "") {
				$category_url = $this->getPostData('category_url');
				}?>
				<input type="text" class="form-control" id="category_url" name="category_url"  value="<?php echo $category_url;?>" /> 
				</div>
			  </div>
			  
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo __('Add tags for this category');?></label>
					<div class="col-sm-6">
						<input name="category_tags" id="cstgs" class="form-control" value="<?php echo $this->_getCategory()->getCategoryTags(); ?>" />
					</div>
				</div><!-- form-group -->
			  
	  
	  			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Meta Title');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                          <input type="text" maxlength="150" name="meta_title[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Meta Title (:language)',array(':language'=> $language->getName()));?>" class="form-control" value="<?php echo $this->_getCategory()->getLabel('meta_title',$langid);?>" />
                     
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
                     <span class="help-text">Max length 150</span>
                </div>
            </div>
	              
               <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Meta Description');?></label>
                <div class="col-sm-10">
				<?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                       <textarea class="form-control"   name="meta_description[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Meta Description (:language)',array(':language'=> $language->getName()));?>" class="form-control" ><?php echo $this->_getCategory()->getLabel('meta_description',$langid);?></textarea>
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
               <span class="help-text">Max length 256</span>
                </div>
            </div> 
            
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Meta Keywords');?></label>
                <div class="col-sm-10">
                    <?php $i = 0; foreach($this->getLanguage() as $langid => $language):?>
                    <div class="input-group translatable_field language-<?php echo $langid;?>" <?php if($i > 0):?>style="display: none;"<?php endif;?>>
                          <input type="text" maxlength="150" name="meta_keywords[<?php echo $langid;?>]" id="suffix_<?php echo $langid;?>"  placeholder="<?php echo __('Meta Keywords (:language)',array(':language'=> $language->getName()));?>" class="form-control" value="<?php echo $this->_getCategory()->getLabel('meta_keywords',$langid);?>" />
                     
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
                    <span class="help-text">Max length 150</span>
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
				<?php $checked = "checked"; if($this->_getCategory()->getPlaceCategoryId()){ 
				if($this->_getCategory()->getStatus()){ $checked = "checked=checked"; } else { $checked = ""; } }?>
				<input type="checkbox" class="toggle" name="status" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
				</div>
				</div>
	</div>  
	<script>
	$(window).load(function() {
		$('#cstgs').tagsInput({width:'auto'});
	});
	</script>		 
