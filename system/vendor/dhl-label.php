<?php
$gmintraship = new GMIntraship();

$oID = $order_id;

$amount = 100;
$amount = number_format($amount,'2','.','');

$cod = false;
$cod_amount = $amount;

//Versanddatum = Heute
$shipmentdate=date('Y-m-d');

//Gewicht per Formular eingegeben
if(isset($data['weight'])) {
	$dhl_weight = preg_replace('/[^0-9.,]/','',$data['weight']);
	$dhl_weight = str_replace(',','.',$dhl_weight);
}

//Formatierung des Gewichtes fur Intraship
$dhl_weight = number_format($dhl_weight, 2,'.','');

//Intrship Webservice URL
$dhlwsdlurl = $gmintraship->getWSDLLocation();
$dhlintrashipurl = $gmintraship->getIntrashipPortalURL();

	$order_info['shipping_lastname'] = preg_replace('/(.*)\/\d+/', '$1', $order_info['shipping_lastname']);
	$order_info['shipping_firstname'] = preg_replace('/(.*)\/\d+/', '$1', $order_info['shipping_firstname']);
	
//DHL ProductCode und PartnerID herausssuchen
$productcode = $gmintraship->getProductCode($order_info['shipping_iso_code_2']);
$partnerid = $gmintraship->getPartnerID($order_info['shipping_iso_code_2']);	

$order_info['delivery_street_address'] = $order_info['shipping_address_1']." ".$order_info['shipping_address_2'];
	
	//Voreinstellungen fur den Debug-Modus

if($gmintraship->debug == true) {
	$ekp = '5000000000';
	$user = 'geschaeftskunden_api';
	$password = 'Dhl_ep_test1';
	$partnerid = '01';
	$cig_user = GMIntraship::DEVID;
	$cig_pwd = GMIntraship::DEVPWD;
}
else {
	$ekp = $gmintraship->ekp;
	$user = $gmintraship->user;
	$password = $gmintraship->password;
	$cig_user = GMIntraship::APPID;
	$cig_pwd = GMIntraship::APPToken;
}


//SSO fur Intraship Web-Oberflache

	$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => true,
		CURLOPT_FOLLOWLOCATION => (ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' || ini_get('safe_mode') == false)),
		CURLOPT_ENCODING       => "",
		CURLOPT_USERAGENT      => "Mozilla/4.0",
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_CONNECTTIMEOUT => 20,
		CURLOPT_TIMEOUT        => 20,
		CURLOPT_MAXREDIRS      => 1,
	);

	$url_options = array(
		'login' => $user,
		'pwd' => $password,
		'LANGUAGE' => 'DE',
	);

	$request = curl_init($dhlintrashipurl.'?' . http_build_query($url_options));
	curl_setopt_array( $request, $options );
	$content = curl_exec( $request );
	$err     = curl_errno( $request );
	$errmsg  = curl_error( $request );
	$header  = curl_getinfo( $request );
	curl_close( $request );

	//print_r($header);




//Stra?enname und Hausnummer trennen
if(preg_match('/(.*)\s+(\d+.*)$/i', trim($order_info['delivery_street_address']), $matches) == 1) {
	$receiver_streetname = $matches[1];
	$receiver_streetnumber = $matches[2];
}
else {
	$receiver_streetname = trim($order_info['delivery_street_address']);
	$receiver_streetnumber = '';
}


//Array fur Intraship-XML Bilden
$intraship = array(
	'Version' => array (
		'majorRelease' => '1',
		'minorRelease' => '0',
	),
	'ShipmentOrder' => array(
		'SequenceNumber' => '1',
		'Shipment' => array(
			'ShipmentDetails' => array(
				'ProductCode' => $productcode,
				'ShipmentDate' => $shipmentdate,
				'EKP' => $ekp,
				'Attendance' => array(
					'partnerID' => $partnerid
				),
				'CustomerReference' => $oID,
				'ShipmentItem' => array(
					'WeightInKG' => $dhl_weight,
					'PackageType' => 'PK'
				)
			),
		)
	)
);


//Nachnahme-Array bilden
if($cod==true) {
	$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['Service'] = array(
		'ServiceGroupOther' => array(
			'COD' => array(
				'CODAmount' => $cod_amount,
				'CODCurrency' => 'EUR'
			)
		)
	);

	//Bankdaten fur Nachnahme hinzufugen
	$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['BankData'] = array(
		'accountOwner' => $gmintraship->cod_account_holder,
		'accountNumber' => $gmintraship->cod_account_number,
		'bankCode' => $gmintraship->cod_bank_number,
		'bankName' => $gmintraship->cod_bank_name,
		'iban' => $gmintraship->cod_iban,
		'bic' => $gmintraship->cod_bic,
		'note' => '',
	);
};

//Regiopaket AT Zusatzdaten
if($productcode == 'RPN') {
	$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['Service']['ServiceGroupDHLPaket']['RegioPacket'] = 'AT';
};

//Versenderinformationen
$intraship['ShipmentOrder']['Shipment']['Shipper'] = array(
	'Company' => array(
		'Company' => array(
			'name1' => $gmintraship->shipper_name,
		)
	),
	'Address' => array(
		'streetName' => $gmintraship->shipper_street,
		'streetNumber' => $gmintraship->shipper_house,
		'Zip' => array(
			'germany' => $gmintraship->shipper_postcode
		),
		'city' => $gmintraship->shipper_city,
		'Origin' => array(
			'countryISOCode' => 'DE'
		)
	),
	'Communication' => array(
		'phone' => $gmintraship->shipper_phone,
		'contactPerson' => $gmintraship->shipper_contact,
		'email' => $gmintraship->shipper_email,
	)
);

//Empfangerinformationen
$intraship['ShipmentOrder']['Shipment']['Receiver'] = array(
	'Company' => array(
		'Company' => array(
			'name1' => $order_info['shipping_company'],
			'name2' => '', //Optional
		)
	),
	'Communication' => array(
		'phone' => $order_info['telephone'], // optional
		'email' => $order_info['email'],
		'contactPerson' => $order_info['shipping_firstname'].' '.$order_info['shipping_lastname']
	)
);

$is_packstation = false;
$is_postfiliale = false;
if(isset($postnumber)) {
	if(preg_match('/.*packstation.*/i', $receiver_streetname) == 1) {
		// Packstation-Adresse
		$is_packstation = true;
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Packstation'] = array(
			'PackstationNumber' => $receiver_streetnumber,
			'PostNumber' => $postnumber,
			'Zip' => $order_info['shipping_postcode'],
			'City' => $order_info['shipping_city'],
		);
	}
	if(preg_match('/.*postfiliale.*/i', $receiver_streetname) == 1) {
		$is_postfiliale = true;
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Address'] = array(
			'streetName' => 'Postfiliale',
			'streetNumber' => $receiver_streetnumber,
			'city' => $order_info['shipping_city'],
			'Origin' => array(
				'countryISOCode' => $order_info['shipping_iso_code_2']
			)
		);
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Company']['Company']['name2'] = $postnumber;
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Address']['Zip']['germany'] = $order_info['shipping_postcode'];
	}
}
else {
	// klassische Adresse
	$intraship['ShipmentOrder']['Shipment']['Receiver']['Address'] = array(
		'streetName' => $receiver_streetname,
		'streetNumber' => $receiver_streetnumber,
		'city' => $order_info['shipping_city'],
		'Origin' => array(
			'countryISOCode' => $order_info['shipping_iso_code_2']
		)
	);
	//PLZ landerspezifisch zuordnen
	if($order_info['shipping_iso_code_2']=='DE') {
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Address']['Zip']['germany'] = $order_info['shipping_postcode'];
	}
	elseif ($order_info['shipping_iso_code_2']=='GB') {
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Address']['Zip']['england'] = $order_info['shipping_postcode'];
	}
	else {
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Address']['Zip']['other'] = $order_info['shipping_postcode'];
	}
}


if(!empty($order_info['telephone'])) {
	$intraship['ShipmentOrder']['Shipment']['Receiver']['Communication']['phone'] = $order_info['telephone'];
}
else {
	$intraship['ShipmentOrder']['Shipment']['Receiver']['Communication']['phone'] = '+00-00000-000000';
}

if($gmintraship->send_announcement == true) {
	$intraship['ShipmentOrder']['Shipment']['Receiver']['Communication']['email'] = $order_info['email'];
}

//Wenn keine Firma dann Firmenname durch Vor- und Nachnamen ersetzen
if(!$order_info['shipping_company']) {
	$intraship['ShipmentOrder']['Shipment']['Receiver']['Company']['Company']['name1'] = $order_info['shipping_firstname'].' '.$order_info['shipping_lastname'];
	//Beim nationalen Versand kann dann die Kontaktperson entfallen
	if($productcode == 'EPN') {
		$intraship['ShipmentOrder']['Shipment']['Receiver']['Communication']['contactPerson'] = '';
	}
}

//E-Mail-Benachrichtigung
if(!empty($order_info['email']) && strlen($order_info['email']) <= 20) {
	$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['Notification']['RecipientName'] = substr($order_info['customers_name'], 0, 45);
	$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['Notification']['RecipientEmailAddress'] = substr($order_info['email'], 0, 20);
}

//internationaler Versand mit dummy Zolldaten

if($productcode == 'BPI') {

	$intraship['ShipmentOrder']['Shipment']['ExportDocument'] = array(

		'InvoiceDate' => $shipmentdate,

		'ExportType' => '0',

		'ExportTypeDescription' => 'Merchandise',

		'CommodityCode' => '00000000',

		'TermsOfTrade' => 'DDU',

		'Amount' => '1',

		'Description' => 'Customsform Order '.$oID,

		'CountryCodeOrigin' => 'DE',

		'CustomsValue' => $amount,

		'CustomsCurrency' => 'EUR',

		'ExportDocPosition' => array(

			'Description' => 'Item',

			'CountryCodeOrigin' => 'DE',

			'CommodityCode' => '00000000',

			'Amount' => '1',

			'NetWeightInKG' => $dhl_weight,

			'GrossWeightInKG' => $dhl_weight,

			'CustomsValue' => $amount,

			'CustomsCurrency' => 'EUR'

		)

	);

	//Service Premium fur internationalen Versand

	if($gmintraship->bpi_use_premium) {

		$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['Service']['ServiceGroupBusinessPackInternational']['Premium'] = 'Premium';

	}

	else {

		$intraship['ShipmentOrder']['Shipment']['ShipmentDetails']['Service']['ServiceGroupBusinessPackInternational']['Economy'] = 'Economy';

	}

}

//Ruckgabe als URL zum Versandaufkleber
$intraship['ShipmentOrder']['LabelResponseType'] = 'URL';

// Umgang mit Problemen mit Leitcodierung
$intraship['ShipmentOrder']['PRINTONLYIFCODEABLE'] = '0';

$cigcredentials = $gmintraship->getWebserviceCredentials();


//**********************************************************************************//

//Label anfordern oder loschen
//if(((isset($_GET['getlabel'])) || (isset($_GET['stornolabel']))) && ($_GET['error'] == '')) {
	//Optionsarray fur die SOAP-Anfrage
	$options = array(
		'location' => $gmintraship->getWebserviceEndpoint(),
		'authentication' => SOAP_AUTHENTICATION_BASIC,
		'login' => $cigcredentials->user,
        'password' =>  $cigcredentials->password,
        'HTTP_PASS' => $cigcredentials->password,
		'encoding' => 'UTF-8',
		'trace' => 1,
	);
	$soapClient = new SoapClient($dhlwsdlurl, $options);

	//Zugangsdaten in SOAP-Header
	$headers = array();
	$sh_param = array(
		'user' => $user,
		'signature' => $password,
		'type' => '0'
	);
	$headers[] = new SoapHeader('http://dhl.de/webservice/cisbase','Authentification', $sh_param);

	//SOAPClient
	$soapClient->__setSoapHeaders($headers);

	//SOAP Aktion festlegen
	$function = 'CreateShipmentDD';


	//SOAP Anfrage ausfuhren
	try {
		//header('Content-Type: text/plain'); die(print_r($intraship, true));
		$result = $soapClient->__soapCall($function, array($intraship));
		//Auf Fehlermeldung von Intraship prufen
		if(property_exists($result,'status')) {
			$statuscheck = $result->status;
		}
		else {
			$statuscheck = $result->Status;
		}
		//Fehlerausgabe zusammenstellen
		if($statuscheck->StatusCode != '0') {
			print_r($result, true);
			print "### ".date('c')." ###\nERROR: ".$errormsg."\n\n";
			print "WSDL: ".$dhlwsdlurl."\n";
			print_r($gmintraship->getWebserviceEndpoint());
			print_r($soapClient->__getLastRequest());
			print_r($soapClient->__getLastResponse());

		}
		else {
			if($function == 'CreateShipmentDD') {
				$codeable = true;
				if(is_array($result->CreationState->StatusMessage)) {
					foreach($result->CreationState->StatusMessage as $statusmessage) {
						if(strpos($statusmessage, '[NON_CODABLE]') !== false) {
							$codeable = false;
						}
					}
				}
				else {
					if(strpos((string)$result->CreationState->StatusMessage, '[NON_CODABLE]') !== false) {
						$codeable = false;
					}
				}
				if($codeable == false) {
					$_SESSION['intraship_warning_not_codeable'] = true;
				}
			}

			if($gmintraship->debug == true) {
				//print "\n### ".date('c')." ###\n\n";
				//print_r($soapClient->__getLastRequest());
				//print_r($soapClient->__getLastResponse());
			}
		}

	}
	catch(SoapFault $fault) {
		//Fehlermeldung schon bei der SOAP-Anfrage
		$_SESSION['intraship_error'] = $fault->getMessage();
		print $fault->getMessage();
		print "#### ".date('c')." ###\nERROR/SF: ".$errormsg."\n\n";
		print "WSDL: ".$dhlwsdlurl."\n";
		print "Endpoint: ".$gmintraship->getWebserviceEndpoint()."\n";
		print_r($soapClient->__getLastRequest());
		print_r($soapClient->__getLastResponse());
	}
	unset($soapClient);

	// Label erhalten

		//Versandinformationen in Datenbank schreibem
		//$gmintraship->storeTrackingNumber($oID, (string)$result->CreationState->ShipmentNumber->shipmentNumber);
		$dhl_tracking_no = (string)$result->CreationState->ShipmentNumber->shipmentNumber."|".$result->CreationState->Labelurl;
?>