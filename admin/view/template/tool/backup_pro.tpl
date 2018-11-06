<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
	  <ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	  </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" form="form-backup" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
    </div>
    <div class="panel-body">
	  
	    <!-- // Manual Backups -->
         <form action="<?php echo $backup; ?>" method="post" enctype="multipart/form-data" id="backup" class="form-horizontal">
		  <div class="col-sm-12" style="margin-bottom: 15px;">
			<?php echo $text_backup1; ?>
		  </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo $entry_backup; ?></label>
            <div class="col-sm-6">
              <div class="well well-sm" style="height: 150px; overflow: auto;">
                <?php foreach ($tables as $table) { ?>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="backup[]" value="<?php echo $table; ?>" checked="checked" />
                    <?php echo $table; ?></label>
                </div>
                <?php } ?>
              </div>
              <a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
			</div>
			<div class="col-sm-3"></div>
          </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-filename"><?php echo $entry_backup_filename; ?></label>
		    <div class="col-sm-6">
		      <input type="text" name="backup_filename" value="<?php echo $backup_filename; ?>" placeholder="<?php echo $entry_backup_filename; ?>" id="backup-filename" class="form-control" />
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group <?php if($tar) {echo 'hidden';} ?>">
		    <label class="col-sm-3 control-label" for="backup-filename"><?php echo $entry_backup_zip; ?></label>
		    <div class="col-sm-6">
			  <div class="btn-group" data-toggle="buttons">
			    <label class="btn btn-primary active">
				  <input type="radio" name="backup_zip" value="1" checked="checked" />Yes
			    </label>
			    <label class="btn btn-primary">
				  <input type="radio" name="backup_zip" value="0" />No
			    </label>
			  </div>
			</div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group <?php if($tar) {echo 'hidden';} ?>">
		    <label class="col-sm-3 control-label" for="backup-limit"><span data-toggle="tooltip" title="<?php echo $help_backup_limit; ?>"><?php echo $entry_backup_limit; ?></span></label>
		    <div class="col-sm-6">
		      <select name="backup_limit" id="backup-limit" class="form-control">
			    <?php foreach($b_limit as $l) { ?>
				  <?php if ($l == $backup_limit) { ?>
					<?php if ($l == 'All Files') { ?>
						<option value="<?php echo $l; ?>" selected="selected"><?php echo $l; ?></option>
					<?php } else { ?>
						<option value="<?php echo $l; ?>" selected="selected"><?php echo $l; ?> Mb</option>
					<?php } ?>
				  <?php } else { ?>
					<?php if ($l == 'All Files') { ?>
						<option value="<?php echo $l; ?>"><?php echo $l; ?></option>
					<?php } else { ?>
						<option value="<?php echo $l; ?>"><?php echo $l; ?> Mb</option>					
					<?php } ?>
				  <?php } ?>
			    <?php } ?>
		      </select>
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-what"><?php echo $entry_backup_what; ?></label>
		    <div class="col-sm-6">
		      <select name="backup_what" id="backup-what" class="form-control">
            	<?php foreach($what as $w) { ?>
	                <option value="<?php echo $w; ?>"><?php echo $w; ?></option>
                <?php } ?>
		      </select>
		    </div>
			<div class="col-sm-3"></div>
	      </div>
 	     <div class="form-group">
          <div class="col-sm-6"></div>
          <div class="col-sm-6">
            <a onclick="doBackup()" class="button"><button type="button" id="button-filter" class="btn btn-primary"><?php echo $button_backup; ?></button></a>
 			<div style="display: none" id="wait"><?php echo $text_wait; ?></div>
         </div>
		 </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_available_backups; ?>"><?php echo $entry_available_backups; ?></span></label>
		    <div class="col-sm-9">
			  <div class="well" style="background: #ffffcc">
				<?php echo $backups_list; ?>
			  </div>
		    </div>
	      </div>
	     </form>
		 
		<hr />
		
			
		<!-- // Scheduled Backups -->
		  <div class="col-sm-12" style="margin-bottom: 15px;">
			<?php echo $text_backup2; ?>
	  	  </div>
         <form action="<?php echo $backup_scheduled; ?>" method="post" enctype="multipart/form-data" id="backup-scheduled" name="backup_scheduled" class="form-horizontal">
	      <input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="backup_scheduled_date" />
	      <input type="hidden" value="0" name="test_email" id="test-email" />
		  <div class="form-group">
		    <div class="col-sm-1"></div>
            <div class="col-sm-10 alert alert-warning" style="background: #ffffcc"><?php echo $text_instructions; ?></div>
		    <div class="col-sm-1"></div>
          </div>
          <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-status"><?php echo $entry_backup_status; ?></label>
		    <div class="col-sm-6">
			  <div class="btn-group" data-toggle="buttons">
			    <label class="btn btn-primary <?php if($backup_scheduled_status == '1') {echo 'active';} ?>">
				  <input type="radio" name="backup_scheduled_status" value="1"<?php if($backup_scheduled_status == '1') {echo ' checked="checked"';} ?> />Yes
			    </label>
			    <label class="btn btn-primary <?php if($backup_scheduled_status == '0') {echo 'active';} ?>">
				  <input type="radio" name="backup_scheduled_status" value="0"<?php if($backup_scheduled_status == '0') {echo ' checked="checked"';} ?> />No
			    </label>
			  </div>
			</div>
			<div class="col-sm-3"></div>
          </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-filename"><?php echo $entry_backup_filename; ?></label>
		    <div class="col-sm-6">
		      <input type="text" name="backup_scheduled_filename" value="<?php echo $backup_scheduled_filename; ?>" id="backup-scheduled-filename" class="form-control" />
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-zip"><?php echo $entry_backup_zip; ?></label>
		    <div class="col-sm-6">
			  <div class="btn-group" data-toggle="buttons">
			    <label class="btn btn-primary <?php if($backup_scheduled_zip == '1') {echo 'active';} ?>">
				  <input type="radio" name="backup_scheduled_zip" value="1"<?php if($backup_scheduled_zip == '1') {echo ' checked="checked"';} ?> />Yes
			    </label>
			    <label class="btn btn-primary <?php if($backup_scheduled_zip == '0') {echo 'active';} ?>">
				  <input type="radio" name="backup_scheduled_zip" value="0"<?php if($backup_scheduled_zip == '0') {echo ' checked="checked"';} ?> />No
			    </label>
			  </div>
			</div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-email"><?php echo $entry_backup_email; ?></label>
		    <div class="col-sm-6">
		      <input type="text" name="backup_scheduled_email" value="<?php echo $backup_scheduled_email; ?>" placeholder="<?php echo $entry_backup_email; ?>" id="backup-scheduled-email" class="form-control" />
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-email-subject"><?php echo $entry_backup_email_subject; ?></label>
		    <div class="col-sm-6">
		      <input type="text" name="backup_scheduled_email_subject" value="<?php echo $backup_scheduled_email_subject; ?>" placeholder="<?php echo $entry_backup_email_subject; ?>" id="backup-scheduled-email-subject" class="form-control" />
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-email-message"><?php echo $entry_backup_email_message; ?></label>
		    <div class="col-sm-6">
		      <textarea name="backup_scheduled_email_message" id="backup-scheduled-email-message" class="form-control"><?php echo $backup_scheduled_email_message; ?></textarea>
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-cron"><span data-toggle="tooltip" title="<?php echo $help_backup_cron; ?>"><?php echo $entry_backup_cron; ?></span></label>
		    <div class="col-sm-6">
			  <div class="btn-group" data-toggle="buttons">
			    <label class="btn btn-primary <?php if($backup_scheduled_cron == '1') {echo 'active';} ?>">
				  <input type="radio" name="backup_scheduled_cron" value="1"<?php if($backup_scheduled_cron == '1') {echo ' checked="checked"';} ?> />Yes
			    </label>
			    <label class="btn btn-primary <?php if($backup_scheduled_cron == '0') {echo 'active';} ?>">
				  <input type="radio" name="backup_scheduled_cron" value="0"<?php if($backup_scheduled_cron == '0') {echo ' checked="checked"';} ?> />No
			    </label>
			  </div>
			</div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-cron-command"><?php echo $entry_backup_cron_command; ?></label>
		    <div class="col-sm-6">
		      <textarea name="backup_scheduled_cron_command" id="backup-scheduled-cron-command" class="form-control"><?php echo $backup_scheduled_cron_command; ?></textarea>
		    </div>
			<div class="col-sm-3"></div>
	      </div>
	      <div class="form-group">
		    <label class="col-sm-3 control-label" for="backup-scheduled-frequency"><span data-toggle="tooltip" title="<?php echo $help_backup_frequency; ?>"><?php echo $entry_backup_frequency; ?></span></label>
		    <div class="col-sm-6">
		      <select name="backup_scheduled_frequency" id="backup-scheduled-frequency" class="form-control">
			<?php foreach ($frequencies as $frequency) { ?>
				<?php if ($frequency == $backup_scheduled_frequency) { ?>
					<option value="<?php echo $frequency; ?>" selected="selected"><?php echo $frequency; ?></option>
				<?php } else { ?>
					<option value="<?php echo $frequency; ?>"><?php echo $frequency; ?></option>
				<?php } ?>
			<?php } ?>
		      </select>
		    </div>
			<div class="col-sm-3"></div>
	      </div>
 	     <div class="form-group">
          <div class="col-sm-3">
          </div>
          <div class="col-sm-3">
            <a onclick="$('#backup-scheduled').submit();" class="button"><button type="button" id="button-save" class="btn btn-primary"><?php echo $button_save; ?></button></a>
          </div>
          <div class="col-sm-3">
            <a onclick="testEmail()" class="button"><button type="button" class="btn btn-success"><?php echo $button_test_email; ?></button></a>
          </div>
		 </div>
	     </form>
		<hr />
		
		
		<!-- // Restore -->
	
		  <div class="col-sm-12" style="margin-bottom: 15px;">
		    <?php echo $text_restore; ?>
		  </div>	
         <form action="<?php echo $restore; ?>" method="post" enctype="multipart/form-data" id="form-restore" class="form-horizontal">
		<?php if (file_exists('../system/logs/database_clone.sql')) { ?>
 	     <div class="form-group">
          <label class="col-sm-3 control-label" for="input-import"><span data-toggle="tooltip" title="<?php echo $help_clone; ?>"><?php echo $entry_clone; ?></span></label>
          <div class="col-sm-3"><a onclick="restoreClone();" class="button"><button type="button" id="button-restore-clone" class="btn btn-success"><?php echo $button_restore; ?></button></a></div>
          <div class="col-sm-6">
            <a href="<?php echo $delete_clone; ?>" class="button"><button type="button" id="button-save" class="btn btn-danger"><?php echo $button_no; ?></button></a>
 			<div style="display: none" id="restore-clone-wait"><?php echo $text_restore_wait; ?></div>
          </div>
		 </div>
		 <hr />
		  <?php } ?>

           <div class="form-group">
             <label class="col-sm-3 control-label" for="input-import"><span data-toggle="tooltip" title="<?php echo $help_restore; ?>"><?php echo $entry_restore; ?></span></label>
             <div class="col-sm-9">
               <input type="file" name="import" id="input-import" />
             </div>
           </div>
           <div class="form-group">
             <div class="col-sm-12">
                
             </div>
           </div>
	      <div class="form-group">
		    <label class="col-sm-3"></label>
		    <div class="col-sm-7">
            <button type="button" onclick="restoreBackup();" id="button-restore" class="btn btn-primary"><?php echo $button_restore; ?></button>
 			<div style="display: none" id="restore-wait"><?php echo $text_restore_wait; ?></div>
		    </div>
			<div class="col-sm-2"></div>
	      </div>
         </form>

	  </div>
	</div>
</div>
</div>
	  
<?php if ($download_available) { ?>
	<script type="text/javascript">
	//-----------------------------------------
	// Download File
	//-----------------------------------------
	$(window).load(function(){
		window.location.href = "<?php echo $backup_download; ?>";
		});
	</script>
<?php } ?>

<script type="text/javascript"><!--
	function doBackup() {
		$('#wait').show();
		$('#backup').submit();
	}
//--></script>

<script type="text/javascript"><!--
	function testEmail() {
		$('#test-email').val('1');
		$('#backup-scheduled').submit();
	}
//--></script>

<script type="text/javascript"><!--
	function restoreBackup() {
		$('#restore-wait').show();
		$('#form-restore').submit();
	}
//--></script>

<script type="text/javascript"><!--
	function restoreClone() {
		$('#restore-clone-wait').show();
		window.location.href='<?php echo $restore_clone; ?>';
	}
//--></script>
<?php echo $footer; ?> 

