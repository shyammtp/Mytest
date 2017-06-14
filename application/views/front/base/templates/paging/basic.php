<?php 
$page = $this->getCurrentPage();
$query = $this->getPagingQueryKey();
$recordsPerPage =  $this->getPerPage();
$start = ($page-1) * $recordsPerPage;
$adjacents = "2";

$prev = $page - 1;
$next = $page + 1;
$lastpage = $this->getLastPage();
$lpm1 = $lastpage - 1;
$from = (($page * $recordsPerPage) - $recordsPerPage + 1);
$to = min(($page * $recordsPerPage), $this->getTotalItem());
$pagination = ""; 
 ?>
<?php if($lastpage > 1):?> 
 <!--pagination Start-->
        <div class="general_pagination">
        <ul>
            <?php if ($page > 1):?>
                <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $prev));?>')" title="Prev">Prev</a></li>
            <?php else:?>
                <li><a href="javascript:;" class="disabled" title="Prev">Prev</a></li>
            <?php endif;?>
            <?php if($lastpage < 7 + ($adjacents * 2)):?>
                <?php for ($counter = 1; $counter <= $lastpage; $counter++):?>
                    <?php if ($counter == $page):?>
                        <li class="active"><a href="javascript:;" title="<?php echo $counter;?>"><?php echo $counter;?></a></li> 
                    <?php else:?>
                        <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $counter));?>')" title="<?php echo $counter;?>"><?php echo $counter;?></a></li> 
                    <?php endif;?>
                <?php endfor;?>
            <?php elseif($lastpage > 5 + ($adjacents * 2)):?>
                <?php if($page < 1 + ($adjacents * 2)):?>
                <?php for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++):?>
                    <?php if($counter == $page):?>
                        <li class="active"><a href="javascript:;" title="<?php echo $counter;?>"><?php echo $counter;?></a></li> 
                    <?php else:?>
                        <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $counter));?>')" title="<?php echo $counter;?>"><?php echo $counter;?></a></li>
                    <?php endif;?>
                <?php endfor;?>
                <li><a href="javascript:;" title="<?php echo "...";?>"><?php echo "...";?></a></li>
                <li><a href="javascript:;" title="<?php echo $lpm1;?>"><?php echo $lpm1;?></a></li>
                <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $lastpage));?>')" title="<?php echo $lastpage;?>"><?php echo $counter;?></a></li>
                <?php elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)):?>
                <li><a href="javascript:;" title="<?php echo 1;?>" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => 1));?>')"><?php echo 1;?></a></li>
                <li><a href="javascript:;" title="<?php echo 2;?>" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => 2));?>')"><?php echo 2;?></a></li>
                <li><a href="javascript:;" title="<?php echo "...";?>">...</a></li>
                <?php for($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++):?>
                    <?php if($counter == $page):?>
                        <li class="active"><a href="javascript:;"><?php echo $counter;?></a></li>
                    <?php else:?>
                        <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $counter));?>')" title="<?php echo $counter;?>"><?php echo $counter;?></a></li>
                    <?php endif;?>
                <?php endfor;?>
                <li><a href="javascript:;" title="<?php echo "...";?>"><?php echo "...";?></a></li>
                <li><a href="javascript:;" title="<?php echo $lpm1;?>"><?php echo $lpm1;?></a></li>
                <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $lastpage));?>')" title="<?php echo $lastpage;?>"><?php echo $counter;?></a></li>
                <?php else:?>
                    <li><a href="javascript:;" title="<?php echo 1;?>" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => 1));?>')"><?php echo 1;?></a></li>
                <li><a href="javascript:;" title="<?php echo 2;?>" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => 2));?>')"><?php echo 2;?></a></li>
                    <?php for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++):?>
                        <?php if($counter == $page):?>
                                <li class="active"><a href="javascript:;"><?php echo $counter;?></a></li>
                            <?php else:?>
                                <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $counter));?>')" title="<?php echo $counter;?>"><?php echo $counter;?></a></li>
                            <?php endif;?>
                    <?php endfor;?>
                <?php endif;?>
            <?php endif;?>  
            <?php if($page < $counter - 1):?>
                <li><a href="javascript:;" onclick="setPagingReload('<?php echo $this->getPageUrl(array($query => $next));?>')" title="Next">Next</a></li>
            <?php else:?>
                <li><a href="javascript:;" class="disabled" title="Next">Next</a></li>
            <?php endif;?>
        </ul>
         <div class="dataTables_info" id="showentries"><?php echo __('Showing <b>:from to :to</b> of :totalpage entries',array(':from' => $from,':to' => $to,':totalpage' => $this->getTotalItem()));?></div> 
        </div>
        <!--pagination End-->
         <?php endif;?>
 
<script>
    function setPagingReload(url) {
        window.location.href= url;
    }
</script>