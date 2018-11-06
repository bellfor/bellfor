<?php
class ControllerToolBackupPro extends Controller {
    private $error = array();

    public function index() {
        if ($this->config->get('backup_scheduled_status')) {
            $filename = $this->config->get('backup_scheduled_filename');
            $zip_data = $this->config->get('backup_scheduled_zip');
            $email = $this->config->get('backup_scheduled_email');
            $suffix = '-' . date('Y-m-d_H-i-s', time());
            $subject = $this->config->get('backup_scheduled_email_subject');
            $text = $this->config->get('backup_scheduled_email_message');
            $sql_name = $filename . $suffix . '.sql';
            $zip_filename = 'system/logs/' . $filename . $suffix . '.sql.zip';


            $this->load->model('tool/backup_pro');
            $tables = $this->model_tool_backup_pro->getTables();

            $this->model_tool_backup_pro->backup($tables);
            rename('system/logs/database.sql', 'system/logs/' . $sql_name);
            if ($zip_data) {

                $zip = new ZipArchive();

                if ($zip->open($zip_filename, ZIPARCHIVE::CREATE)!==TRUE) {
                    exit("cannot open <$zip_filename>\n");
                }
                $zip->addFile('system/logs/' . $sql_name, $sql_name);
                $zip->close();

            }

//            $logs_dir = scandir('system/logs/');
//            foreach ($logs_dir as $file_name){
//                $only_name = explode('.', $file_name);
//                $temp_name = $filename . $suffix;
//                if ($only_name[0] == $temp_name && $file_name != $sql_name){
//                    unset($only_name[count($only_name)-1]);
//                    $result = implode('.', $only_name);
//                    rename('system/logs/' .$file_name, 'system/logs/' . $result);
//                }
//            }

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
                $mail->setSubject($subject);
                $mail->setText($text);
                $mail->addAttachment($zip_data ? $zip_filename : 'system/logs/' . $sql_name);
                $mail->send();

            }

            if (file_exists($zip_filename)) {
                unlink($zip_filename);
            }
            if (file_exists('system/logs/' . $sql_name)) {
                unlink('system/logs/' . $sql_name);
            }

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