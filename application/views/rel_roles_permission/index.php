<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Rel Roles Permissions Listing</h3>
            	<div class="box-tools">
                    <a href="<?php echo site_url('rel_roles_permission/add'); ?>" class="btn btn-success btn-sm">Add</a> 
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
						<th>ID</th>
						<th>Role Id</th>
						<th>Permission Id</th>
						<th>Actions</th>
                    </tr>
                    <?php foreach($rel_roles_permissions as $r){ ?>
                    <tr>
						<td><?php echo $r['id']; ?></td>
						<td><?php echo $r['role_id']; ?></td>
						<td><?php echo $r['permission_id']; ?></td>
						<td>
                            <a href="<?php echo site_url('rel_roles_permission/edit/'.$r['id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span> Edit</a> 
                            <a href="<?php echo site_url('rel_roles_permission/remove/'.$r['id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                                
            </div>
        </div>
    </div>
</div>
