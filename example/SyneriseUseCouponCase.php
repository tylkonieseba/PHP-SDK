<?php
require '../vendor/autoload.php';

$snr = Synerise\SyneriseCoupon::getInstance([
	'apiKey'=>'2A3C3B02-04BE-03A0-6E22-E7B91CA41479',
	'apiVersion'=>'2.1.0',
	'allowFork'=>false, //true,
]);

// dev - ssl
$snr->setDefaultOption('verify', false);

//Coupon can be used
$snr->getStatusCoupon('8360132766888')->canUse();


$snr->useCoupon('83601327266888');

