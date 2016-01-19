# Synerise SDK for PHP

The Synerise PHP SDK is designed to be simple to develop with, allowing you to easily integrate SyneriseSDK software into your server application. For more info about Synerise visit the [Synerise Website](http://synerise.com)

### System requirements

* PHP 5.4 or greater
* Composer (optional)

### Installing the Synerise SDK for PHP

There are two methods to install the Synerise SDK for PHP. The recommended installation method is by using Composer (https://getcomposer.org/). If are unable to use Composer for your project, you can still install the SDK manually by downloading the source files and including the autoloader.

### Installing with Composer (recommended)

Composer is the recommended way to install the Synerise SDK for PHP. Simply add the following "require" entry to the composer.json file in the root of your project.

```json
{
    "require": {
        "synerise/php-sdk": "2.0.1"
    }
}
```
Then run composer install from the command line, and composer will download the latest version of the SDK and put it in the /vendor/ directory.

Make sure to include the Composer autoloader at the top of your script.

```php
require_once __DIR__ . '/vendor/autoload.php';
```

### Configuration and setup

This assumes you have already created and configured a business profile in Synerise.
Before we can send requests to the Synerise API, we need to load our app configuration into service.

```php
<?php
// import dependencies
require 'vendor/autoload.php';

$snr = Synerise\SyneriseTracker::getInstance([
	'apiKey'=>'b43c7c2c-ee52-4051-afa8-073e9c9c5f84',
	'apiVersion'=>'2.0.1',
	'allowFork'=>true,
	]);
```
You'll need to replace the `apiKey` with your Synersie api key which can be obtained from the settings tab.

### Track events

Using SyneriseTracker is the way how you tell Synerise about which actions your users are performing inside your app. 

```php
// Track an event
$snr->event->track("Add to favourites 1", array(
	"Product Name"=>"iPhone 6",
    "Product Category"=>"Smartphones"));
```

### Identify Users
Synerise SDK for PHP has own build in manager, which take care about unique user identity. You can provide tracker with custom client data. Basic call of this might look like:

```php
// Setup clinet with cutom itentify and pass client data
$snr->client->customIdentify('{your-internal-id}',array(
	'$email'=>"john.smith@mail.com",
	'$firstname'=>"John",
    '$secondname'=>"Smith",
    '$age'=>33,
    'Client type'=>"Premium"
));
```
That mean you can overwrite user profile with parameters send by tracker. Of course you can also add more Client data but they would be dipatch as custom fields tide to your Customer profile.

If you want using your own identity for user application call `customIdentify`. It might look like:

```php
// Setup clinet with cutom itentify
$snr->client->customIdentify('9876');
```

After that all events generated in application will be signed in this identity.

### Ecommerce Events

The ecommerce category includes the following events:
* Add Product
* Remove Product
* Charge 

```php
// Add product to cart from category Women/Shoes/Boots
$snr->product->addProduct(
	[
	'$category'=>"She/Shoes/Boots",
	'$sku'=>"ABCD44DFK-W21",
	'$producer'=>"Mai Piu Senza",
	'$name'=>"High heeled boots - nero",
	'$regularPrice'=>129.99, 
	'$discountPrice'=>99.99, // If product has been sold in discount price
	'$currency'=>"EUR", 
	'$quantity'=>1,
	'$discountCode'=>"WL2016",
	'$location'=>"eCommerce",
	'Size' => 39,
	'Color' => "Black",
	]);


// Remmove product to cart from category Women/Shoes/Boots
$snr->product->removeProduct(
	[
	'$category'=>"She/Shoes/Boots",
	'$sku'=>"ABCD44DFK-W21",
	'$producer'=>"Mai Piu Senza",
	'$name'=>"High heeled boots - nero",
	'$regularPrice'=>129.99, 
	'$discountPrice'=>99.99, // If product has been sold in discount price
	'$currency'=>"EUR", 
	'$quantity'=>1,
	'$discountCode'=>"WL2016",
	'$location'=>"eCommerce",
	'Size' => 39,
	'Color' => "Black",
	]);


// // Track charge
$snr->transaction->charge(array(
	'$orderId'=>"UK12345678",
	'$totalAmount'=>347.39,
	'$discountAmount'=>347.39,
	'$revenue'=>10.44,
	'$currency'=>"EUR",
	'$paymentType'=>"PayPal",
	'$deliveryType'=>"UPS",
	'$productsQuantity'=>2,
	'$tax'=>23,
	'products' => [
		[
			'$category'=>"She/Shoes/Boots",
			'$sku'=>"ABCD44DFK-W21",
			'$producer'=>"Mai Piu Senza",
			'$name'=>"High heeled boots - nero",
			'$regularPrice'=>129.99, 
			'$discountPrice'=>99.99, // If product has been sold in discount price
			'$currency'=>"EUR",
			'$quantity'=>1,
			'$discountCode'=>"WL2016",
			'$location'=>"eCommerce",
			'Size' => 39,
			'Color' => "Black",
		],[
			'$category'=>"She/Shoes/Boots",
			'$sku'=>"ABCD44DFK-W21",
			'$producer'=>"Mai Piu Senza",
			'$name'=>"High heeled boots - nero",
			'$regularPrice'=>129.99, 
			'$discountPrice'=>99.99, // If product has been sold in discount price
			'$currency'=>"EUR",
			'$quantity'=>1,
			'$discountCode'=>"WL2016",
			'$location'=>"eCommerce",
			'Size' => 39,
			'Color' => "Black",
		],
	],
	'Order region'=>"Region #1",
	'Order city'=>"Krakow"));
```

```php
// Setup clinet with cutom itentify
$snr->client->customIdentify('9876');

// Update clinet
$snr->client->update(array(
	'$email'=>"john.smith@mail.com",
	'$firstname'=>"John",
    '$secondname'=>"Smith",
    '$age'=>33,
    'Client type'=>"Premium"
));
```

```php
// Optional - clear all cache on Client
$snr->client->reset();
```

