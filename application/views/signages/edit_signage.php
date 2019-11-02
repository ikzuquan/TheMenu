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
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Add New Signage</button>
</div>


<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Signage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open_multipart("signages/upload_signage/".$device_id,  array('id' => 'uploadSignage'));?>
      <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">
                            Upload PNG, JPG and MP4 format only, please set signages size to 1080px X 1920px.)
                        </label>
                        <div>
                            <span class="btn btn-default btn-file">
                                <input id="filename" name="filename[]" type="file" accept='image/jpeg,image/png,video/mp4' class="file" required multiple data-show-upload="true" data-show-caption="true">
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

<div id="editSignage" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit New Timing</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php echo form_open("signages/update_time/".$device_id,  array('id' => 'updateTime'));?>
      <div class="modal-body">
          <label for="update_start_time">Signage Start Time</label>
          <input type="time" class="form-control" id="update_start_time" name="update_start_time" placeholder="Enter Start Time"/>

          <label for="update_end_time">Signage End Time</label>
          <input type="time" class="form-control" id="update_end_time" name="update_end_time" placeholder="Enter End Time"/>
          <input type="hidden" id="update_time_order" name="update_time_order"/>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      <?php echo form_close();?>
    </div>
  </div>
</div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Signages</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered display" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th >Order ID</th>
                      <th>File name</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Created date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Order ID</th>
                      <th>File name</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Created date</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
				  <?php foreach ($signages as $signage):?>
						<tr id="<?php echo htmlspecialchars($signage["order_rank"],ENT_QUOTES,'UTF-8');?>">
              <td><?php echo htmlspecialchars($signage["order_rank"],ENT_QUOTES,'UTF-8');?></td>
							<td><a href="#myImage" onclick='popSignage("<?php echo htmlspecialchars($signage["filename"],ENT_QUOTES,'UTF-8'); ?>")'><?php echo htmlspecialchars($signage["client_name"],ENT_QUOTES,'UTF-8');?></a></td>
							<td><?php echo htmlspecialchars($signage["start_time"],ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($signage["end_time"],ENT_QUOTES,'UTF-8');?></td>
              <td><?php echo htmlspecialchars($signage["timestamp"],ENT_QUOTES,'UTF-8');?></td>
							<td><button class="btn btn-info dt_edit">Edit</button>&nbsp;  <button class="btn btn-danger dt-delete">Delete</button></td>
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
  <script src="<?php echo site_url('public/js/signages.js?v=7'); ?>"></script>

  <div id="myImage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body" id="popup-holder">
          <img id="ImagePlaceholder" src="" class="img-fluid">
        </div>
    </div>
  </div>
</div>