<?php 
class ControllerToolBackupPro extends Controller { 
	private $error = array();
	private $max_files = 5000;

	private $backup_folder = '../backup_pro/';
	private $backup_filetype = '.tgz';

	
	public function index() {	

		$this->optimiseResources();
		
		$this->load->language('tool/backup_pro');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('tool/backup_pro');
				
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			
			if (isset($this->request->post['backup_scheduled_status'])) {
				if ($this->user->hasPermission('modify', 'tool/backup_pro')) {
					$this->load->model('setting/setting');
					$this->model_setting_setting->editSetting('backup_scheduled', $this->request->post);
									
					$this->session->data['success'] = $this->language->get('text_success');
				} else {
					$this->session->data['error_warning'] = $this->language->get('error_permission');
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
					}
				}
				
				// Check to see if the email needs testing
				if($this->request->post['test_email'] == '1') {
					$this->model_tool_backup_pro->testEmail();
					
					$this->load->language('tool/backup_pro');
					$this->session->data['success'] = $this->language->get('text_check_email');
				
				}
			}
			
		}

		// Check if a backup has been made & if so, set the trigger for download
		$data['download_available'] = FALSE;
		if(isset($this->session->data['download_file'])) {
			$data['download_available'] = TRUE;
		} 
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['tab_backup'] = $this->language->get('tab_backup');
		$data['tab_backup_scheduled'] = $this->language->get('tab_backup_scheduled');
		$data['tab_restore'] = $this->language->get('tab_restore');
		$data['tab_info'] = $this->language->get('tab_info');
	
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		$data['text_backup_settings'] = $this->language->get('text_backup_settings');
		$data['text_backup_filename'] = $this->language->get('text_backup_filename');
		$data['text_backup1'] = $this->language->get('text_backup1');		
		$data['text_backup2'] = $this->language->get('text_backup2');		
		$data['text_restore'] = $this->language->get('text_restore');		
		$data['text_instructions'] = $this->language->get('text_instructions');		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_wait'] = $this->language->get('text_wait');
		$data['text_restore_wait'] = $this->language->get('text_restore_wait');
		$data['entry_restore'] = $this->language->get('entry_restore');
		$data['entry_backup'] = $this->language->get('entry_backup');
		$data['entry_available_backups'] = $this->language->get('entry_available_backups');
		$data['entry_backup_zip'] = $this->language->get('entry_backup_zip');
		$data['entry_backup_filename'] = $this->language->get('entry_backup_filename');
		$data['entry_backup_status'] = $this->language->get('entry_backup_status');
		$data['entry_backup_what'] = $this->language->get('entry_backup_what');
		$data['entry_backup_limit'] = $this->language->get('entry_backup_limit');
		$data['entry_backup_email'] = $this->language->get('entry_backup_email');
		$data['entry_backup_email_status'] = $this->language->get('entry_backup_email_status');
		$data['entry_backup_email_subject'] = $this->language->get('entry_backup_email_subject');
		$data['entry_backup_email_message'] = $this->language->get('entry_backup_email_message');
		$data['entry_backup_save_to_server'] = $this->language->get('entry_backup_save_to_server');
		$data['entry_backup_no_of_backups'] = $this->language->get('entry_backup_no_of_backups');
		$data['entry_backup_cron'] = $this->language->get('entry_backup_cron');
		$data['entry_backup_cron_command'] = $this->language->get('entry_backup_cron_command');
		$data['entry_backup_frequency'] = $this->language->get('entry_backup_frequency');
		$data['entry_backups_list'] = $this->language->get('entry_backups_list');
		$data['entry_clone'] = $this->language->get('entry_clone');
		$data['text_further_information'] = $this->language->get('text_further_information');
		$data['text_further_information2'] = $this->language->get('text_further_information2');
 
		$data['help_backup_limit'] = $this->language->get('help_backup_limit');
		$data['help_available_backups'] = $this->language->get('help_available_backups');
		$data['help_backup_cron'] = $this->language->get('help_backup_cron');
		$data['help_backup_frequency'] = $this->language->get('help_backup_frequency');
		$data['help_clone'] = $this->language->get('help_clone');
		$data['help_restore'] = $this->language->get('help_restore');

		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_backup'] = $this->language->get('button_backup');
		$data['button_restore'] = $this->language->get('button_restore');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_no'] = $this->language->get('button_no');
		$data['button_test_email'] = $this->language->get('button_test_email');

		
		$data['what'] = array('Database Only', 'Images, Themes and VQMods', 'Whole Store (inc Database)');
		$data['b_limit'] = array('All Files', '500', '450', '400', '350', '300', '250', '200', '150', '125', '100', '75');
		$data['tar'] = $this->isTarEnabled();
		
		if(isset($this->request->post['backup_filename'])) {
			$data['backup_filename'] = $this->request->post['backup_filename'];
		} elseif ($this->config->get('backup_filename') != '') {
			$data['backup_filename'] = $this->config->get('backup_filename');
		} else {
			$data['backup_filename'] = $data['text_backup_filename'];
		}

		if(isset($this->request->post['backup_limit'])) {
			$data['backup_limit'] = $this->request->post['backup_limit'];
		} elseif ($this->config->get('backup_limit') != '') {
			$data['backup_limit'] = $this->config->get('backup_limit');
		} else {
			$data['backup_limit'] = 'All Files';
		}
		
		if(isset($this->request->post['backup_scheduled_status'])) {
			$data['backup_scheduled_status'] = $this->request->post['backup_scheduled_status'];
		} elseif ($this->config->get('backup_scheduled_status') != '') {
			$data['backup_scheduled_status'] = $this->config->get('backup_scheduled_status');
		} else {
			$data['backup_scheduled_status'] = '0';
		}

		if(isset($this->request->post['backup_scheduled_filename'])) {
			$data['backup_scheduled_filename'] = $this->request->post['backup_scheduled_filename'];
		} elseif ($this->config->get('backup_scheduled_filename') != '') {
			$data['backup_scheduled_filename'] = $this->config->get('backup_scheduled_filename');
		} else {
			$data['backup_scheduled_filename'] = $data['text_backup_filename'];
		}

		if(isset($this->request->post['backup_scheduled_zip'])) {
			$data['backup_scheduled_zip'] = $this->request->post['backup_scheduled_zip'];
		} elseif ($this->config->get('backup_scheduled_zip') != '') {
			$data['backup_scheduled_zip'] = $this->config->get('backup_scheduled_zip');
		} else {
			$data['backup_scheduled_zip'] = 1;
		}

		if(isset($this->request->post['backup_scheduled_email'])) {
			$data['backup_scheduled_email'] = $this->request->post['backup_scheduled_email'];
		} elseif ($this->config->get('backup_scheduled_email') != '') {
			$data['backup_scheduled_email'] = $this->config->get('backup_scheduled_email');
		} else {
			$data['backup_scheduled_email'] = $this->config->get('config_email');
		}

		if(isset($this->request->post['backup_scheduled_email_subject'])) {
			$data['backup_scheduled_email_subject'] = $this->request->post['backup_scheduled_email_subject'];
		} elseif ($this->config->get('backup_scheduled_email') != '') {
			$data['backup_scheduled_email_subject'] = $this->config->get('backup_scheduled_email_subject');
		} else {
			$data['backup_scheduled_email_subject'] = $this->config->get('config_name') . ' - ' . $this->language->get('text_backup_email_subject');
		}

		if(isset($this->request->post['backup_scheduled_email_message'])) {
			$data['backup_scheduled_email_message'] = $this->request->post['backup_scheduled_email_message'];
		} elseif ($this->config->get('backup_scheduled_email') != '') {
			$data['backup_scheduled_email_message'] = $this->config->get('backup_scheduled_email_message');
		} else {
			$data['backup_scheduled_email_message'] = $this->language->get('text_backup_email_message');
		}
		
		$data['frequencies'] = array('Daily', 'Weekly', 'Monthly');
		
		if(isset($this->request->post['backup_scheduled_frequency'])) {
			$data['backup_scheduled_frequency'] = $this->request->post['backup_scheduled_frequency'];
		} elseif ($this->config->get('backup_scheduled_frequency') != '') {
			$data['backup_scheduled_frequency'] = $this->config->get('backup_scheduled_frequency');
		} else {
			$data['backup_scheduled_frequency'] = '';
		}

		$data['backup_scheduled_cron_command'] = 'curl --silent "' . HTTP_CATALOG . 'index.php?route=tool/backup_pro" > /dev/null';
		
		if(isset($this->request->post['backup_scheduled_cron'])) {
			$data['backup_scheduled_cron'] = $this->request->post['backup_scheduled_cron'];
		} elseif ($this->config->get('backup_scheduled_email') != '') {
			$data['backup_scheduled_cron'] = $this->config->get('backup_scheduled_cron');
		} else {
			$data['backup_scheduled_cron'] = 0;
		}

		if (isset($this->session->data['error_warning']) && !isset($data['error_warning'])) {
    		$data['error_warning'] = $this->session->data['error_warning'];
    
			unset($this->session->data['error_warning']);
 		} elseif (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => (VERSION >= '2.2.0.0' ? $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true) : $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')),     		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => (VERSION >= '2.2.0.0' ? $this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL') : $this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL')),
      		'separator' => ' :: '
   		);
		
		if(VERSION >= '2.2.0.0') {
			$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true);
			$data['restore'] = $this->url->link('tool/backup_pro/restore', 'token=' . $this->session->data['token'], true);

			$data['restore_clone'] = html_entity_decode($this->url->link('tool/backup_pro/restore_clone', 'token=' . $this->session->data['token'], true));
			$data['delete_clone'] = $this->url->link('tool/backup_pro/delete_clone', 'token=' . $this->session->data['token'], true);

			$data['backup'] = $this->url->link('tool/backup_pro/backup', 'token=' . $this->session->data['token'], true);
			$data['backup_download'] = HTTP_SERVER . 'index.php?route=tool/backup_pro/download&token=' . $this->session->data['token'];
			$data['backup_scheduled'] = $this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true);
		} else {
			$data['cancel'] = $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL');
			$data['restore'] = $this->url->link('tool/backup_pro/restore', 'token=' . $this->session->data['token'], 'SSL');

			$data['restore_clone'] = html_entity_decode($this->url->link('tool/backup_pro/restore_clone', 'token=' . $this->session->data['token'], 'SSL'));
			$data['delete_clone'] = $this->url->link('tool/backup_pro/delete_clone', 'token=' . $this->session->data['token'], 'SSL');

			$data['backup'] = $this->url->link('tool/backup_pro/backup', 'token=' . $this->session->data['token'], 'SSL');
			$data['backup_download'] = HTTP_SERVER . 'index.php?route=tool/backup_pro/download&token=' . $this->session->data['token'];
			$data['backup_scheduled'] = $this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL');
		}

		$this->load->model('tool/backup_pro');
			
		$data['tables'] = $this->model_tool_backup_pro->getTables();


		$backup_files = scandir('../backup_pro');
		$backups = array();
		foreach($backup_files as $backup_file) {
			if(substr($backup_file, -4) == '.tar' || substr($backup_file, -4) == '.tgz' || substr($backup_file, -4) == '.zip') {
				$backups[] = array(
					'filename' 		=> $backup_file,
					'size'			=> $this->formatSize(filesize($this->backup_folder . $backup_file)),
					'file_date'		=> filemtime($this->backup_folder . $backup_file)
				);
			}
		}
		
		$backups_list = $this->language->get('text_no_backups');
		if($backups) {
			foreach($backups as $key => $row) {
				$filename[$key] = $row['filename'];
				$size[$key] = $row['size'];
				$file_date[$key] = $row['file_date'];
			}
			array_multisort($file_date, SORT_DESC, $filename, SORT_ASC, $size, SORT_DESC, $backups);
		
			$backups_list = '';
			foreach($backups as $backup) {
				$backups_list .= '<div style="width: 55%; float: left;"><a href="' . $this->backup_folder . $backup['filename'] . '">' . $backup['filename'] . '</a></div>';
				$backups_list .= '<div style="width: 15%; float: left; text-align: right;">' . $backup['size'] . '</div>';
				$backups_list .= '<div style="width: 15%; float: left; text-align: center;">' . date('Y-m-d', $backup['file_date']) . '</div>';
				$backups_list .= '<div style="width: 15%; float: left; text-align: center;"><a href="' . $this->url->link('tool/backup_pro/deleteBackup', '&del=' . $this->backup_folder . $backup['filename'] . '&token=' . $this->session->data['token'], 'SSL') . '">delete</a></div>';
				$backups_list .= '<div style="clear: both;"></div>';
			}
		}
		$data['backups_list'] = $backups_list;
		
			

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('tool/backup_pro.tpl', $data));
	}
	
	public function backup() {
	
		$this->optimiseResources();
	
		$this->load->language('tool/backup_pro');
		
		if (!isset($this->request->post['backup'])) {
			$this->session->data['error_warning'] = $this->language->get('error_backup');
			
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));
					}
		} elseif ($this->user->hasPermission('modify', 'tool/backup_pro')) {

			if (isset($this->request->post['backup_limit'])) {
				if(VERSION <= '2.0.0.0') {
					$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `group` = 'backup'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `group` = 'backup', `key` = 'backup_limit', `value` = '" . $this->db->escape($this->request->post['backup_limit']) . "'");
				} else {
					$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `code` = 'backup'");
					$this->db->query("INSERT INTO " . DB_PREFIX . "setting SET `code` = 'backup', `key` = 'backup_limit', `value` = '" . $this->db->escape($this->request->post['backup_limit']) . "'");
				}
			}
		
			// Backup Database Only (unzipped)
			if ($this->request->post['backup_zip'] == 0 && $this->request->post['backup_what'] == 'Database Only') {
				$this->load->model('tool/backup_pro');
				$this->model_tool_backup_pro->backup($this->request->post['backup']);

				$destination = '../system/logs/database.sql';
				$filename = $this->request->post['backup_filename'] . '_' . date('Y-m-d_H-i-s', time()).'.sql';

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-type: application/octet-stream");
				header("Content-Disposition: attachment; filename=\"".$filename."\"");
				header("Content-Transfer-Encoding: binary");
				// make sure the file size isn't cached
				clearstatcache();
				header("Content-Length: ".filesize($destination));
				// output the file
				readfile($destination);
			
				unlink('../system/logs/database.sql');
				
			// Backup Database Only (zipped)
			} elseif ($this->request->post['backup_what'] == 'Database Only') {
				$this->load->model('tool/backup_pro');
				$this->model_tool_backup_pro->backup($this->request->post['backup']);
				
				$archive = $this->request->post['backup_filename'] . '_db_' . date('Y-m-d_H-i-s', time()) . '.sql.zip';
				$destination = '../backup_pro/' . $archive;
				
				$zip = new ZipArchive();
				if(!$zip->open($destination, ZIPARCHIVE::CREATE)) {
					die('Unable to create the ziparchive . . .');
					return false;
				}
				
				$filename = '../system/logs/database.sql';
				
				$zip->addFile($filename, 'database.sql');
				
				$zip->close();
				
				
				$this->session->data['download_file'] = $destination;
				$this->session->data['archive'] = $archive;
				
				if(VERSION >= '2.2.0.0') {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
				} else {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
				}
				
			
			// Backup Images, Themes and VQMods
			} elseif ($this->request->post['backup_what'] == 'Images, Themes and VQMods') {

				if($this->isTarEnabled()) {
					$filename = $this->request->post['backup_filename'];
				
					if($this->backup_filetype == '.tgz') {
						$operations = ' czf ';
					} else {
						$operations = ' cf ';
					}
					
					$tar = exec("command -v tar");
					
					$archive = '../backup_pro/' . $filename . '_images_themes_vqmods_' . date('Y-m-d_H-i-s', time()) . $this->backup_filetype;
					$cmd = $tar . $operations . $archive . " -X ../backup_pro/excludes/excludes.txt ../image/ ../catalog/view/theme/ ../vqmod/xml/ > tar.log 2>&1";
					
					exec($cmd);
					
					$this->load->language('tool/backup_pro');
					$this->session->data['success'] = $this->language->get('text_success_backup');
					
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
					}
				} else {
			
				$filename = $this->request->post['backup_filename'] . '_images_themes_vqmods';
				$archive = '../system/logs/' . $filename;
				$root = str_replace('\\', '/', substr(DIR_SYSTEM, 0, -7));
				$sources = array('../image/data/', '../image/templates/', '../catalog/view/theme/', '../vqmod/xml/');
				if ($this->request->post['backup_limit'] != 'All Files') {
					$this->session->data['limit'] = $this->request->post['backup_limit'];
				} else {
					$this->session->data['limit'] = false;
				}
				$this->listFiles($sources);

				$this->session->data['filename'] = $filename;
				$this->session->data['archive'] = $archive;
				$this->session->data['backup_what'] = 'Images, Themes & VQMods';
				$this->session->data['part'] = 1;
				$this->session->data['timestamp'] = date('Y-m-d_H-i-s', time());
				if(VERSION >= '2.2.0.0') {
					$this->response->redirect($this->url->link('tool/backup_pro/Zipp', 'token=' . $this->session->data['token'], true));			
				} else {
					$this->response->redirect($this->url->link('tool/backup_pro/Zipp', 'token=' . $this->session->data['token'], 'SSL'));			
				}
				

				}
			
			// Backup Whole Store (inc Database)
			} elseif ($this->request->post['backup_what'] == 'Whole Store (inc Database)') {

				// Backup Database
				$this->load->model('tool/backup_pro');
				$this->model_tool_backup_pro->backup($this->request->post['backup']);
				rename('../system/logs/database.sql', '../system/logs/database_clone.sql');
				
				if($this->isTarEnabled()) {
					
					$filename = $this->request->post['backup_filename'];
							
					if($this->backup_filetype == '.tgz') {
						$operations = ' czf ';
					} else {
						$operations = ' cf ';
					}
					
					$tar = exec("command -v tar");
					
					$archive = '../backup_pro/' . $filename . '_all_' . date('Y-m-d_H-i-s', time()) . $this->backup_filetype;
					$cmd = $tar . $operations . $archive . " -X ../backup_pro/excludes/excludes.txt ../* > tar.log 2>&1";
					
					copy('../config.php', '../_config.php');
					copy('config.php', '_config.php');
					
					exec($cmd);
					
					$this->load->language('tool/backup_pro');
					$this->session->data['success'] = $this->language->get('text_success_backup');
					
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
					}
				} else {
			
					$data = array(
						'backup_filename' 	=> $this->request->post['backup_filename'],
						'backup_limit'		=> $this->request->post['backup_limit']
						);
					$this->session->data['wholestore'] = $data;
					$this->session->data['backup_what'] = 'Whole Store';
					
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro/wholestore', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro/wholestore', 'token=' . $this->session->data['token'], 'SSL'));			
					}
				}

			}
		} else {
			$this->session->data['error_warning'] = $this->language->get('error_permission');
			
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
		}
	}
	
	public function wholestore() {
				
		// List Files (including database)
		$data = array();
		$data = $this->session->data['wholestore'];
		$filename = $data['backup_filename'] . '_all';
		$archive = '../system/logs/' . $filename;
		$root = str_replace('\\', '/', substr(DIR_SYSTEM, 0, -7));
		$sources = array($root);

		if ($data['backup_limit'] != 'All Files') {
			$this->session->data['limit'] = $data['backup_limit'];
		} else {
			$this->session->data['limit'] = false;
		}
		$this->listFiles($sources);

		$this->session->data['filename'] = $filename;
		$this->session->data['archive'] = $archive;
		$this->session->data['part'] = 1;
		$this->session->data['timestamp'] = date('Y-m-d_H-i-s', time());
		if(VERSION >= '2.2.0.0') {
			$this->response->redirect($this->url->link('tool/backup_pro/Zipp', 'token=' . $this->session->data['token'], true));			
		} else {
			$this->response->redirect($this->url->link('tool/backup_pro/Zipp', 'token=' . $this->session->data['token'], 'SSL'));			
		}
									
	}


	public function listFiles($sources = array()) {
	
		$this->optimiseResources();

		$limit = $this->session->data['limit'];
		$this->session->data['zipfiles'] = array();
		
		$part = 1;
		$backup_size = 0;
		$ctr = 0;
		
	// Check if the backup table exists and create if necessary
		$query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "backup'");
		
		if(!$query->num_rows) {
			$this->db->query("CREATE TABLE `" . DB_PREFIX . "backup` (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				 `file_name` varchar(1024) NOT NULL,
				 `type` varchar(6) NOT NULL,
				 `size` int(11) NOT NULL,
				 `part` int(2) NOT NULL,
				 PRIMARY KEY (`id`)
				) ENGINE=MyISAM AUTO_INCREMENT=1");
		}

	
	// Put the file data into the backup table
	
		$this->db->query("TRUNCATE TABLE " . DB_PREFIX . "backup");
		$root = str_replace('\\', '/', substr(DIR_SYSTEM, 0, -7));

		foreach ($sources as $source) {
			$source = str_replace('\\', '/', realpath($source));

			if (is_dir($source) === true) {
				if($source != substr($root, 0, -1)) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "backup (`file_name`, `type`, `size`, `part`) VALUES ('" . str_replace($root, '', $source) . "', 'DIR', '0', '1')");
				}
					
				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::LEAVES_ONLY, RecursiveIteratorIterator::CATCH_GET_CHILD);
				
				foreach ($files as $file)
				{
					$file = str_replace('\\', '/', $file);

					// Ignore "." and ".." folders
					if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
						continue;

					$file = realpath($file);
					$file = str_replace('\\', '/', $file);
				
					if (is_dir($file) === true && !strpos($file, 'image/cache/')) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "backup (`file_name`, `type`, `size`, `part`) VALUES ('" . str_replace($root, '', $this->db->escape($file) . '/') . "', 'DIR', '0', '1')");
					} else if (is_file($file) === true && !strpos($file, 'image/cache/')) {
					
						if(substr($file, -4) == '.zip' || substr($file, -3) == '.gz') {
							$this->session->data['zipfiles'][] = $file;
							continue;
						}
						$ctr++;
						if ($limit) {
							$backup_size = $backup_size + filesize($file);
							if ($backup_size >= $limit * 1048576 || $ctr >= $this->max_files) {
								$part++;
								$ctr = 0;
								$backup_size = 0;
							}	
						}
						$this->db->query("INSERT INTO " . DB_PREFIX . "backup (`file_name`, `type`, `size`, `part`) VALUES ('" . str_replace($root, '', $this->db->escape($file)) . "', 'FILE', '" . filesize($file) . "', '" . $part . "')");
					}
					
				}
			}
			else if (is_file($source) === true)
			{
				if ($limit) {
					$backup_size = $backup_size + filesize($source);
					if ($backup_size >= $limit * 1048576) {
						$part++;
						$backup_size = 0;
					}	
				}
				$this->db->query("INSERT INTO " . DB_PREFIX . "backup (`file_name`, `type`, `size`, `part`) VALUES ('" . str_replace($root, '', $this->db->escape($source)) . "', 'FILE', '" . filesize($source) . "', '" . $part . "')");
			}
		}
		$this->session->data['parts'] = $part;
	}


	public function Zipp() {
	
		$this->optimiseResources();

		$skipped = (isset($this->session->data['skipped']) ? TRUE : FALSE);
		if ($skipped) {
			$skipped_files = $this->session->data['skipped'];
		} else {
			$skipped_files = array();
		}

		if (!isset($this->session->data['part'])) {
			$this->session->data['error_warning'] = $this->language->get('error_permission');
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
		}
		
		$root = str_replace('\\', '/', substr(DIR_SYSTEM, 0, -7));
		$parts = $this->session->data['parts'];
		$part = $this->session->data['part'];
		$timestamp = $this->session->data['timestamp'];
		$filename = $this->session->data['filename'];
		
		// Get Files to be zipped
		
		if ($parts == 1) {
			$archive = $filename . '_' . $timestamp . '.zip';
		} elseif ($part <= 9) {
			$archive = $filename . '_' . $timestamp . '_part_0' . trim($part) . '.zip';
		} else {
			$archive = $filename . '_' . $timestamp . '_part_' . trim($part) . '.zip';
		}
		$destination = '../backup_pro/' . $archive;

		$zip = new ZipArchive();
		if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
			return false;
		}
		
		
		if ($part == 1) {
			$query = $this->db->query("SELECT `file_name` FROM " . DB_PREFIX . "backup WHERE `type` = 'DIR'");
			
			if ($query->rows) {
				foreach ($query->rows as $result) {
					$zip->addEmptyDir($result['file_name']);			
				}
			}
		}
		
		$query = $this->db->query("SELECT `file_name` FROM " . DB_PREFIX . "backup WHERE `type` = 'FILE' AND `part` = '" . $part . "'");
		foreach ($query->rows as $result) {
			if (is_file($root . $result['file_name']) && is_readable($root . $result['file_name'])) {
			
				// Rename config files
				if ($result['file_name'] == 'config.php') {
					$zip->addFile($root . $result['file_name'], '_config.php');
				} elseif ($result['file_name'] == 'admin/config.php') {
					$zip->addFile($root . $result['file_name'], 'admin/_config.php');
				} else {
					$zip->addFile($root . $result['file_name'], $result['file_name']);
				} 
			} else {
				// File has been skipped and needs to be logged
				$skipped = TRUE;
				$skipped_files[] = $root . $result['file_name'];
				$this->log->write('BACKUP PRO WARNING - ' . $result['file_name'] . ' was not readable and was not included in the backup archive!');
			}
		}
		
		$zip->close();
		
		
		if ($this->session->data['part'] < $parts) {
			$this->session->data['part'] = $this->session->data['part'] + 1;
			if ($skipped) {
				$this->session->data['skipped'] = $skipped_files;
			}
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro/Zipp', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro/Zipp', 'token=' . $this->session->data['token'], 'SSL'));			
			}
		} else {
			$this->session->data['parts'] = $parts;
			$list = '';

			$this->load->language('tool/backup_pro');
			if ($skipped) {

			// Format then render the message page
				
				$list = '<ul>';
				foreach ($skipped_files as $skipped_file) {
					$list .= '<li>' . $skipped_file . '</li>';
				}
				$list .= '</ul>';
				$this->session->data['error_warning'] = $this->language->get('error_warning')  . $list; 
			}
			if (!empty($this->session->data['zipfiles'])) {
				$list .= $this->language->get('error_warning_zipfiles');
				$list .= '<ul>';
				foreach ($this->session->data['zipfiles'] as $zipfile) {
					$list .= '<li>' . $zipfile . '</li>';			
				}
				$list .= '</ul>';
				$this->session->data['error_warning'] = $list; 
			}
			
			if(file_exists('../system/logs/database.sql')) {
				unlink('../system/logs/database.sql');
			}
			if(file_exists('../system/logs/database_clone.sql')) {
				unlink('../system/logs/database_clone.sql');
			}
			unset($this->session->data['part']);
			unset($this->session->data['parts']);
			unset($this->session->data['filename']);
			unset($this->session->data['limit']);
			unset($this->session->data['timestamp']); 
			unset($this->session->data['zipfiles']);
			
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "backup`");
			
			
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
						
		}
		
	}

	public function combine_download() {
	
		$this->optimiseResources();
	
		if(isset($this->session->data['parts'])) {
			$parts = $this->session->data['parts'];
			$part = $this->session->data['part'];
			$timestamp = $this->session->data['timestamp'];
			$filename = $this->session->data['filename'];
			$archive = $filename . '_' . $timestamp .'.zip';
			$destination = '../backup_pro/' . $archive;
			
			if ($parts > 1) {
		
				$zipfiles = array();
				for($p = 1; $p <= $parts; $p++) {
					if ($p <=9) {
						$zipfiles[] = $filename . '_' . $timestamp . '_part_0' . trim($p) . '.zip';
					} else {
						$zipfiles[] = $filename . '_' . $timestamp . '_part_' . trim($p) . '.zip';
					}
				}

				$zip = new ZipArchive();
				
				if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
					return false;
				}
				
				foreach ($zipfiles as $zipfile) {
					$zip->addFile('../backup_pro/' . $zipfile, $zipfile);
				}
				
				$zip->close();
			}
				
			
			// tidy up temporary files and data
			if($parts > 1) {
				foreach ($zipfiles as $zipfile) {
					unlink('../backup_pro/' . $zipfile);
				}
			}
			
			if(file_exists('../system/logs/database.sql')) {
				unlink('../system/logs/database.sql');
			}
			if(file_exists('../system/logs/database_clone.sql')) {
				unlink('../system/logs/database_clone.sql');
			}
			unset($this->session->data['part']);
			unset($this->session->data['parts']);
			unset($this->session->data['filename']);
			unset($this->session->data['limit']);
			unset($this->session->data['timestamp']); 
			unset($this->session->data['zipfiles']);
			
			$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . "backup`");
			
			$this->session->data['download_file'] = $destination;
			$this->session->data['archive'] = $archive;
		}
		
		if(VERSION >= '2.2.0.0') {
			$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
		} else {
			$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
		}

	
	}

	public function download() {
			
		$this->optimiseResources();

		$destination = $this->session->data['download_file'];
		$archive = $this->session->data['archive'];
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"".$archive."\"");
		header("Content-Transfer-Encoding: binary");
		// make sure the file size isn't cached
		clearstatcache();
		header("Content-Length: ".filesize($destination));
		// output the file
		readfile($destination);
		
		unset($this->session->data['archive']);
		unset($this->session->data['download_file']);
		unlink($destination);
	
	}
	
	public function restore() {
	
		$this->optimiseResources();

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->user->hasPermission('modify', 'tool/backup_pro')) {
		
			if($this->request->files['import']['error'] == 4) {
				$this->language->load('tool/backup_pro');
				$this->session->data['error_warning'] = $this->language->get('error_nofile');
				if(VERSION >= '2.2.0.0') {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
				} else {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
				}
			}
			
			if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
			
				if ($this->request->files['import']['type'] == 'application/x-zip-compressed') {
					$sql_file = $this->unzip($this->request->files['import']['tmp_name']);
					
				} elseif (substr($this->request->files['import']['name'], -4) == '.sql' && $this->request->files['import']['type'] == 'application/octet-stream') {
					$sql_file = $this->request->files['import']['tmp_name'];				
				} else {
					$sql_file = false;
				}
			
				if ($sql_file) {
				
					$this->load->model('tool/backup_pro');
					
					$fp = fopen($sql_file, 'r');
					$sql = '';
					while (!feof($fp)) {
						$line = fgets($fp);
						
						if (strpos(trim($line), '--') === 0) {
							$this->model_tool_backup_pro->restore($sql);
							$sql = '';
						} else {
							$sql .= $line;
						}
					}
					fclose($fp);
					
					if($sql) {
						$this->model_tool_backup_pro->restore($sql);
					}
					unlink($sql_file);
					
					$this->language->load('tool/backup_pro');
					$this->session->data['success'] = $this->language->get('text_success_restore');
					
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
					}
				} else {
					$this->language->load('tool/backup_pro');
					$this->session->data['error_warning'] = $this->language->get('error_empty');
					if(VERSION >= '2.2.0.0') {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
					} else {
						$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
					}
				}
			} else {
				$this->language->load('tool/backup_pro');
				$this->session->data['error_warning'] = $this->language->get('error_empty');
				if(VERSION >= '2.2.0.0') {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
				} else {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
				}
			}
			
		} else {
			$this->language->load('tool/backup_pro');
			$this->session->data['error_warning'] = $this->language->get('error_permission');
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
		}
	
	}

	public function restore_clone() {
	
		$this->optimiseResources();
	
		if ($this->user->hasPermission('modify', 'tool/backup_pro')) {
			
			$content = file_get_contents('../system/logs/database_clone.sql');
			unlink('../system/logs/database_clone.sql');
					
			
			if ($content) {
			
				$this->load->model('tool/backup_pro');
				$this->model_tool_backup_pro->restore($content);
				
				$this->language->load('tool/backup_pro');
				$this->session->data['success'] = $this->language->get('text_success_restore');
				
				if(VERSION >= '2.2.0.0') {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
				} else {
					$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
				}
			} else {
				$this->language->load('tool/backup_pro');
				$this->error['warning'] = $this->language->get('error_empty');
			}
			
		} else {
			$this->language->load('tool/backup_pro');
			$this->session->data['error_warning'] = $this->language->get('error_permission');
			
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
		}
	
	}
	public function delete_clone() {
		if ($this->user->hasPermission('modify', 'tool/backup_pro')) {
			
			unlink('../system/logs/database_clone.sql');
			
			$this->language->load('tool/backup_pro');
			$this->session->data['success'] = $this->language->get('text_success_delete_clone');
			
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
								
		} else {
			$this->language->load('tool/backup_pro');
			$this->session->data['error_warning'] = $this->language->get('error_permission');
			
			if(VERSION >= '2.2.0.0') {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
			} else {
				$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
			}
		}
	
	}

	public function unzip($filename) {
	
		$this->optimiseResources();
	
		$zip = new ZipArchive;
		if ($zip->open($filename) === true) {
			for($i = 0; $i < $zip->numFiles; $i++) { 
				$entry = $zip->getNameIndex($i);
				if(preg_match('#\.(sql)$#i', $entry)) {

					$zip->extractTo('../system/logs/', array($zip->getNameIndex($i)));
					$sql_file = '../system/logs/' . $zip->getNameIndex($i);
					break;
				} 
			}  
			$zip->close();
			return $sql_file;
				 
		} else{
			return false;
		}	
	}


	public function formatSize($size) {
		if($size >= 1048576 * 1024) {
			$resize = number_format(($size / 1048576 / 1024), 1) . ' Gb';
		} elseif($size >= 1048576) {
			$resize = number_format(($size / 1048576), 1) . ' Mb';
		} elseif($size >= 1024) {
			$resize = number_format(($size / 1024), 1) . ' Kb';
		} else {
			$resize = $size . ' bytes';
		}
		return $resize;
	}
	
	public function deleteBackup() {
		if(isset($this->request->get['del']) && $this->user->hasPermission('modify', 'tool/backup_pro')) {
			if(is_file($this->request->get['del'])) {
				unlink($this->request->get['del']);
			}
		} 
		
		if(VERSION >= '2.2.0.0') {
			$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], true));			
		} else {
			$this->response->redirect($this->url->link('tool/backup_pro', 'token=' . $this->session->data['token'], 'SSL'));			
		}
		
	}
	
			
	public function convert_text($text) {
		return str_replace(' ', '-', strtolower($text));

	}
	
	public function isTarEnabled() {
	
		$result = function_exists('exec') &&
			!in_array('exec', array_map('trim',explode(', ', ini_get('disable_functions')))) &&
			!(strtolower(ini_get('safe_mode')) != 'off' && ini_get('safe_mode') != 0) && (strtolower(PHP_OS) == 'linux' || strtolower(PHP_OS) == 'freebsd');
		
		$tar = null;
		
		if ($result) {
			$tar = exec("command -v tar");
		}
		
		if(!empty($tar)) {
			return true;
		} else {
			return false;
		}

	}
	
	public function isZipEnabled() {
			if (class_exists('ZipArchive')) {
				return true;	
			} else {
				return false;
			}

	}

	public function isCurlEnabled(){
		return function_exists('curl_version');
	}

	public function pingCurl(){
		echo 'Curl Pinged';
	}

	private function optimiseResources(){
	
		error_reporting(E_ALL); 
		ini_set('display_errors', 1);
		
		// memory_limit
		$mem_limit = ini_get('memory_limit');
		if(substr($mem_limit, -1) == 'M') {
			$mem_limit = (substr($mem_limit, 0, -1) * 1024 * 1024);
		}
		$mem_limit = $mem_limit / 1024 / 1024;
		
		if($mem_limit < 256) {
			ini_set('memory_limit', '256M');
		}
		
		// max_execution_time
		ini_set('max_execution_time', 600);
	}

}
?>