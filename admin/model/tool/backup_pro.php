<?php
class ModelToolBackupPro extends Model {

	private $max_rows = 5000;
	
	public function restore($sql) {
		foreach (explode(";\n", $sql) as $sql) {
    		$sql = trim($sql);
    		
			if ($sql) {
      			$this->db->query($sql);
    		}
  		}
		
		$this->cache->delete('*');
	}
	
	public function getTables() {
		$table_data = array();
		
		$query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");
		
		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . DB_DATABASE])) {
					$table_data[] = $result['Tables_in_' . DB_DATABASE];
				}
			}
		}
		
		return $table_data;
	}
	
	public function backup($tables) {
		$fp = fopen('../system/logs/database.sql', 'w');
		fwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n\n");
		

		foreach ($tables as $table) {
			if (DB_PREFIX) {
				if (strpos($table, DB_PREFIX) === false) {
					$status = false;
				} else {
					$status = true;
				}
			} else {
				$status = true;
			}
			
			if ($status) {
				$output = 'DROP TABLE IF EXISTS `' . $table . '`;' . "\n";
				
				fwrite($fp, $output);
				
				$query = $this->db->query('SHOW CREATE TABLE `' . $table . '`');
				$result = $query->row;
				
				$output = $result['Create Table'].";\n\n";
				fwrite($fp, $output);
				
				$query = $this->db->query('SELECT COUNT(*) as nbr FROM `' . $table . '`');
				$result = $query->row;
				
				if($result['nbr'] > $this->max_rows) {
					$limit = $this->max_rows;
					$iterations = (int)($result['nbr']/$limit) + ($result['nbr'] % $limit ? 1 : 0);
					for($i=0; $i <= $iterations; $i++) {
						$start = $i * $limit;
						$query = $this->db->query("SELECT * FROM `" . $table . "` LIMIT " . $start . ", " . $limit);

						if ($query->num_rows) {
							$num_rows = $query->num_rows;
							
							
							$result = $query->row;
							$fields = '';
							
							foreach (array_keys($result) as $value) {
								$fields .= '`' . $value . '`, ';
							}
							
							$output = 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES' . "\n";
							fwrite($fp, $output);
							
							$ctr = 0;
							foreach ($query->rows as $result) {
								
								$values = '';
								
								foreach (array_values($result) as $value) {
									$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
									$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
									$value = str_replace('\\', '\\\\',	$value);
									$value = str_replace('\'', '\\\'',	$value);
									$value = str_replace('\\\n', '\n',	$value);
									$value = str_replace('\\\r', '\r',	$value);
									$value = str_replace('\\\t', '\t',	$value);			
									
									$values .= '\'' . $value . '\', ';
								}
								if ($ctr == $num_rows-1) {
									$output = '(' . preg_replace('/, $/', '', $values) . ');' . "\n";
									fwrite($fp, $output);
								} else {
									$output = '(' . preg_replace('/, $/', '', $values) . '),' . "\n";
									fwrite($fp, $output);
								}
								$ctr ++;
							}
						}
						if($i<$iterations) {
							fwrite($fp, "\n--\n");
						}
					}
				} else {

					$query = $this->db->query("SELECT * FROM `" . $table . "`");
					
					if ($query->num_rows) {
						$num_rows = $query->num_rows;
						
						
						$result = $query->row;
						$fields = '';
						
						foreach (array_keys($result) as $value) {
							$fields .= '`' . $value . '`, ';
						}
						
						$output = 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES' . "\n";
						fwrite($fp, $output);
						
						$ctr = 0;
						foreach ($query->rows as $result) {
							
							$values = '';
							
							foreach (array_values($result) as $value) {
								$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
								$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
								$value = str_replace('\\', '\\\\',	$value);
								$value = str_replace('\'', '\\\'',	$value);
								$value = str_replace('\\\n', '\n',	$value);
								$value = str_replace('\\\r', '\r',	$value);
								$value = str_replace('\\\t', '\t',	$value);			
								
								$values .= '\'' . $value . '\', ';
							}
							if ($ctr == $num_rows-1) {
								$output = '(' . preg_replace('/, $/', '', $values) . ');' . "\n";
								fwrite($fp, $output);
							} else {
								$output = '(' . preg_replace('/, $/', '', $values) . '),' . "\n";
								fwrite($fp, $output);
							}
							$ctr ++;
						}
					}
				}
				$output = "\n--\n"; 
				fwrite($fp, $output);
												
			}
		}
		fwrite($fp, "SET FOREIGN_KEY_CHECKS=1;\n");
		fclose($fp);	
	}
	
	public function reset_next_backup($new_date) {
		$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $new_date . "' WHERE `key` = 'backup_scheduled_date'");		
	}
	
	public function testEmail() {		
			$status = $this->config->get('backup_scheduled_status');
			$filename = $this->config->get('backup_scheduled_filename');
			$zip_data = $this->config->get('backup_scheduled_zip');
			$email = $this->config->get('backup_scheduled_email');
			$suffix = '-' . date('Y-m-d_H-i-s', time());
			$subject = $this->config->get('backup_scheduled_email_subject');
			$text = $this->config->get('backup_scheduled_email_message');
			$sql_name = $filename . $suffix . '.sql';
			$zip_filename = '../system/logs/' . $filename . $suffix . '.sql.zip';

			// Send Blank email to test that email system works.
			if ($email) {
				$config_mail = $this->getConfigMail();
				$text2 = "This is the first of 2 test emails. This email checks that emails are received by the specified address.\n\nThe second email will include the database backup. If this is not received, then there is a problem with the database backup being created or there is a problem with attaching and sending the file.";
				
				$mail = new Mail(); 
				$mail->protocol = $config_mail['protocol'];
				$mail->parameter = $config_mail['parameter'];
				$mail->hostname = $config_mail['smtp_hostname'];
				$mail->username = $config_mail['smtp_username'];
				$mail->password = $config_mail['smtp_password'];
				$mail->port = $config_mail['smtp_port'];
				$mail->timeout = $config_mail['smtp_timeout'];			
				$mail->setTo($email);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_email'));
				$mail->setSubject('Backup Pro Test email 1 of 2');
				$mail->setText($text2);
				$mail->send();

			}

			$tables = $this->getTables();
			
			$this->backup($tables);
			rename('../system/logs/database.sql', '../system/logs/' . $sql_name);
			if ($zip_data) {
			
				$zip = new ZipArchive();

				if ($zip->open($zip_filename, ZIPARCHIVE::CREATE)!==TRUE) {
				   exit("cannot open <$zip_filename>\n");
				}

				$zip->addFile('../system/logs/' . $sql_name, $sql_name);
				$zip->close();

			}
			
			// Send actual email with database backup to test backup works and is actually sent as an attachment
			if ($email) {
				$config_mail = $this->getConfigMail();
			
				$mail = new Mail(); 
				$mail->protocol = $config_mail['protocol'];
				$mail->parameter = $config_mail['parameter'];
				$mail->hostname = $config_mail['smtp_hostname'];
				$mail->username = $config_mail['smtp_username'];
				$mail->password = $config_mail['smtp_password'];
				$mail->port = $config_mail['smtp_port'];
				$mail->timeout = $config_mail['smtp_timeout'];			
				$mail->setTo($email);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_email'));
				$mail->setSubject($subject . ' - Backup Pro Test email 2 of 2');
				$mail->setText($text);
				$mail->addAttachment($zip_data ? $zip_filename : '../system/logs/' . $sql_name);
				$mail->send();

			}
			
			if (file_exists($zip_filename)) {
				unlink($zip_filename);
			}
			if (file_exists('../system/logs/' . $sql_name)) {
				unlink('../system/logs/' . $sql_name);
			}
			
	}
	
	private function getConfigMail() {
		
		$config_mail = $this->config->get('config_mail');
		if(!is_array($config_mail)) {
			$config_mail = array();
			$config_mail['protocol'] = $this->config->get('config_mail_protocol');
			$config_mail['parameter'] = $this->config->get('config_mail_parameter');
			$config_mail['smtp_hostname'] = $this->config->get('config_mail_smtp_hostname');
			$config_mail['smtp_username'] = $this->config->get('config_mail_smtp_username');
			$config_mail['smtp_password'] = $this->config->get('config_mail_smtp_password');
			$config_mail['smtp_port'] = $this->config->get('config_mail_smtp_port');
			$config_mail['smtp_timeout'] = $this->config->get('config_mail_smtp_timeout');
		}
		
		return $config_mail;
	}
	
}
?>