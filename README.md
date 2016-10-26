# Synerise SDK for PHP

The Synerise PHP SDK is designed to be simple to develop with, allowing you to easily integrate SyneriseSDK software into your server application. For more info about Synerise visit the [Synerise Website](http://synerise.com)


###Installing the library

You can get the library using Composer by including the following in your project's composer.json requirements and running composer update:


```json
{
    "require": {
        "synerise/php-sdk": "2.1.0"
    }
}
```


Now you can start tracking evetns, clients, payment and transactions:

```php
<?php
// import dependencies
require 'vendor/autoload.php';

$snr = Synerise\SyneriseTracker::getInstance([
	'apiKey' => 'b43c7c2c-ee52-4051-afa8-073e9c9c5f84',
	'apiVersion' => '2.1.0',
	'allowFork' => true,
]);

$snr->client->customIdentify('1');

// Track an custom event
$snr->event->track('Custom event', array(
	'Product Name' => 'iPhone 6',
	'Product Category' => 'Smartphones'));

//Add product to favorite
$snr->transaction->addFavoriteProduct(
	[
		'$categories' => ['1', '2', '3', 'apple'],
		'$sku' => 'XYZ-XYZ-XYZ-XYZ-XYZ',
		'$finalUnitPrice' => 24.99,
		'$name' => 'Apple MacBook Pro 13',
		'$imageUrl' => 'https://example/image.jpg',
		'$url' => 'https://example.com/apple-macbook-pro-13',
		'$quantity' => 2
	]
);


// Add product to cart from category Women/Shoes/Boots
$snr->transaction->addProduct(
	[
		'$sku' => 'XYZ-XYZ-XYZ-XYZ-XYZ',
		'$categories' => ['1', '2', '3', 'apple'],
		'$finalUnitPrice' => 24.99,
		'$name' => 'Apple MacBook Pro 13',
		'$imageUrl' => 'https://example/image.jpg',
		'$url' => 'https://example.com/apple-macbook-pro-13',
	]);


// Remmove product to cart from category Women/Shoes/Boots
$snr->transaction->removeProduct(
	[
		'$categories' => ['1', '2', '3', 'apple'],
		'$sku' => 'XYZ-XYZ-XYZ-XYZ-XYZ',
		'$finalUnitPrice' => 24.99,
		'$name' => 'Apple MacBook Pro 13',
		'$imageUrl' => 'https://example/image.jpg',
		'$url' => 'https://example.com/apple-macbook-pro-13',
	]);


// Track charge of transaction
// Below are examples of fields in a way you should send them. Some fields with "$" mean that this field will be rendered in special way on transaction interface in Synerise. If You want some params to be rendered in this way sent them with "$". If you want to add other fields to transaction object feel free to do so.
$snr->transaction->charge([
	'$email' => 'john.smith@mail.com', //in case of one-time import of previous transactions this field must be sent, otherwise transaction will not match to user. In real time transaction this field is not obligatory only if you sent previously an login event to authorise user
	'$time' => 1474734574525,  //sentin UNIX timestamp format
	'$orderId' => '3DD33333333',
	'$orderStatus' => 'Waiting for payment',  // every further status change should be sent as transaction charge with the same order ID due to transaction status update
	'$source' => 'WEB_DESKTOP',  // Avaiable options: WEB_DESKTOP, WEB_MOBILE, MOBILE_APP, POS
	'$netAmount' => 100.00,
	'$taxAmount' => 23.00,
	'$discountAmount' => 20.00,
	'$totalAmount' => 103.00,  // if transaction is a return or cancel total amount should be sent as -103.00
	'$provisionAmount' => 2.00,
	'$revenue' => 1.00,
	'$discountCode' => 'WL2016',
	'$locationId' => '268',     // unique ID of location in your database
	'$locationName' => 'C.H. Bonarka CC',  
	'$currency' => 'PLN',
	'$deliveryType' => 'Collect on demand',  // every form of delivery can be sent here (ex. courier, post etc.)
	'$deliveryAdress' => 'streetname 1 / 19', //delivery adress structure depends on how you want to transfer it 
	'$deliveryStreet' => 'streetname',        //full streetname with block and flat number OR all those split into detailed fields
	'$deliveryBlock' => '21b',
	'$deliveryFlat' => '5c',
	'$deliveryFloor' => 1,
	'$deliveryCity' => 'Kraków',
	'$deliveryZipcode' => 30-539,
	'$deliveryTime' => 1474734574525, //sent in UNIX timestamp format
	'$invoiceType' => 'digital' // if client will not select invoice fill this field as 'null'
	'$products' => [
		[
			'$categories' => ['1', '2', '3', 'apple'],  
			'$name' => 'Apple MacBook Pro 13',
			'$sku' => 'XYZ-XYZ-XYZ-XYZ-XYZ',
			'$netUnitPrice' => 20.00,
			'$finalUnitPrice' => 26.66,
			'discountPrice' => 10.00,
			'$taxAmount' => 8.00,
			'$productType' => 'TPO',
			'$discountCode' => 'WL2016'
			'$imageUrl' => 'https://example/image.jpg',
			'$url' => 'https://example.com/apple-macbook-pro-13',
			'$quantity' => 2
		],
		[
			'$categories' => ['1', '2', '3', 'services'],    // every service should be sent as a product
			'$name' => 'Transport',
			'$sku' => 'ZYX-XYZ-XYZ-XYZ-XYZ',
			'$netUnitPrice' => 20.00,
			'$finalUnitPrice' => 26.66,
			'$discountPrice' => 10.00,
			'$taxAmount' => 8.00,
			'$productType' => 'null',
			'$discountCode' => 'WL2016'
			'$imageUrl' => 'https://example/image.jpg',
			'$url' => 'https://example.com/apple-macbook-pro-13',
			'$quantity' => 1
		]
	]
]);


// Setup client with custom identify
$snr->client->customIdentify('9876');

// Setup client with custom identify and pass client data
$snr->client->customIdentify('9876', array(
	'$email' => 'john.smith@mail.com',
	'$firstname' => 'John',
	'$lastname' => 'Smith',
	'$phone' => 123456789,
	'$age' => 33,
	'Client type' => 'Premium'
));

//Setup clinet without custom identify or update client
$snr->client->setData(
	[
		'$email' => 'john.smith@mail.com',
		'$firstname' => 'John',
		'$lastname' => 'Smith',
		'$phone' => 123456789,
		'$age' => 33,
		'Client type' => 'Premium'
	]
);

// Event log In
$snr->client->logIn();

// Event log out
$snr->client->logOut();


// Optional - clear all cache on Client
$snr->client->reset();



```

