<div class="row">
    <?php $cfeatures = explode(",", $this->getStore()->getFeatures());  ?>
    <?php foreach($this->getRealEstateFeaturesList() as $features):?>
    <div class="col-sm-6">
        <label class=" col-sm-4 control-label  "> <?php echo $features['feature']; ?></label>
        <div class="col-sm-8">
            <?php $checked ='';
            if(in_array($features['real_estate_feature_id'],$cfeatures)) {   $checked ='checked';}?>
           <input type="checkbox" class="toggle" name="<?php echo $this->getAttribute()->getAttributeCode();?>[<?php echo $features['real_estate_feature_id'];?>]" data-size="small" <?php echo $checked;?> data-on-text="<?php echo __('Yes');?>" data-off-text="<?php echo __('No');?>" data-off-color="danger" data-on-color="success" style="visibility:hidden;" value="1" />
        </div>
    </div>
    <?php endforeach;?>
</div>

<script>
    //<![CDATA[
    $(window).load(function(){
        $('.toggle').bootstrapSwitch();
    });
    //]]>
</script>
