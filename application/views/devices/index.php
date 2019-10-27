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
    <?php echo anchor("devices/create_device", 'Create Device', 'class="btn btn-primary"') ;?>
  </p>
  

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Devices</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Company</th>
                      <th>Mac Address</th>
                      <th>PIC info</th>
                      <th>Retail info</th>
                      <th>Active</th>
                      <th>Created Date</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Company</th>
                      <th>Mac Address</th>
                      <th>PIC info</th>
                      <th>Retail info</th>
                      <th>Active</th>
                      <th>Created Date</th>
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php foreach ($devices as $device):?>
						<tr>
              <td><?php echo empty($device["company_id"]->company_name) ? '' : htmlspecialchars($device["company_id"]->company_name,ENT_QUOTES,'UTF-8'); ?></td>
              
							<td><?php echo htmlspecialchars($device["mac_address"],ENT_QUOTES,'UTF-8');?></td>
              <td>
                <?php echo htmlspecialchars($device["pic_name"],ENT_QUOTES,'UTF-8');?><br>
                <?php echo htmlspecialchars($device["pic_contact"],ENT_QUOTES,'UTF-8');?>
              </td>
              <td>
                <?php echo htmlspecialchars($device["installation_address"],ENT_QUOTES,'UTF-8');?><br>
                <?php echo htmlspecialchars($device["working_day"],ENT_QUOTES,'UTF-8');?>
              </td>
              <td><?php echo ($device["active"]) ? lang('index_active_link') : lang('index_inactive_link');?></td>
							<td><?php echo anchor("devices/edit_device/".$device["id"], 'Edit') ;?></td>
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