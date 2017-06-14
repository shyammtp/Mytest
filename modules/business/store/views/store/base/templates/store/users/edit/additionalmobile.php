<div class="row">
    <div class="col-sm-12 mt10">
        <div class="custom_tag_list">
        <?php  foreach($this->getContacts() as $contact):?>
            <span class="tag"><span>+<?php echo $contact['country_code'];?>&nbsp;<?php echo $contact['number'];?>&nbsp;&nbsp;</span><a href="javascript:;" onclick="removeNumber(this,'<?php echo $contact['number'];?>')"title="<?php echo __('Remove this number');?>">x</a></span>
        <?php endforeach;?>
        </div>
    </div>
</div>
<script>

        function removeNumber(ele, mobilenumber)
        {
            if (confirm('<?php echo __("Are you sure want to delete?");?>')) {
                var element = $(ele);
                element.parent('span').remove();
                $.ajax({
                    url:'<?php echo $this->getUrl('admin/users/deleteadditional',$this->getRequest()->query());?>',
                    method:'post',
                    data:{'mobile':mobilenumber},
                    dataType:'json',
                    beforeSend:function()
                    {

                    },
                    success:function(response) {
                        console.log(response);

                    }
                });
            }

        }
</script>
