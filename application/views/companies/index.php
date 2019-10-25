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
    <?php echo anchor("companies/create_company", 'Create Company', 'class="btn btn-primary"') ;?>
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
                      <th>Company Name</th>
                      <th>SSM No</th>
                      <th>Hotline</th>
                      <th>Created Date</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Company Name</th>
                      <th>SSM No</th>
                      <th>Hotline</th>
                      <th>Created Date</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php foreach ($companies as $company):?>
						<tr>
							<td><?php echo htmlspecialchars($company["company_name"],ENT_QUOTES,'UTF-8');?></td>
							<td><?php echo htmlspecialchars($company["ssm_no"],ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($company["hotline"],ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($company["created_date"],ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo ($company["active"]) ? lang('index_active_link') : lang('index_inactive_link');?></td>
							<td><?php echo anchor("companies/edit_company/".$company["id"], 'Edit') ;?></td>
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