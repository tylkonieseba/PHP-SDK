# Synerise SDK for PHP

The Synerise PHP SDK is designed to be simple to develop with, allowing you to easily integrate SyneriseSDK software into your server application. For more info about Synerise visit the [Synerise Website](http://synerise.com)


###Installing the library

You can get the library using Composer by including the following in your project's composer.json requirements and running composer update:


```json
{
    "require": {
        "synerise/php-sdk": "2.0.1"
    }
}
```


Now you can start tracking evetns, clients, payment and transactions:

```php
<?php
// import dependencies
require 'vendor/autoload.php';

$snr = Synerise\SyneriseTracker::getInstance([
	'apiKey'=>'b43c7c2c-ee52-4051-afa8-073e9c9c5f84',
	'apiVersion'=>'2.1.0',
	'allowFork'=>true,
	]);

$snr->client->customIdentify('1');

// Track an custom event
$snr->event->track("Custom event", array(
	"Product Name"=>"iPhone 6",
    "Product Category"=>"Smartphones"));

//Add product to favorite
$snr->transaction->addFavoriteProduct(
        [
        "$categories": ["1", "2", "3", "czółenka"],
        "$sku": "DCF756-H25-4300-5300-0",
        "$finalUnitPrice": 24.99,
        "$name": "Czytelna nazwa produktu - może pojawić się na streamie",
        "$imageUrl": "Adres obrazka do wyświetlenia na streamie",
        "$url": "Adres strony z widokiem produktu - na streamie zostanie podlinkowany",
        "$quantity": 2
        ]
    );



// Add product to cart from category Women/Shoes/Boots
$snr->transaction->addProduct(
	[
	"$categories": ["1", "2", "3", "czółenka"],
    "$sku": "DCF756-H25-4300-5300-0",
    "$finalUnitPrice": 24.99,
    "$name": "Czytelna nazwa produktu - może pojawić się na streamie",
    "$imageUrl": "Adres obrazka do wyświetlenia na streamie",
    "$url": "Adres strony z widokiem produktu - na streamie zostanie podlinkowany",
	]);


// Remmove product to cart from category Women/Shoes/Boots
$snr->transaction->removeProduct(
	[
	"$categories": ["1", "2", "3", "czółenka"],
    "$sku": "DCF756-H25-4300-5300-0",
    "$finalUnitPrice": 24.99,
    "$name": "Czytelna nazwa produktu - może pojawić się na streamie",
    "$imageUrl": "Adres obrazka do wyświetlenia na streamie",
    "$url": "Adres strony z widokiem produktu - na streamie zostanie podlinkowany",
	]);


// Track charge
$snr->transaction->charge(array(
    "$source":"POS",
    "$totalAmount":120.54,
    "$discountAmount:22.33,
    "$revenue": 3.44,
    "$discountCode":"WL2016",
    "$locationId":"C.H. Bonarka CC",
    "$currency":"PLN",
    "$orderId":"3DD33333333",
	"products":  [
		{
		"$categories": ["1", "2", "3", "czółenka"],
		"$sku": "DCF756-H25-4300-5300-0",
		"$finalUnitPrice": 24.99,
		"$name": "Czytelna nazwa produktu - może pojawić się na streamie",
		"$imageUrl": "Adres obrazka do wyświetlenia na streamie",
		"$url": "Adres strony z widokiem produktu - na streamie zostanie podlinkowany",
		"$quantity": 2
		},
		{
        "$categories": ["1", "2", "3", "czółenka"],
        "$sku": "YHW2-125-9900-5300-0",
        "$finalUnitPrice": 84.99,
        "$name": "Czytelna nazwa produktu - może pojawić się na streamie",
        "$imageUrl": "Adres obrazka do wyświetlenia na streamie",
        "$url": "Adres strony z widokiem produktu - na streamie zostanie podlinkowany",
        "$quantity": 2
        }
    ]
	));


// Setup clinet with cutom itentify
$snr->client->customIdentify('9876');

// Setup clinet with cutom itentify and pass client data
$snr->client->customIdentify('9876',array(
	'$email'=>"john.smith@mail.com",
	'$firstname'=>"John",
    '$secondname'=>"Smith",
    '$age'=>33,
    'Client type'=>"Premium"
));

//add or update user
$this->snr->client->setData(
[
    '$email'=>"john.smith@mail.com",
 	'$firstname'=>"John",
    '$secondname'=>"Smith",
    '$age'=>33
 ]
);

// Log In
$this->snr->client->logIn();

// Log Out
$this->snr->client->logOut();


// Optional - clear all cache on Client
$snr->client->reset();

```

