<?php $roleslist = $this->getRolesList();?>
<?php if(count($roleslist)):?>
<table class="table table-striped table-flip-scroll cf">
<thead class="cf">
    <tr>
        <th>
            <div class="checkbox check-default ">
                <input id="checkbox1" type="checkbox" value="1" class="checkall">
                <label for="checkbox1"></label>
            </div>
        </th>
        <th>S.no</th>
        <th>Role Name</th> 
        <th>Actions</th> 
    </tr>
</thead>
<tbody>
    <?php $s = 1; foreach($roleslist as $role):?>
    <tr>
        <td>
            <div class="checkbox check-default">
                <input id="checkbox<?php echo $role->role_id;?>" type="checkbox" value="1">
                <label for="checkbox<?php echo $role->role_id;?>"></label>
            </div>
        </td>
        <td><?php echo $s;?></td>
        <td><?php echo $role->role_name;?></td> 
        <td><a href="<?php echo App::helper('admin')->getAdminUrl('admin/system_permission_roles/edit',array('id' => $role->role_id));?>"><?php echo __('Edit');?></a> </td> 
    </tr>
    <?php $s++; endforeach;?> 
</tbody>
</table>
<?php endif;?>