<?php
// text enclosed in asterisks {} will be replaced by actual value.  For example, {friend_name} will be replaced by John, or {referral_bellfor_discount} will be replaced by 10, and so on.

$_['heading_title'] = 'Referral Program';
$_['heading_referral_form'] = 'Sending Referral Form';
$_['heading_referral_table'] = 'Your Referrals';

$_['text_account'] = 'Account';
$_['text_referral'] = 'Referral Program';

/*
$_['html_info'] = 'When you refer a friend to the store, you will receive {sending_reward} {reward_type} and your friend will receive a coupon for {coupon_discount}.  When your friend redeems the coupon, you will receive an additional {coupon_redeemed_reward} {reward_type}.  Coupon conditions: <ul><li>Order total: {order_total}</li><li>Customer login: {customer_login}</li><li>Expire in: {expire} days</li><li>Uses per coupon: {uses_total}</li><li>Uses per customer: {uses_customer}</li></ul>'; //You can use html tags here
*/

$_['html_info'] = 'Wenn Sie einen Ihrer Freunde unseren Bellfor Shop weiterempfehlen, erhält Ihr Freund einen Gutschein über {coupon_discount} Nachlass. Wenn Ihr Freund diesen Gutschein einlöst, erhalten Sie einen Gutschein über {coupon_redeemed_reward}% Nachlass. Gerne können Sie unseren Onlineshop auch an mehrere Freunde weiterempfehlen.';
//You can use html tags here

$_['text_sent_success'] = 'Empfehlung gesendet!';
$_['html_login'] = 'Bitte <a href="index.php?route=account/login">login</a> um zu beginnen, Empfehlungen zu senden und Belohnungen zu erhalten.';
$_['text_reward_point'] = 'Belohnungspunkt';
$_['text_store_credit'] = 'Filialkredit';
$_['text_sending_limit'] = 'Sie können {referrals} Empfehlungen in {hours} Stunden senden.  Sie haben {remain} Empfehlungen bleiben.';

$_['button_send'] = 'Empfehlung senden';
$_['button_add'] = 'Freund hinzufügen';
$_['button_remove'] = 'Entfernen';

$_['column_date'] = 'Empfehlungsdatum';
$_['column_name'] = 'Name des Freundes';
$_['column_email'] = 'Freund E-Mail';

$_['entry_name'] = 'Name des Freundes:';
$_['entry_email'] = 'Freund E-Mail:';
$_['entry_message'] = 'Ihre Nachricht:';
$_['text_sample_email'] = 'Beispiel-E-Mail';

$_['error_name'] = 'Der Name muss zwischen 1 und 64 Zeichen lang sein!';
$_['error_email_format'] = 'E-Mail scheint nicht gültig zu sein!';
$_['error_email_existed'] = 'E-Mail bereits vorhanden!';
$_['error_sending_limit_reached'] = 'Sie haben das Sendelimit erreicht.  Bitte versuchen Sie es noch einmal {time}';

$_['coupon_name'] = 'Empfehlungsgutschein für {referee_name}';
$_['text_sending_referral_reward_desc'] = 'Belohnung für die Vermittlung {referee_name}';
$_['text_coupon_used_reward_desc'] = 'Belohnung für eingelösten Empfehlungsgutschein - Bestellung Ausweis: {order_id}, Schiedsrichter: {referee_name}, Schiedsrichter-E-Mail: {referee_email}';

// SUBJECT FOR FRIEND
$_['email_subject'] = 'Gutschein - Empfohlen von {referrer_name}';
// LETTER FOR FRIEND
$_['email_body'] = '
<p><a href="{store_link}" target="_blank"><img height="80" src="{store_logo}" alt="{store_name}" /></a></p>
<p>Hallo {referee_name},</p>
<p>herzlich Willkommen!<br />
Ihr Freund {referrer_name} hat Sie auf unseren Onlineshop <a href="{store_link}" target="_blank">www.bellfor.info</a> aufmerksam gemacht und wir senden Ihnen somit Ihren persönlichen Gutschein über {coupon_discount} zu. <br />Ihr Gutscheincode lautet <b>{coupon_code}</b>.</p>
<p>Dieser Gutschein ist bis zum <span style="color:#cc0000">{expire_date}</span> gültig.</p><br />
<p>Schöne Grüße<br />
Ihr Bellfor-Team</p>
';

$_['email_subject_reward_notification'] = 'Sie erhalten {reward} {reward_type} von {store_name}';
// LETTER FOR SENDER
$_['email_body_reward_notification'] = '
<p>Sehr geehrter {customer},</p>
<p>Sie erhalten {reward} {reward_type}.</p>
<p>Dank,</p>
<p>{store_name}</p>
';

// SUBJECT FOR CUSTOMER
$_['email_subject_customer'] = 'Sie erhalten Coupon von {store_name}';
// LETTER FOR CUSTOMER
$_['email_body_customer_coupon_notification'] = '
<p>Sehr geehrter {customer},</p>
<p>wir bedanken uns für die Empfehlung unseres Shops Ihrem Freund. Somit möchten wir Ihnen einen Gutschein über {coupon_discount} Rabatt schenken.</p>
<p>Der Gutschein-Code lautet <b>{coupon_code}</b> und er ist bis zum <span style="color:#cc0000">{expire_date}</span> gültig.</p>
<p>Schöne Grüße,<p>
<p>Ihr {store_name}-Team</p>
';
?>
