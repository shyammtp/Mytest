<div class="row">
	<div class="col-md-12">
		<div class="alert alert-info">
            <h4><?php echo __('Info:');?></h4>
                <p>-  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?></p>
            </div>
<!-- Nav tabs -->
<ul class="nav nav-tabs">
</ul>

<form method="post" id="currency_form" class="form-horizontal tab-form" action="<?php echo $this->getUrl('admin/settings/savecurrency',$this->getRequest()->query());?>" accept-charset="UTF-8">
<input type="hidden" name="currency_setting_id" value="<?php echo $this->getRequest()->query('id');?>" />

        <div class="tab-content mb30 no-padding">
        <div class="tab-pane active" id="home3">
			
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Country');?></label>
                <div class="col-sm-10">
						<select name="country_id" style="width:100%" id="select-basic" data-placeholder="Choose One" class="width300">
						<?php foreach($this->_getCountryInfo() as $countryid => $countryname):?>
						<option <?php echo $this->_getCurrencySettings()->getCountryId()==$countryname['country_id'] ? "selected":"";?> value="<?php echo $countryname['country_id'];?>"><?php echo ucfirst($countryname['country_name']);?></option>
						<?php endforeach;?>
						</select>
                </div>
            </div>
            
            	<div class="form-group">
                <label class="col-sm-2 control-label required-hightlight"><?php echo __('Currency Name');?></label>
                <div class="col-sm-10">
                  <input type="text" name="currency_name"  maxlength="255" placeholder="<?php echo __('Currency Name');?>"  class="form-control" value="<?php echo $this->_getCurrencySettings()->getCurrencyName();?>" />
                </div>
            </div>
            
			<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('ISO code');?></label>
                <div class="col-sm-10">
                  <input type="text" name="currency_code"  maxlength="255" placeholder="<?php echo __('ISO code');?>"  class="form-control" value="<?php echo $this->_getCurrencySettings()->getCurrencyCode();?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Numeric ISO Code');?></label>
                <div class="col-sm-10">
                  <input type="text" name="numeric_iso_code"  maxlength="255" placeholder="<?php echo __('Numeric ISO Code');?>"  class="form-control" value="<?php echo $this->_getCurrencySettings()->getNumericIsoCode();?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Currency Symbol Left');?></label>
                <div class="col-sm-10">
                  <input type="text" name="currency_symbol_left"  maxlength="255" placeholder="<?php echo __('Currency Symbol Left');?>"  class="form-control" value="<?php echo $this->_getCurrencySettings()->getCurrencySymbolLeft();?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Currency Symbol Right');?></label>
                <div class="col-sm-10">
                  <input type="text" name="currency_symbol_right"  maxlength="255" placeholder="<?php echo __('Currency Symbol Right');?>"  class="form-control" value="<?php echo $this->_getCurrencySettings()->getCurrencySymbolRight();?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo __('Exchange rate');?></label>
                <div class="col-sm-10">
                  <input type="text" name="exchange_rate"  maxlength="255" placeholder="<?php echo __('Exchange rate');?>"  class="form-control" value="<?php echo $this->_getCurrencySettings()->getCurrencyRate();?>" />
                </div>
            </div>

        </div>

		<div class="panel-footer ">
            <button class="btn btn-primary mr5"><?php echo __('Save');?></button>
            <button class="btn btn-primary mr5" name="backto" value="1"><?php echo __('Save & Continue');?></button>
            <button type="reset" class="btn btn-default"   onclick="setLocation('<?php echo $this->getUrl('admin/settings/currency_settings');?>')" ><?php echo __('Cancel');?></button>
        </div>
        </div>
</form>
</div></div>
<script>
$(window).load(function(){	
	$('#currency_form').preventDoubleSubmission();	
});
</script>
