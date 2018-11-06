<?php
// Heading
$_['heading_title']    			= 'Backup Pro';
	
//Tab
$_['tab_backup']      			= 'Резервная копия';
$_['tab_backup_scheduled']  	= 'Планировщик бекапов';
$_['tab_restore']    	  		= 'Восстановление';
$_['tab_info']      			= 'Дополнительная информация';
	
// Text
$_['text_edit']      			= 'Панель управления Backup Pro';
$_['text_yes']      			= 'Да';
$_['text_no']      				= 'Нет';
$_['text_enabled']      		= 'Включено';
$_['text_disabled']      		= 'Отключено';
$_['text_backup']      			= 'Скачать бекап';
$_['text_backup_filename']      = 'backup';
$_['text_backup_settings']      = '<h1 style="color: #ff8000">Настройки бекапов:</h1>';
$_['text_backup1']      		= '<h1 style="color: #ff8000">Резервная копия</h1>';
$_['text_backup2']      		= '<h1 style="color: #ff8000">Планировщик бекапов</h1>';
$_['text_restore']      		= '<h1 style="color: #ff8000">Восстановление</h1>';
$_['text_success']     			= 'Успешно: Настройки планировщика бекапов сохранено!';
$_['text_success_backup']     			= 'Успешно: Ваша резервная копия в настоящее время создается в фоновом режиме и будет сохранена в папке <strong>backup_pro/</strong>.<br /><br />Этот процесс может занять до часа или более, если существует значительное количество файлов, поэтому, пожалуйста, не пытайтесь скачать бекап до того, как процесс завершиться!';
$_['text_success_backup_ready'] = 'Успешно: Ваша резервная копия готова к загрузке по FTP из папки: <strong>system/logs</strong>';
$_['text_success_restore']     	= 'Успешно: Вы успешно восстановили свою базу данных!';
$_['text_success_delete_clone']	= 'Успешно: Вы успешно удалили клон базы данных!';
$_['text_instructions']   		= 'Используйте этот раздел, чтобы настроить автоматическую и регулярную резервную копию базы данных. Резервная копия будет отправляться вам по электронной почте.';
$_['text_backup_scheduled_filename']    = 'db-backup';
$_['text_backup_email_subject']     	= 'Бекап базы данных';
$_['text_backup_email_message']     	= 'Это бекап базы данных';
$_['text_further_information']      	= '<h1 style="color: #ff8000">Инстркуция:</h1>';
$_['text_further_information2']   		= ' ';
$_['text_download_ready']   	= 'Ваш бекап готовый, можно скачивать. Нажмите на кнопку <strong>Продолжить</strong>.'; 
$_['text_wait']      			= '<img src="view/image/loading.gif" alt="preparing backup . . ." /> Подготовка резервной копии - подождите. <br />Пожалуйста, не обновляйте страницу, пока процесс не будет завершен.';
$_['text_restore_wait']      	= '<img src="view/image/loading.gif" alt="restoring backup . . ." /> Восстановление из копии - подождите. <br />Пожалуйста, не обновляйте страницу, пока процесс не будет завершен.';
$_['text_no_backups']      		= 'Нет доступных резервных копий.';
$_['text_check_email']      	= 'Тестовое сообщение о бекапе было отправлено на указанный электронный адрес.';
	
// Entry
$_['entry_restore']    			= 'Восстановить сайт из бекапа:';
$_['entry_backup']     			= 'Выберите таблицы базы данных:';
$_['entry_backup_filename']     = 'Название файла бекапа:';
$_['entry_backup_zip']     		= 'Бекап в Zip-архиве (рекоменд.):';
$_['entry_backup_what']     	= 'Тип бекапа:';
$_['entry_backup_limit']     	= 'Лимит архива Zip:';
$_['entry_available_backups']  	= 'Доступные бекапы:';
$_['entry_backup_status']     	= 'Автоматический бекап:';
$_['entry_backup_email']     	= 'Email для получения:';
$_['entry_backup_email_subject']     	= 'Тема письма:';
$_['entry_backup_email_message']     	= 'Текст письма:';
$_['entry_backup_email_status'] = 'Бекап на Email:';
$_['entry_backup_save_to_server']     	= 'Сохранить бекап на сервере:';
$_['entry_backup_no_of_backups']     	= 'Сколько бекапов хранить:';
$_['entry_backup_cron']     	= 'Бекап по Cron:';
$_['entry_backup_cron_command'] = 'Команда Cron:<br /><span class="help">Используйте эту команду на сервере.</span>';
$_['entry_backup_frequency']    = 'Частота резервирования:';
$_['entry_clone']     			= 'Восстановить из клонированного бекапа:';
	
// Help
$_['help_backup_limit']     	= 'If you are getting problems with Error 500, timeouts, or exceeding maximum memory, try reducing the maximum size of each zip. This will mean that your backup will consist of 2 or more zip files each of which will also need to be unzipped when restoring your data.';
$_['help_backup_cron']     		= 'Scheduled backups can either be triggered by a Cron Job (recommended) or by visitors to your store (admin or customers).<br /><br />You will need to set up a Cron Job separately through your server\'s cPanel using the command shown below if you select Yes here.<br /><br />If you are not familiar with setting up Cron Jobs, you should select No.';
$_['help_backup_frequency']     = 'If you set up a Cron Job, this field will be ignored.';
$_['help_clone']     			= 'Backup Pro has detected a database backup that seems to have been restored from a Whole Store backup. <br /><br />Click the <strong>No Thanks</strong> button if you would like to delete this file.';
$_['help_restore']    			= 'You can only restore your database here. This should either be a .sql file or a .zip file that contains a .sql file.<br /><br />If you would like to restore your themes and images or a whole store - see the <strong>Additional Information</strong> tab.';
$_['help_available_backups']    = 'Here is a list of available backups. They can be downloaded by clicking the filename or via ftp from the folder <strong>backup_pro/</strong>.';
	
// Button
$_['button_save']     			= 'Сохранить настройки';
$_['button_no']     			= 'Нет, спасибо';
$_['button_continue']     		= 'Продолжить';
$_['button_test_email']     	= 'Тест Email';
$_['button_backup']				= 'Создать бекап';
$_['button_restore']			= 'Восстановить из бекапа';
	
// Error
$_['error_permission'] 			= 'Внимание: У вас нет доступа к управлению модулем!';
$_['error_backup']     			= 'Внимание: Вы должны выбрать, по крайней мере, одну таблицу для резервного копирования!';
$_['error_empty']      			= 'Внимание: Загруженный файл был пуст!';
$_['error_nofile']      		= 'Внимание: Вы должны выбрать файл для загрузки!';
$_['error_warning']    			= '<strong>Внимание: Следующие файлы не были читаемыми и не были включены в резервную копию!</strong>';
$_['error_warning_zipfiles']    = '<strong>Внимание: Zip архивы не включаються в резервные копии. Следующий файлы, были исключены:</strong>';
?>