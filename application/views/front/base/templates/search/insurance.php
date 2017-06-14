<?php $_insurance = $this->getInsurance(); ?>
<?php if($_insurance && $_insurance->getId()):?>
<div class="top_list_insurace_bar">
    <div class="fixed_outer">
	<div class="fixed_inner">
	    <div class="list_insurance_logo">
		<span>
	    <img src="<?php echo $_insurance->getLogo();?>" alt="<?php echo $_insurance->getInsuranceName();?>">
		</span>
	    </div>
	    <div class="insurace_description_top">
		<h3><?php echo $_insurance->getInsuranceName();?></h3>
		<p><?php echo $_insurance->getDescription();?></p>
	    </div>
        </div>
    </div>
</div>
<?php endif;?>
