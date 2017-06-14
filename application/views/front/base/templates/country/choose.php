<?php $c = $this->getAvailableCountry();  ?>
<style>
    
</style>
<?php  $current = $this->getUrl("",array('__current' => true));?>
<div class="c-sel-cont grid_10">
    <?php $cc = App::instance()->getCountry()->getIsoCodeShort();
    $cc = $cc ? $cc : "KW";?>
    <div class="c-sel-bg-area" style="background-image:url(<?php echo $this->getAssetsPathUrl('images/country_banner/'.$cc.'.jpg');?>)">
        <div class="c-sel-bg-mask">
            <div class="c-sel-title">Choose your city</div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="res-co-ms"></div>
<div class="c-sel-scroll">
    <div class="c-sel-area">
<?php foreach($c as $country):  if(count($country['cities'])):?> 
<div class="c-sel-con-area">
    <div class="c-sel-con"><img src="<?php echo $this->getAssetsPathUrl('images/flags/'.$country['iso_code_short'].'.png');?>" /><?php echo App::instance()->getCountry()->getId() == $country['country_id']? sprintf("<b class=\"active\">%s</b>",$country['country_name']):$country['country_name'];?></div>
    
    <?php foreach($country['cities'] as $city):?>
    <div class="c-sel-city ">
          <a href="<?php echo $this->getUrl('home/choosecity',array('cid' => Arr::get($city,'city_id'),'coid' => $country['country_id'],'return' => $current));?>" data-iconr="," data-cid="<?php echo Arr::get($city,'city_id');?>" data-coid="<?php echo $country['country_id'];?>" title="Restaurants in Colombo"><?php echo App::instance()->getCity()->getId() == Arr::get($city,'city_id')? sprintf("<b class=\"active\">%s</b>",Arr::get($city,'city_name')):Arr::get($city,'city_name');?>  </a>
      </div>
    <?php endforeach;?>
    <div class="clearfix"></div>
</div>
          
<?php endif; endforeach;?></div>
</div>
</div>