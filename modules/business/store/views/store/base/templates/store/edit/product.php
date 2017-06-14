<?php if($this->getStore()->getStoreId()):?>
<form method="post" action="<?php echo $this->getUrl('admin/store/save',$this->getRequest()->query());?>" id="store_product_form" >

    <input type="hidden" value="<?php echo $this->getUrl('admin/store/edit',array('__current' => true,'tab' => 'pr_sr'));?>" name="redirectto" />
    <input name="store_id" id="store_id" type="hidden" class="form-control" value="<?php echo $this->getStore()->getStoreId();?>" />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns" style="display: none;">
                <a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="" data-original-title="Minimize Panel"><i class="fa fa-minus"></i></a>
            </div><!-- panel-btns -->
            <h4 class="panel-title"><?php echo __("Product / Service information");?></h4>
        </div><!-- panel-heading -->
<?php 
	if(count($this->getStore()->getStoreProducts())>0){
			$products_category=array();$products_subcategory=array();$products_subcategory=array();$products=array();$brands=array();
		foreach($this->getStore()->getStoreProducts() as $product){
			$products_category[]=$product['product_category']; $products_subcategory[]=$product['product_subcategory'];
		} 
			$category=array_unique($products_category);$subcategory=array_unique($products_subcategory);
	}
?>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label"><?php echo __('Product / Service Category');?></label>
                        <div class="autocomplete-container">
									<input type="hidden" name="product_category" id="" value="<?php if(count($this->getStore()->getStoreProducts())>0){ echo $category['0']; 
									 } ?>" size="150"  />
                            <div id="tags_tagsinput" class="autocompleteinput">
                                <div id="tags_addTag">
									<?php if(count($this->getStore()->getStoreProducts())>0){ if(count($this->getStore()->getCategory())>0){
									$cat_lists=explode(",",$category['0']);
									foreach($this->getStore()->getCategory() as $cate){
										if(in_array($cate['category_id'],$cat_lists)){ ?>
										<span class="tag tag_element_<?php echo $cate['category_id'];?>"><?php echo $cate['category_name'];?> <a href="javascript:;" data-id="<?php echo $cate['category_id'];?>" title="<?php echo __('Remove');?>">x</a></span> <?php } 
									} } } ?>
                                    <input type="text" class="" id="product_category"  size="150"/>
                                    <div class="tags_clear"></div>
                                </div>
                            </div>
                        </div>
                        <span class="help-block"><?php echo __('Type a keyword to select a category. Minimum length is 2');?></span>
                    </div>
                </div>
                <!--<div class="col-sm-1">
                     <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="">
                            <a class="btn btn-primary" id="add_newproduct_category" data-toggle="modal" href="<?php echo $this->getUrl('admin/store_category/editcategoryform');?>" data-target="#add_newproduct_category_modal"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>-->
                <div class="col-sm-6">
                     <div class="form-group">
                        <label class="control-label"><?php echo __('Product / Service Sub Category');?></label>
                        <div class="autocomplete-container">
                            <input type="hidden" name="product_subcategory" id="" value="<?php if(count($this->getStore()->getStoreProducts())>0){ echo $subcategory['0'];  } ?>" size="150"  />
                            <div id="tags_tagsinput" class="autocompleteinput">
                                <div id="tags_addTag">
									<?php if(count($this->getStore()->getStoreProducts())>0){ if(count($this->getStore()->getCategory())>0){
										$cat_lists=explode(",",$subcategory['0']);
										foreach($this->getStore()->getCategory() as $cate){
												if(in_array($cate['category_id'],$cat_lists)){ ?>
									<span class="tag tag_element_<?php echo $cate['category_id'];?>"><?php echo $cate['category_name'];?> <a href="javascript:;" data-id="<?php echo $cate['category_id'];?>" title="<?php echo __('Remove');?>">x</a></span>
									
									<?php	}
										}	
									} } ?>
                                    <input type="text" class="" id="product_subcategory" size="150"/>
                                    <div class="tags_clear"></div>
                                </div>
                            </div>
                        </div>
                        <span class="help-block"><?php echo __('Type a keyword to select a sub category. Minimum length is 2');?></span>
                    </div>
                </div>
                 <!--<div class="col-sm-1">
                     <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="">
                           <a class="btn btn-primary" id="add_newproduct_sub_category" data-toggle="modal" href="<?php echo $this->getUrl('admin/store_category/editsubcategoryform');?>" data-target="#add_newproduct_sub_category_modal"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>-->
            </div>

		<?php 
		$options=array();
		$options[] = array('label' => 'Samsung Mobile' , 'value' => '2');$options[] = array('label' => 'Sony Mobile' , 'value' => '1');$options[] = array('label' => 'Motorola Mobile' , 'value' => '13');
		if(count($this->getStore()->getStoreProducts())>0){  
		foreach($this->getStore()->getStoreProducts() as $key=>$val) { 
		?>
		<input type="hidden" name="products<?php echo $key; ?>" id="" value="<?php  if( $val['products']){ echo $val['products']; } ?>" size="150"  />
		<input type="hidden" name="brands<?php echo $key; ?>" id="" value="<?php  if($val['brands']){echo $val['brands']; } ?>" size="150"  />
		<input type="hidden"  name="product_count[]" data-type="single" size="150"/>
		
<?php /*				
	<div class="row column">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label"><?php echo __('Products');?></label>
                    <div class="autocomplete-container">
                        <input type="hidden" name="products<?php echo $key; ?>" id="" value="<?php  if( $val['products']){ echo $val['products']; } ?>" size="150"  />
                        <div id="tags_tagsinput" class="autocompleteinput">
                            <div id="tags_addTag">
								<?php if(count($options)>0 && $val['products']){ $pro_lists=explode(",",$val['products']); foreach($options as $pro) { if(in_array($pro['value'],$pro_lists)){ ?>
									<span class="tag tag_element_<?php echo $pro['value'];?>"><?php echo $pro['label'];?> <a href="javascript:;" data-id="<?php echo $pro['value'];?>" title="<?php echo __('Remove');?>">x</a></span>
									<?php } } }  ?>
                                <input type="text" class="" id="products<?php echo $key; ?>" data-type="single" size="150"/>
                                <div class="tags_clear"></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"><?php echo __('Type a keyword to select a products. Minimum length is 2');?></span>
                </div>
            </div>
            <div class="col-sm-3">
                 <div class="form-group">
                    <label class="control-label"><?php echo __('Brands');?></label>
                    <div class="autocomplete-container">
                        <input type="hidden" name="brands<?php echo $key; ?>" id="" value="<?php  if($val['brands']){echo $val['brands']; } ?>" size="150"  />
                        <div id="tags_tagsinput" class="autocompleteinput">
                            <div id="tags_addTag">
																<?php  if(count($this->getStore()->getBrands())>0 && $val['brands']){
												$bnd_lists=explode(",",$val['brands']);
												foreach($this->getStore()->getBrands() as $brand){
														if(in_array($brand['brand_id'],$bnd_lists)){ ?>										
									<span class="tag tag_element_<?php echo $brand['brand_id'];?>"><?php echo $brand['title'];?> <a href="javascript:;" data-id="<?php echo $brand['brand_id'];?>" title="<?php echo __('Remove');?>">x</a></span>
									
									     <?php } } }  ?>
                                <input type="text" class="" id="brands<?php echo $key; ?>" data-type="multiple" size="150"/>
                                <div class="tags_clear"></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"><?php echo __('Type a keyword to select a brands. Minimum length is 2');?></span>
                </div>
            </div>
            <input type="hidden"  name="product_count[]" data-type="single" size="150"/>
            <div class="col-sm-2">
                 <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <div class="">
                        <input type="hidden" name="is_delete[<?php echo $val['store_product_id']; ?>]" class="delete" value="0"/>
                        <a class="btn btn-primary addoption"><i class="fa fa-plus"></i></a>
                     <?php if($key==!0){ ?>  <a class="btn btn-danger deletesoptionRow" id="add_new_brandset<?php echo $key; ?>" ><i class="fa fa-minus"></i></a><?php } ?>
                    </div>
                </div>
            </div>
    </div>					
*/ ?>
	 <script> $(function() { SD.Autocomplete.setType('single').ajax('products<?php echo $key; ?>','<?php echo $this->getUrl('admin/products/product',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'});
            SD.Autocomplete.setType('multiple').ajax('brands<?php echo $key; ?>','<?php echo $this->getUrl('admin/products/brands',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'}); }); </script>
            <?php }  } else {  ?>
            <input type="hidden" name="products" id="" value="" size="150"  />
            <input type="hidden" name="brands" id="" value="" size="150"  />
            <input type="hidden"  name="product_count[]" data-type="single" size="150"/>
<?php /*            
                        <div class="product-set">
                <div class="row">
					
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label"><?php echo __('Products');?></label>
                            <div class="autocomplete-container">
                                <input type="hidden" name="products" id="" value="" size="150"  />
                                <div id="tags_tagsinput" class="autocompleteinput">
                                    <div id="tags_addTag">
                                        <input type="text" class="" id="products" data-type="single" size="150"/>
                                        <div class="tags_clear"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"><?php echo __('Type a keyword to select a products. Minimum length is 2');?></span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                         <div class="form-group">
                            <label class="control-label"><?php echo __('Brands');?></label>
                            <div class="autocomplete-container">
                                <input type="hidden" name="brands" id="" value="" size="150"  />
                                <div id="tags_tagsinput" class="autocompleteinput">
                                    <div id="tags_addTag">
                                        <input type="text" class="" id="brands" data-type="multiple" size="150"/>
                                        <div class="tags_clear"></div>
                                    </div>
                                </div>
                            </div>
                            <span class="help-block"><?php echo __('Type a keyword to select a brands. Minimum length is 2');?></span>
                        </div>
                    </div>
                    
                      <input type="hidden"  name="product_count[]" data-type="single" size="150"/>
                    <div class="col-sm-1">
                         <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <div class="">
                               <a class="btn btn-primary addoption" ><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
*/ ?>           
            <?php } ?>
            <?php if(count($this->getStore()->getStoreProducts())>0){  ?>
             <div class="product-set"></div>
             <?php } ?>
            
        </div>
        
        <div class="panel-footer">
            <button class="btn btn-primary mr5" type="submit"><?php echo __('Save');?></button>
            <button class="btn btn-default mr5" type="button" onclick="setLocation('<?php echo $this->getUrl("admin/dashboard/index");?>')"><?php echo __('Cancel');?></button>
        </div>
    </div>
</form>

<div id="rowtemplate" style="display: none;">
    <div class="row column">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label"><?php echo __('Products');?></label>
                    <div class="autocomplete-container">
                        <input type="hidden" name="products{{id}}" id="" value="" size="150"  />
                        <div id="tags_tagsinput" class="autocompleteinput">
                            <div id="tags_addTag">
                                <input type="text" class="" id="products{{id}}" data-type="single" size="150"/>
                                <div class="tags_clear"></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"><?php echo __('Type a keyword to select a products. Minimum length is 2');?></span>
                </div>
            </div>
            <div class="col-sm-3">
                 <div class="form-group">
                    <label class="control-label"><?php echo __('Brands');?></label>
                    <div class="autocomplete-container">
                        <input type="hidden" name="brands{{id}}" id="" value="" size="150"  />
                        <div id="tags_tagsinput" class="autocompleteinput">
                            <div id="tags_addTag">
                                <input type="text" class="" id="brands{{id}}" data-type="multiple" size="150"/>
                                <div class="tags_clear"></div>
                            </div>
                        </div>
                    </div>
                    <span class="help-block"><?php echo __('Type a keyword to select a brands. Minimum length is 2');?></span>
                </div>
            </div>
            <input type="hidden"  name="product_count[]" data-type="single" size="150"/>
            <div class="col-sm-2">
                 <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <div class="">
                        <input type="hidden" name="is_delete[{{id}}]" class="delete" value="0"/>
                        <a class="btn btn-primary addoption"><i class="fa fa-plus"></i></a>
                       <a class="btn btn-danger deletesoptionRow" id="add_new_brandset{{id}}" ><i class="fa fa-minus"></i></a>
                    </div>
                </div>
            </div>
    </div>
</div>
<script>
$(function() {
    SD.Autocomplete.setType('single').ajax('product_category','<?php echo $this->getUrl('admin/products/category',array('format'=> 'json','suppressResponseCodes' => 'true'));?>');
    SD.Autocomplete.setType('multiple').ajax('product_subcategory','<?php echo $this->getUrl('admin/products/subcategory',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'});
    SD.Autocomplete.setType('single').ajax('products','<?php echo $this->getUrl('admin/products/product',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'});
    SD.Autocomplete.setType('multiple').ajax('brands','<?php echo $this->getUrl('admin/products/brands',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'});
    var count = <?php if(count($this->getStore()->getStoreProducts())){  echo count($this->getStore()->getStoreProducts()); } else { ?> 1 <?php } ?>;
    var specific_count = count;
    var template = $("#rowtemplate").html();
    $(function(){
         $(".addoption").live('click',function(){
           addOption.addRow(specific_count,template);
        });

        $(".deletesoptionRow").live('click',function(){
            addOption.deleteRow(this);
        });
    });
    var addOption = {
        addRow:function(id,template){
            var row = template.replace(/{{id}}/g,id);
            $(".product-set").append(row);
            SD.Autocomplete.setType('single').ajax('products'+id,'<?php echo $this->getUrl('admin/products/product',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'});
            SD.Autocomplete.setType('multiple').ajax('brands'+id,'<?php echo $this->getUrl('admin/products/brands',array('format'=> 'json','suppressResponseCodes' => 'true'));?>',{dependant:'product_category'});
            specific_count++;
        },
        deleteRow:function(element)
        {
            $(element).parents('.column').remove();
            $(element).parents('.column').find('.delete').val(1);
        }
    }
  });
</script>
<?php else:?>
<div class="alert alert-warning">
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
    <strong><?php echo __('Warning!');?></strong>
    <?php echo __('Please add store first');?>
</div>
<?php endif;?>

