<?php

function sampling($chars, $size, $combinations = array()) {

    # if it's the first iteration, the first set 
    # of combinations is the same as the set of characters
    if (empty($combinations)) {
        $combinations = $chars;
    }

    # we're done if we're at size 1
    if ($size == 1) {
        return $combinations;
    }

    # initialise array to put new values in
    $new_combinations = array();

    # loop through existing combinations and character set to create strings
    foreach ($combinations as $combination) {
        foreach ($chars as $char) {
            if($combination == $char) {
                continue;
            }
            $new_combinations[] = array($combination,$char);
        }
    }

    # call same function again for the next iteration
    return sampling($chars, $size - 1, $new_combinations);

}
$chars = $this->getCurrencyIds();
$currencyset = sampling($chars, 2); 

$values = is_array($this->getValue()) ? $this->getValue() : json_decode($this->getValue(),true); ?>
<?php foreach($currencyset as $k => $currencyid):?>
<?php $leftcurrency = $this->getCurrencySet(Arr::get($currencyid,0));
$rightcurrency = $this->getCurrencySet(Arr::get($currencyid,1)); ?>
<div class="row">
    <div class="col-sm-4">
         <label class="control-label"><?php echo $leftcurrency->getCurrencyName()."(".$leftcurrency->getCurrencyCode().")";?></label>
         <input type="text" name="<?php echo $this->getFieldName();?>[<?php echo $k; ?>][<?php echo $leftcurrency->getCurrencySettingId();?>]" value="1.00" readonly class="form-control"/>
    </div>
    <div class="col-sm-4">
         <label class="control-label"><?php echo $rightcurrency->getCurrencyName()."(".$rightcurrency->getCurrencyCode().")";?></label>
         <input type="text" name="<?php echo $this->getFieldName();?>[<?php echo $k; ?>][<?php echo $rightcurrency->getCurrencySettingId();?>]" value="<?php echo isset($values[$k][$rightcurrency->getCurrencySettingId()])?$values[$k][$rightcurrency->getCurrencySettingId()]:"";?>" class="form-control"/>
    </div>
    
</div> 
<?php endforeach;?> 