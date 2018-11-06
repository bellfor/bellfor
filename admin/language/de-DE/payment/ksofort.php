<?php
// Heading
$_['heading_title']					= 'Sofort.com By Karley';

// Text
$_['text_ksofort']					= '<a href="https://www.sofort.com/" target="_blank"><img src="view/image/payment/logo-sofort-ag.png" alt="Sofort.com" title="Sofort.com" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_payment']					= 'Zahlung';
$_['text_success']					= 'Erfolgreich: Sie haben das Sofort.com Modul bearbeitet!';


// Entry
$_['entry_total']					= 'Summe:';
$_['entry_order_status']			= 'Auftragsstatus:';
$_['entry_order_status_canceled']	= 'Auftragsstatus abbruch:';
$_['entry_geo_zone']				= 'Geo Zone:';
$_['entry_status']					= 'Status:';
$_['entry_sort_order']				= 'Reihenfolge:';
$_['entry_configkey']				= 'Configuration-Key:';
$_['entry_currency']				= 'Währung:';

// Help
$_['help_total']					= 'Mindestgesammtsumme im Warenkorb um diese Zahlarzt nutzen zu können.';
$_['help_configkey']				= 'Dieser wird ihnen nach dem erstellen eines \'SOFORT-Gateway-Projekts\' zu geschickt.<br>Er besteht aus: <br>CustomerNr:Project-ID:API-Key<br>(12345:123456:edc788a4[..]).';
$_['help_status_canceled']			= 'Dieser Status wird angezeigt, wenn ein Kunde die bezahlung abbricht.';
$_['help_currency']					= 'Diese Währung wird beim bezahlen an Sofort übergeben - Die Kosten werden auf die gewählte Währung umgerechnet.';
$_['help_currency_bankaccount']			= 'Die gewählte Währung, muss der Währung ihres Kontos bei Sofort.com enstsprechen.';

// Error
$_['error_permission']				= 'Warnung: Sie haben nicht die nötigen Rechte um das Sofort.com Modul zu bearbeiten!';
$_['error_sofort_currency']			= 'Sofort.com unterstützt nur Währungen mit folgenden ISO 4217 codes : EUR,GBP,CHF,PLN,HUF,CZK .<br><b>- Bitte ändern Sie ihr Währung oder Deaktivieren Sie dieses Modul(System -> Einstellung -> Lokales -> Währung)</b>';