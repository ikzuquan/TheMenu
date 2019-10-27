  <!-- Custom styles for this page -->
  <link href="<?php echo site_url('public/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  

<!-- Begin Page Content -->
<div class="container-fluid">
<?php if($message!=""){ ?>
      <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message;?>
      </div>

<?php } ?>
	<p>
    <?php echo anchor("users/create_user", lang('index_create_user_link'), 'class="btn btn-primary"') ;?>
  </p>
  

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo lang('index_heading');?></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th><?php echo lang('index_fname_th');?></th>
                      <th><?php echo lang('index_lname_th');?></th>
                      <th><?php echo lang('index_email_th');?></th>
                      <th><?php echo lang('index_company_th');?></th>
                      <th><?php echo lang('index_status_th');?></th>
                      <th><?php echo lang('index_groups_th');?></th>
                      <th><?php echo lang('index_action_th');?></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th><?php echo lang('index_fname_th');?></th>
                      <th><?php echo lang('index_lname_th');?></th>
                      <th><?php echo lang('index_email_th');?></th>
                      <th><?php echo lang('index_company_th');?></th>
                      <th><?php echo lang('index_status_th');?></th>
                      <th><?php echo lang('index_groups_th');?></th>
                      <th><?php echo lang('index_action_th');?></th>
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php foreach ($users as $user):?>
						<tr>
							<td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo empty($user->company->company_name) ? '' : htmlspecialchars($user->company->company_name,ENT_QUOTES,'UTF-8'); ?></td>
              <td><?php echo ($user->active) ? lang('index_active_link') : lang('index_inactive_link');?></td>
							<td>
								<?php foreach ($user->groups as $group):?>
									<?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8') ;?><br />
								<?php endforeach?>
							</td>
							<td><?php echo anchor("users/edit_user/".$user->id, 'Edit') ;?></td>
						</tr>
					<?php endforeach;?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
	</div>
</div>
  <!-- Page level plugins -->
  <script src="<?php echo site_url('public/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
  <script src="<?php echo site_url('public/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo site_url('public/js/demo/datatables-demo.js'); ?>"></script>