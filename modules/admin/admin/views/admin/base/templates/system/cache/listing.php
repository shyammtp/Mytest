<?php $cachelist = $this->getCacheList();?>
<?php if(count($cachelist)):?>
<table class="table table-striped table-flip-scroll cf">
<thead class="cf">
    <tr>
        <th>
            <div class="checkbox check-default ">
                <input id="checkbox1" type="checkbox" value="1" class="checkall">
                <label for="checkbox1"></label>
            </div>
        </th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
    <?php  foreach($cachelist as $cache):?>
    <tr>
        <td>
            <div class="checkbox check-default">
                <input id="checkbox<?php echo $cache->id;?>" type="checkbox" value="1">
                <label for="checkbox<?php echo $cache->id;?>"></label>
            </div>
        </td>
        <td><?php  echo $cache->type;?></td>
        <td><?php echo $cache->description;?></td>
        <td>
            <?php if($cache->status == true):?>
                <span class="label label-success"><?php echo __('Enabled');?></span>
            <?php else:?>
                <span class="label label-error"><?php echo __('Disabled');?></span>
            <?php endif;?> 
        </td>
    </tr>
    <?php endforeach;?> 
</tbody>
</table>
<?php endif;?>