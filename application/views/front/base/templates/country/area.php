<?php
$AreaLists = $this->_getArealists();
?>

    <label class=""><?php echo __('Area'); ?></label>
    <div class="input_fileds">
	<select name="area_id"  id="area" data-placeholder="Choose One" >
	    <?php foreach ($AreaLists as $areaid => $areaname): ?>
    	    <option <?php echo $this->getAreaId() == $areaid ? "selected" : ""; ?>  value="<?php echo $areaid; ?>"><?php echo ucfirst($areaname); ?></option>
	    <?php endforeach; ?>
	</select>
    </div>

<script>
    $(function(){
	$('#area').select2();
        $("#m-multi").select2();
<?php if ($this->getData('all')) { ?>
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
