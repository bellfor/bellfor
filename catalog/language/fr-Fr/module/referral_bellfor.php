<?php
// text enclosed in asterisks {} will be replaced by actual value.  For example, {friend_name} will be replaced by John, or {referral_bellfor_discount} will be replaced by 10, and so on.

$_['heading_title'] = 'Programme de référence';
$_['heading_referral_form'] = 'Envoi du formulaire de recommandation';
$_['heading_referral_table'] = 'Vos références';

$_['text_account'] = 'Compte';
$_['text_referral'] = 'Programme de référence';

/*
$_['html_info'] = 'When you refer a friend to the store, you will receive {sending_reward} {reward_type} and your friend will receive a coupon for {coupon_discount}.  When your friend redeems the coupon, you will receive an additional {coupon_redeemed_reward} {reward_type}.';
*/

$_['html_info'] = 'Si vous recommandez notre boutique Bellfor à un ami, votre ami(e) recevra un coupon de réduction {coupon_discount}. Lorsque votre ami échange ce coupon, vous recevrez un coupon de {coupon_reemed_reward}% de réduction. Vous pouvez également recommander notre boutique en ligne à plusieurs amis.';
//You can use html tags here

$_['text_sent_success'] = 'Référence envoyée!';
$_['html_login'] = 'Veuillez vous <a href="index.php?route=account/login">connecter</a> pour commencer à envoyer des références et à gagner des récompenses.';
$_['text_reward_point'] = 'Point de récompense';
$_['text_store_credit'] = 'Crédit en magasin';
$_['text_sending_limit'] = 'Vous pouvez envoyer des {referrals} références en {hours} heures.  Vous avez encore des {remain} références.';

$_['button_send'] = 'Envoyer une recommandation';
$_['button_add'] = 'Ajouter un ami';
$_['button_remove'] = 'Enlever';

$_['column_date'] = 'Date de référence';
$_['column_name'] = 'Nom de l\'ami(e)';
$_['column_email'] = 'Courriel d\'un ami';

$_['entry_name'] = 'Nom de l\'ami(e):';
$_['entry_email'] = 'Courriel d\'un ami:';
$_['entry_message'] = 'Votre message:';
$_['text_sample_email'] = 'Exemple de courriel';

$_['error_name'] = 'Le nom doit comporter entre 1 et 64 caractères!';
$_['error_email_format'] = 'Le courriel ne semble pas être valide!';
$_['error_email_existed'] = 'Le courrier électronique existait déjà!';
$_['error_sending_limit_reached'] = 'Vous avez atteint la limite d\'envoi.  Veuillez réessayer autour de {time}';

$_['coupon_name'] = 'Coupon de recommandation pour {referee_name}';
$_['text_sending_referral_reward_desc'] = 'Récompense pour la référence {referee_name}';
$_['text_coupon_used_reward_desc'] = 'Récompense pour le coupon de recommandation échangé - ID de commande: {order_id}, référence: {referee_name}, référence e-mail: {referee_email}';

// SUBJECT FOR FRIEND
$_['email_subject'] = 'Coupon de magasin - Recommandé par {referrer_name}';
// LETTER FOR FRIEND
$_['email_body'] = '
<p><a href="{store_link}" target="_blank"><img height="80" src="{store_logo}" alt="{store_name}" /></a></p>
<p>Bonjour {referee_name},</p>
<p>bienvenue dans notre boutique!<br />
Votre ami {referrer_name} vous a invité dans notre boutique en ligne <a href="{store_link}" target="_blank">www.bellfor.info</a> et nous vous envoyons votre bon de réduction de {coupon_discount}. <br />Votre code promo est <b>{coupon_code}</b>.</p>
<p>Ce bon est valable jusqu\'au <span style="color:#cc0000">{expire_date}</span>.</p><br />
<p>Meilleures salutations<br />
Votre équipe de Bellfor</p>
';


$_['email_subject_reward_notification'] = 'Vous recevez {reward} {reward_type} depuis {store_name}';
// LETTER FOR SENDER
$_['email_body_reward_notification'] = '
<p>Chère {customer},</p>
<p>Vous recevez {reward} {reward_type}.</p>
<p>Merci,</p>
<p>{store_name}</p>
';

// SUBJECT FOR CUSTOMER
$_['email_subject_customer'] = 'Vous recevez un coupon de {store_name}';
// LETTER FOR CUSTOMER
$_['email_body_customer_coupon_notification'] = '
<p>Chère {customer},</p>
<p>Merci de recommander notre boutique à votre ami. Nous aimerions donc vous offrir un bon de {coupon_discount} réduction.</p>
<p>Le code coupon est <b>{coupon_code}</b> et il est valable jusqu\'au <span style="color:#cc0000">{expire_date}</span>.</p>
<p>Jolies salutations,<p>
<p>Votre {store_name}-Équipe</p>
';
?>
