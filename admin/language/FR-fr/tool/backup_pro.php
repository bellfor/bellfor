<?php
// Heading
$_['heading_title']    			= 'Backup Pro';
	
//Tab
$_['tab_backup']      			= 'Backup';
$_['tab_backup_scheduled']  	= 'Scheduled Backup';
$_['tab_restore']    	  		= 'Restore';
$_['tab_info']      			= 'Additional Information';
	
// Text
$_['text_edit']      			= 'Backup, Schedule a Backup or Restore your Database';
$_['text_yes']      			= 'Yes';
$_['text_no']      				= 'No';
$_['text_enabled']      		= 'Enabled';
$_['text_disabled']      		= 'Disabled';
$_['text_backup']      			= 'Download Backup';
$_['text_backup_filename']      = 'backup';
$_['text_backup_settings']      = '<h1 style="color: #ff8000">Backup Settings:</h1>';
$_['text_backup1']      		= '<h1 style="color: #ff8000">Backup:</h1>';
$_['text_backup2']      		= '<h1 style="color: #ff8000">Scheduled Backups:</h1>';
$_['text_restore']      		= '<h1 style="color: #ff8000">Restore:</h1>';
$_['text_success']     			= 'Success: You have successfully saved your scheduled backup settings!';
$_['text_success_backup']     			= 'Success: Your backup is currently being created as a background process and can be found in the folder <strong>backup_pro/</strong>.<br /><br />This process may take up to an hour or more if there are a significant number of files, so please do not try to download it before the process has finished !';
$_['text_success_backup_ready'] = 'Success: Your backup is ready to be downloaded by ftp from the folder: <strong>system/logs</strong>';
$_['text_success_restore']     	= 'Success: You have successfully restored your database!';
$_['text_success_delete_clone']	= 'Success: You have successfully deleted the cloned database!';
$_['text_instructions']   		= 'Use this section to set up an automatic and regular backup of your database. The backup will be emailed to you.';
$_['text_backup_scheduled_filename']    = 'db-backup';
$_['text_backup_email_subject']     	= 'Database Backup';
$_['text_backup_email_message']     	= 'Here is the database backup';
$_['text_further_information']      	= '<h1 style="color: #ff8000">Further Information:</h1>';
$_['text_further_information2']   		= '<strong>To "clone" a store take the following steps:</strong><ol>
												<li>Make a "Whole Store" backup of your store</li>
												<li>Create a brand new installation of Opencart making sure you use the same version as the store you\'ve backed up. <span style="color: #ff0000">You must also make sure you use the same database prefix as in the cloned store.</span></li>
												<li>Using ftp, upload the backup file to the <strong>root</strong> of your new store</li>
												<li>Log in to your server cPanel and open up the file manager</li>
												<li>Find the backup file in the root of your store, select it then click on the extract files / unzip button. Unzip the files to the root of your store<br /><strong>Note:</strong> if you have had to limit the maximum number of files per zip, you may find additional .zip files in the root of your store. These will also need to be unzipped.</li>
												<li>Delete the .zip file(s) you\'ve just unziped</li>
												<li>Log in to the administration area of your new store, click on <strong>System | Backup/Restore</strong> (you may have to set the user permissions again).<br />In the Restore section, you will have an option to <strong>Restore Backup from a "Cloned" Store</strong>. Click the Restore button.</li>
												<li>Job done!</li></ol><br /><br />To see a video of this process <a href="http://www.showmeademo.co.uk/opencart/backup-pro/" target="_blank"><strong>click here</strong></a><br /><br />
												<strong>To restore Images, Themes and vQmods</strong>, simply follow steps 3, 4, 5 and 6 above.';
$_['text_download_ready']   	= 'Your backup is ready to download. Please press the <strong>Continue</strong> button.'; 
$_['text_wait']      			= '<img src="view/image/loading.gif" alt="preparing backup . . ." /> Preparing your backup - please wait. <br />Please do not refresh or browse away from this page until the process has completed.';
$_['text_restore_wait']      	= '<img src="view/image/loading.gif" alt="restoring backup . . ." /> Restoring your backup - please wait. <br />Please do not refresh or browse away from this page until the process has completed.';
$_['text_no_backups']      		= 'No backups are currently available.';
$_['text_check_email']      	= 'A test backup email has been sent to the email address provided.';
	
// Entry
$_['entry_restore']    			= 'Restore Backup from File:';
$_['entry_backup']     			= 'Select Database Tables:';
$_['entry_backup_filename']     = 'Backup Filename:';
$_['entry_backup_zip']     		= 'Backup as a Zip File (recommended):';
$_['entry_backup_what']     	= 'What Would you like to Backup:';
$_['entry_backup_limit']     	= 'Limit Size of Zip:';
$_['entry_available_backups']  	= 'Available Backups:';
$_['entry_backup_status']     	= 'Schedule Automatic Backups:';
$_['entry_backup_email']     	= 'Email Address to Send Backup:';
$_['entry_backup_email_subject']     	= 'Email Subject:';
$_['entry_backup_email_message']     	= 'Email Message:';
$_['entry_backup_email_status'] = 'Email Backup:';
$_['entry_backup_save_to_server']     	= 'Save Backups to the Server:';
$_['entry_backup_no_of_backups']     	= 'How many Backups to Keep:';
$_['entry_backup_cron']     	= 'Backup Using Cron Job:';
$_['entry_backup_cron_command'] = 'Cron Job Command:<br /><span class="help">Use this command if you set up a Cron Job.</span>';
$_['entry_backup_frequency']    = 'Backup Frequency:';
$_['entry_clone']     			= 'Restore Cloned Store Backup:';
	
// Help
$_['help_backup_limit']     	= 'If you are getting problems with Error 500, timeouts, or exceeding maximum memory, try reducing the maximum size of each zip. This will mean that your backup will consist of 2 or more zip files each of which will also need to be unzipped when restoring your data.';
$_['help_backup_cron']     		= 'Scheduled backups can either be triggered by a Cron Job (recommended) or by visitors to your store (admin or customers).<br /><br />You will need to set up a Cron Job separately through your server\'s cPanel using the command shown below if you select Yes here.<br /><br />If you are not familiar with setting up Cron Jobs, you should select No.';
$_['help_backup_frequency']     = 'If you set up a Cron Job, this field will be ignored.';
$_['help_clone']     			= 'Backup Pro has detected a database backup that seems to have been restored from a Whole Store backup. <br /><br />Click the <strong>No Thanks</strong> button if you would like to delete this file.';
$_['help_restore']    			= 'You can only restore your database here. This should either be a .sql file or a .zip file that contains a .sql file.<br /><br />If you would like to restore your themes and images or a whole store - see the <strong>Additional Information</strong> tab.';
$_['help_available_backups']    = 'Here is a list of available backups. They can be downloaded by clicking the filename or via ftp from the folder <strong>backup_pro/</strong>.';
	
// Button
$_['button_save']     			= 'Save Settings';
$_['button_no']     			= 'No Thanks';
$_['button_continue']     		= 'Continue';
$_['button_test_email']     	= 'Test Email';
$_['button_backup']				= 'Backup';
$_['button_restore']			= 'Restore';
	
// Error
$_['error_permission'] 			= 'Warning: You do not have permission to modify backups!';
$_['error_backup']     			= 'Warning: You must select at least one table to backup!';
$_['error_empty']      			= 'Warning: The file you uploaded was empty!';
$_['error_nofile']      		= 'Warning: You must select a file to upload!';
$_['error_warning']    			= '<strong>Warning: The following file(s) were not readable and have not been included in your backup!</strong>';
$_['error_warning_zipfiles']    = '<strong>Warning: Ziparchives are no longer included in backups. The following file(s) have been excluded!</strong>';
?>