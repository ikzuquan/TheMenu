<!-- Begin Page Content -->
<div class="container">
<h1  class="h3 mb-4 text-gray-800">Edit Device</h1>
<p>Please enter the device's information below.</p>

<?php if($message!=""){ ?>
      <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message;?>
      </div>

<?php } ?>


<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Device's Information</h6>
            </div>
            <div class="card-body">
      <?php echo form_open(uri_string());?>

      <p>
            Mac Address <br />
            <?php echo form_input($mac_address);?>
      </p>
      <p>
            Company Name <br />
            <?php echo form_dropdown($company_id["name"], $company_id["data"], $company_id["value"], 'class="form-control"');?>
      </p>
      <p>
            Installation Address <br />
            <?php echo form_textarea($installation_address);?>
      </p>

      <p>
            Installation Date <br />
            <?php echo form_input($installation_date);?>
      </p>

      <p>
            PIC Name<br />
            <?php echo form_input($pic_name);?>
      </p>
      <p>
            PIC Contact <br />
            <?php echo form_input($pic_contact);?>
      </p>
      <p>
            Working Day<br />
            <?php echo form_textarea($working_day);?>
      </p>

      <p>
            Active Device <br />
            <?php echo form_dropdown($status["name"], $status["data"], $status["value"], 'class="form-control"');?>
      </p>

      <p><input type="submit" value="Edit Device" name="submit" class="btn btn-primary btn-user "/>
        </p>
        <?php echo form_hidden('id', $device->id);?>

<?php echo form_close();?>
        </div>
    </div>
</div>