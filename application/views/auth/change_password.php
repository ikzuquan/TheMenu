<!-- Begin Page Content -->
<div class="container">

<!-- Page Heading -->
<h1  class="h3 mb-4 text-gray-800"><?php echo lang('change_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>

      <p>
            <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
            <?php echo form_input($old_password);?>
      </p>

      <p>
            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
            <?php echo form_input($new_password);?>
      </p>

      <p>
            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
            <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>
      <p><input type="submit" value="<?php echo lang('change_password_submit_btn'); ?>" name="submit" class="btn btn-primary btn-user btn-block"/></p>
      
				

<?php echo form_close();?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->