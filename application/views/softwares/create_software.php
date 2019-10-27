<!-- Begin Page Content -->
<div class="container">
<h1  class="h3 mb-4 text-gray-800">Upload New Version</h1>

<?php if($message!=""){ ?>
      <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message;?>
      </div>

<?php } ?>


<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Software's Information</h6>
            </div>
            <div class="card-body">
      <?php echo form_open_multipart(uri_string());?>

      <p>
            Upload File <br />
            <?php echo form_input($filename);?>
      </p>

      <p>
            Version Number <br />
            <?php echo form_input($version);?>
      </p>
      
      <p>
            Version Description <br />
            <?php echo form_textarea($version_desc);?>
      </p>

      <p><input type="submit" value="Upload New Version" name="submit" class="btn btn-primary btn-user "/>
        </p>
              

<?php echo form_close();?>
        </div>
    </div>
</div>