<!-- BEGIN LOGO -->
<link rel="shortcut icon" href="favicon.ico" />
<?php $return_url = $this->getRequest()->query('return_url');?> 
<div class="container">
  <div class="row login-container animated fadeInUp">  
        <div class="col-md-7 col-md-offset-2 tiles white no-padding">
		 <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
		  
          <h2 class="normal"><?php echo __("You are associated with these store"); ?> </h2> 
          <p class="p-b-20"><?php echo __("Choose the store which you want to continue..."); ?></p>
		  
		   
        </div>
		<div class="tiles grey p-t-20 p-b-20 text-black">
			<form id="frm_login" method="post" class="animated fadeIn" action="<?php echo App::helper('store')->getStoreUrl('storeadmin/index/assignstore');?>">    
                    <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10"> 
                      <?php foreach($this->getStores() as $store):?>
						<?php $store = $this->getStore($store); ?>
						<p class="p-b-20"><a href="<?php echo App::helper('url')->getUrl('storeadmin/index/assignstore',array('store'=> $store->getStoreIndex()));?>"><?php echo $store->getName();?></a></p>
					  <?php endforeach;?>
                    </div> 
				  
			  </form>
		</div>   
      </div>   
  </div>
</div>
 
