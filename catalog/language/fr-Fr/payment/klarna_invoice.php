<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

// Text
$_['text_title']				= 'Facture de Klarna - Payer dans les 14 jours';
$_['text_terms_fee']			= '<span id="klarna_invoice_toc"></span> (+%s)<script type="text/javascript">var terms = new Klarna.Terms.Invoice({el: \'klarna_invoice_toc\', eid: \'%s\', country: \'%s\', charge: %s});</script>';
$_['text_terms_no_fee']			= '<span id="klarna_invoice_toc"></span><script type="text/javascript">var terms = new Klarna.Terms.Invoice({el: \'klarna_invoice_toc\', eid: \'%s\', country: \'%s\'});</script>';
$_['text_additional']			= 'Facture de Klarna a besoin de quelques informations supplémentaires avant de pouvoir traiter votre commande.';
$_['text_male']					= 'Mâle';
$_['text_female']				= 'Féminin';
$_['text_year']					= 'Année';
$_['text_month']				= 'Mois';
$_['text_day']					= 'Jour';
$_['text_comment']				= 'Numéro de facture de Klarna: %s. ' . "\n" . '%s/%s: %.4f';

// Entry
$_['entry_gender']				= 'Sexe';
$_['entry_pno']					= 'Numéro personnel';
$_['entry_dob']					= 'Date de naissance';
$_['entry_phone_no']			= 'Numéro de téléphone';
$_['entry_street']				= 'Rue';
$_['entry_house_no']			= 'Numéro de maison';
$_['entry_house_ext']			= 'Maison Ext.';
$_['entry_company']				= 'Numéro d\'immatriculation de la société';

// Help
$_['help_pno']					= 'Veuillez entrer votre numéro de sécurité sociale ici.';
$_['help_phone_no']				= 'Veuillez entrer votre numéro de téléphone.';
$_['help_street']				= 'Veuillez noter que la livraison ne peut avoir lieu qu\'à l\'adresse enregistrée si vous payez avec Klarna.';
$_['help_house_no']				= 'Veuillez entrer votre numéro de maison.';
$_['help_house_ext']			= 'Veuillez soumettre l\'extension de votre maison ici. Par exemple, A, B, C, Rouge, Bleu, etc.';
$_['help_company']				= 'Veuillez entrer le numéro d\'enregistrement de votre société';

// Error
$_['error_deu_terms']			= 'Vous devez accepter la politique de confidentialité de Klarna (Datenschutz)';
$_['error_address_match']		= 'Les adresses de facturation et d\'expédition doivent correspondre si vous voulez utiliser le facture de Klarna';
$_['error_network']				= 'Une erreur s\'est produite lors de la connexion à Klarna. Veuillez réessayer plus tard.';