<?php
require '../vendor/autoload.php';

$snr = Synerise\SyneriseNewsletter::getInstance([
	'apiKey'=>'2A3C3B02-04BE-03A0-6E22-E7B91CA41479',
	'apiVersion'=>'2.1.0',
	'allowFork'=>false, //true,
]);


$snr->subscribe('example@example.com', ['sex' => 'm']);

