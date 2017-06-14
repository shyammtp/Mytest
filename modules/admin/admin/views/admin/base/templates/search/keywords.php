<?php
$ts = $this->getTags(); 
?>
<?php if(count(array_filter($ts))):?>
<?php 
foreach($ts as $entity => $tas) { ?>

<?php foreach($tas as $id => $data): if(!isset($data['edit'])) { continue; }?>
    <li class="results" <?php if(isset($data['edit'])):?>data-link="<?php echo $data['edit'];?>"<?php endif;?>>
        <div class="">
            <div class="col-sm-10">
               <div class="title">
                <?php echo $data['title']; ?>  
               </div>
               <div class="desc">
                    <?php echo $data['description']; ?>
               </div>
               <?php if(isset($data['additional'])):?>
               <div class="add-da">
                    <?php echo $data['additional']; ?>
               </div>
               <?php endif;?>
            </div>
            <div class="col-sm-2"> 
                <?php if(isset($data['edit'])):?>
                <a href="<?php echo $data['edit'];?>"><?php echo __('Edit');?></a>
                <?php endif;?>
            </div>
        </div>
        <div class="clearfix"></div>
    </li>
    <?php endforeach;?>
<?php } ?>
<?php else:?>
<li><?php echo __("No Results");?></li>
<?php endif;?> 
