<body class="bg-gradient-primary">
<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
          <div class="col-lg-6">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-2">Password Reset</h1>
                
			  </div>
              <?php echo form_open('auth/reset_password/' . $code);?>
              <?php echo $message;?>
                <div class="form-group">
				  <p>
				  	<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
				  	<?php echo form_input($new_password);?>
				  </p>
				  <p>
				  <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
				  <?php echo form_input($new_password_confirm);?>
				  </p>
				  
                  </div>
                <input type="submit" value="<?php echo lang('reset_password_submit_btn'); ?>" name="submit" class="btn btn-primary btn-user btn-block"/>
				<?php echo form_input($user_id);?>
				<?php echo form_hidden($csrf); ?>
                <?php echo form_close();?>
              <hr>
              <div class="text-center">
                <a class="small" href="login">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>