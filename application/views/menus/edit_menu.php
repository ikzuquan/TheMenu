  <!-- Custom styles for this page -->
  <link href="<?php echo site_url('public/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  <link href="https://cdn.datatables.net/rowreorder/1.2.6/css/rowReorder.dataTables.min.css" rel="stylesheet">

<!-- Begin Page Content -->
<div class="container-fluid">
<?php if($message!=""){ ?>
      <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message;?>
      </div>

<?php } ?>
<?php if($error!=""){ ?>
      <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $error;?>
      </div>

<?php } ?>
<div class="mb-4">
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Add New Menu</button>
</div>


<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart("menus/upload_menu/".$device_id);?>
      <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">
                            Upload PNG or JPG format only, please set menu image size to 1080px X 1920px.)
                        </label>
                        <div>
                            <span class="btn btn-default btn-file">
                                <input id="filename" name="filename[]" type="file" accept='image/jpeg,image/png' class="file" required multiple data-show-upload="true" data-show-caption="true">
                            </span>
                            <?php echo form_hidden('id',$device_id);?>
                        </div>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Upload</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Devices</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered display" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >Order ID</th>
                      <th>File name</th>
                      <th>Created date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Order ID</th>
                      <th>File name</th>
                      <th>Created date</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php foreach ($menus as $menu):?>
						<tr id="<?php echo htmlspecialchars($menu["order_rank"],ENT_QUOTES,'UTF-8');?>">
              <td><?php echo htmlspecialchars($menu["order_rank"],ENT_QUOTES,'UTF-8');?></td>
							<td><a href="#myImage" onclick='popImage("<?php echo htmlspecialchars($menu["filename"],ENT_QUOTES,'UTF-8'); ?>")'><?php echo htmlspecialchars($menu["client_name"],ENT_QUOTES,'UTF-8');?></a></td>
							<td><?php echo htmlspecialchars($menu["timestamp"],ENT_QUOTES,'UTF-8');?></td>
							<td><button class="btn btn-danger">Delete</button></td>
						</tr>
					<?php endforeach;?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
	</div>
</div>
  <!-- Page level plugins-->
  <script src="<?php echo site_url('public/vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
  <script src="<?php echo site_url('public/vendor/datatables/dataTables.bootstrap4.min.js'); ?>"></script> 

  <script src="https://cdn.datatables.net/rowreorder/1.2.6/js/dataTables.rowReorder.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.3.2/bootbox.min.js"></script>
  
  <!-- Page level custom scripts -->
  <script src="<?php echo site_url('public/js/demo/datatables-demo.js?v=5'); ?>"></script>

  <div id="myImage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <img id="ImagePlaceholder" src="" class="img-fluid">
        </div>
    </div>
  </div>
</div>