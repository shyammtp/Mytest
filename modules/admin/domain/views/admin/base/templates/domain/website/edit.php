<div class="row">
<div class="col-md-12">
        <?php echo $this->childView('website_edit');?>  
</div>
</div>
<script>
    <?php if($this->getRequest()->query('tab')):?>
    $(window).load(function(){ 
        $('#tab-01 a[href="#<?php echo $this->getRequest()->query('tab');?>"]').tab('show');
    });
    <?php endif;?>
    function callparent()
    { 
        location.reload();           
    }
</script>
