<div class="row">
    <div class="col-sm-12 mt10">
        <div class="custom_tag_list">
        <?php  foreach($this->getEmails() as $email):?>
            <span class="tag"><span><?php echo $email['email'];?>&nbsp;&nbsp;</span><a href="javascript:;" onclick="removeEmail(this,'<?php echo $email['email'];?>')"title="<?php echo __('Remove this email');?>">x</a></span>
        <?php endforeach;?>
        </div>
    </div>
</div>
<script>

        function removeEmail(ele, mobilenumber)
        {
            if (confirm('<?php echo __("Are you sure want to delete?");?>')) {
                var element = $(ele);
                element.parent('span').remove();
                $.ajax({
                    url:'<?php echo $this->getUrl('admin/users/deleteadditionalemail',$this->getRequest()->query());?>',
                    method:'post',
                    data:{'additional_email':mobilenumber},
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
