<?php  
	$AreaLists = $this->_getArealists();
?>
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Area');?></label>
                <div class="col-sm-10">
						<select name="area_id" style="width:100%" id="area" data-placeholder="Choose One" class="width300">
						<?php foreach($AreaLists as $areaid => $areaname):?>
						<option <?php echo $this->getAreaId()==$areaid ? "selected":"";?>  value="<?php echo $areaid;?>"><?php echo ucfirst($areaname);?></option>
						<?php endforeach;?>
						</select>
                </div>
            </div>
<script>
    $(function(){
		$('#area').select2();
        $("#m-multi").select2();
        <?php if($this->getData('all')) { ?>
        $("#m-multi").on("select2-selecting", function (e) {
            if (e.val == '0:all') {
               $("#m-multi").val('0:all').trigger('change');
            }
            $("#m-multi :selected").each(function(i,selected) {
                if ($(this).val() == "0:all"){
                    $(this).attr('selected',false);
                    $("#m-multi").trigger('change');
                }
            })
        });
        <?php } ?>
       
    }); 
</script>
