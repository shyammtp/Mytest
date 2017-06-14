<div id="rate_table"></div>
<?php $fieldattrs = $this->getFieldAttrs(); ?>
<script>
    $(function(){
        $("#currencyselect").change();        
    });
    $("#currencyselect").change(function(){
        var value = $(this).val();
        if (value) { 
            $.ajax ({
                url : '<?php echo $this->getUrl("admin/settings/exchangeratetable");?>',
                data : {basecurrency: value,fieldname:'<?php echo $this->getName();?>',value:<?php echo json_encode($fieldattrs['value']);?>},
                type:'get',
                dataType:'html',
                success:function(html) {
                    $("#rate_table").html(html);
                }
            });
        }
    });
</script>