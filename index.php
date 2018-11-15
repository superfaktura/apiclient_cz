<?php
require_once('SFAPIclient/SFAPIclient.php');  // inc. SuperFaktúra PHP-API
$login_email = '';  // moja.superfaktura.sk login email
$api_token = '';  // token from my account
$sf_api = new SFAPIclientCZ($login_email, $api_token);  // create SF PHP-API object

// set client for new invoice
$sf_api->setClient(array(
'name' => 'MyClient',
'address' => 'MyClient address 1',
'zip' => 12345,
'city' => 'MyClientCity'
));
// set invoice attributes
$sf_api->setInvoice(array(
	'name' => 'MyInvoice',
	'bank_accounts' => array(
		array(
			'bank_name' => 'FIO',
			'account' => '0025164895',
			'bank_code' => '1234',
			'iban' => 'SK0000000000000000',
			'swift' => '12345',
		)
	),
));
// add new invoice item
$sf_api->addItem(array(
'name' => 'MyInvoiceItem',
'description' => 'Inv. item no. 1',
'unit_price' => 10,
'tax' => 20
));

// save invoice in SuperFaktura
$json_response = $sf_api->save();

// TODO: handle exceptions
//var_dump($json_response);
