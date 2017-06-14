<?php $defaultResource = $this->getDefaultResourcesList();
$dbresources = $this->getApi()->getResources();
$resourceaccess = array('GET','PUT','POST','DELETE');?>
<div class="row mt20">
        <div class="col-sm-12">
            <div class="alert alert-info">
                <h4><?php echo __('Info:');?></h4>
                <p>
                    -  <strong><?php echo __('Red');?></strong> <?php echo __('highlighted label will be mandatory.');?><br>
                    
                </p>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal tab-form" method="post" action="<?php echo $this->getUrl('admin/system_webservice/save',$this->getRequest()->query());?>">
        <input type="hidden" name="id" value="<?php echo $this->getApi()->getData('account_id');?>" />
        <div class="tab-content  tab-content-simple mb30 no-padding" > 
                
                
                <div class="form-group">
                    <label class="col-sm-2 control-label required-hightlight"><?php echo __('Api Key');?></label>
                    <div class="col-sm-6">
                        <div class=""> 
                            <input type="text" name="app_key" class="form-control" maxlength="36" value="<?php echo $this->getApi()->getData('app_key');?>">
                        </div>
                        
                    </div>
					<div class="col-sm-2 marg10">
						<button class="btn btn-primary" type="button" id="generate_app_key"><?php echo __('Generate');?></button>
					</div>
                </div><!-- form-group -->

                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo __('Description');?></label>
                    <div class="col-sm-8">
                        <div class=""> 
                            <textarea name="description" rows="8" class="form-control"><?php echo $this->getApi()->getData('description');?></textarea>
                        </div>
                        
                    </div> 
                </div><!-- form-group -->  

   
       
           <div class="form-group">
             <label class="col-sm-2 control-label"><?php echo __('Role');?></label>
             <div class="col-sm-8">
					 
					  <select name="role_id" id="source" style="width:100%">
						  <?php foreach($this->getRolesList() as $list):?>
							  <option <?php echo $this->getRoleId()==$list['value'] ? "selected":"";?> value="<?php echo $list['value'];?>"><?php echo $list['label'];?></option>
						  <?php endforeach;?>
					  </select>
             </div>
           </div>


                <div class="form-group">
                   <label class="col-sm-2 control-label"><?php echo __('Permissions');?></label>
                   <div class="col-sm-10">
                        <table cellpadding="0" cellspacing="0" class="table table-hover table-striped dataTable outer-border accesses">
                            <thead>
                                <tr>
                                    <th><?php echo __('Resource');?></th>
                                    <th><?php echo __('All');?></th>
                                    <th><?php echo __('View(GET)');?></th>   
                                    <th><?php echo __('Update(PUT)');?></th>
                                    <th><?php echo __('Insert(POST)');?></th>
                                    <th><?php echo __('Delete(DELETE)');?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th class="center"><input type="checkbox" class="all_get get "></th>
                                    <th class="center"><input type="checkbox" class="all_put put "></th>
                                    <th class="center"><input type="checkbox" class="all_post post "></th>
                                    <th class="center"><input type="checkbox" class="all_delete delete"></th> 
                                </tr>
                                <?php foreach($defaultResource as $k => $res):?>
                                <tr>
                                    <td><?php echo __($res['title']);?>
									<?php if(isset($res['description']) && $res['description']):?><div class="small"><?php echo __($res['description']);?></div> <?php endif;?>
										 
									</td>
                                    <td><input type="checkbox" class="all" /></td>
                                    <?php foreach($resourceaccess as $resource): ?>
                                        <?php if(isset($res['resource']) && in_array($resource,$res['resource'])):?> 
                                        <td><input type="checkbox" name="resource[<?php echo $k;?>][<?php echo $resource;?>]" <?php if(array_key_exists($k,$dbresources) && in_array($resource,$dbresources[$k])):?>checked="checked"<?php endif;?>value="1" class="<?php echo strtolower($resource);?>"/></td>
                                        <?php else:?>
                                        <td><input type="checkbox" name="resource[<?php echo $k;?>][<?php echo $resource;?>]" disabled="disabled" /></td>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                   </div>
               </div><!-- form-group -->  
             

            <div class="panel-footer">
                <button class="btn btn-primary mr5" type="submit"><?php echo __('Submit');?></button>
                 
                <button type="button" onclick="setLocation('<?php echo $this->getUrl("admin/system_webservice/index");?>')" class="btn btn-default"><?php echo __('Cancel');?></button>               
                <button type="reset" class="btn btn-default"><?php echo __('Reset');?></button>
                 
            </div>
        </div>
        </form>

    </div>
</div>
<script>
    $(function() {
		$('table.accesses input.all').click(function() {
			if($(this).is(':checked'))
				$(this).parent().parent().find('input.get:not(:checked), input.put:not(:checked), input.post:not(:checked), input.delete:not(:checked)').click();
			else
				$(this).parent().parent().find('input.get:checked, input.put:checked, input.post:checked, input.delete:checked').click();
		});
		$('table.accesses .all_get').click(function() {
			if($(this).is(':checked'))
				$(this).parent().parent().parent().find('input.get:not(:checked)').click();
			else
				$(this).parent().parent().parent().find('input.get:checked').click();
		});
		$('table.accesses .all_put').click(function() {
			if($(this).is(':checked'))
				$(this).parent().parent().parent().find('input.put:not(:checked)').click();
			else
				$(this).parent().parent().parent().find('input.put:checked').click();
		});
		$('table.accesses .all_post').click(function() {
			if($(this).is(':checked'))
				$(this).parent().parent().parent().find('input.post:not(:checked)').click();
			else
				$(this).parent().parent().parent().find('input.post:checked').click();
		});
		$('table.accesses .all_delete').click(function() {
			if($(this).is(':checked'))
				$(this).parent().parent().parent().find('input.delete:not(:checked)').click();
			else
				$(this).parent().parent().parent().find('input.delete:checked').click();
		});
		
		$("#generate_app_key").click(function(){
			var string = randomString(32, '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
			$("input[name='app_key']").val(string);
		});
	});
	function randomString(length, chars) {
		var result = '';
		for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
		return result;
	}
</script>
<script>
$(window).load(function(){	
	$('form').preventDoubleSubmission();	
});
</script>
