<!-- Begin Page Content -->
<div class="container">
<h1  class="h3 mb-4 text-gray-800">Create Company</h1>
<p>Please enter the company's information below.</p>

<?php if($message!=""){ ?>
      <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo $message;?>
      </div>

<?php } ?>


<div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Company's Information</h6>
            </div>
            <div class="card-body">
    <?php echo form_open("companies/create_company");?>

      <p>
            Company Name <br />
            <?php echo form_input($company_name);?>
      </p>

      <p>
            SSM Number <br />
            <?php echo form_input($ssm_no);?>
      </p>
      
      <p>
            Company Address <br />
            <?php echo form_input($address);?>
      </p>

      <p>
            Company Hotline <br />
            <?php echo form_input($hotline);?>
      </p>

      <p><input type="submit" value="Create Company" name="submit" class="btn btn-primary btn-user "/>
        </p>
              

<?php echo form_close();?>
        </div>
    </div>
</div>