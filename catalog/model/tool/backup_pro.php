<?php
class ModelToolBackupPro extends Model {

	private $max_rows = 5000;
	
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
		$fp = fopen('system/logs/database.sql', 'w');
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
	
}
?>