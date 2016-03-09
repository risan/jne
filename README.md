# JNE HTTP Client

[![Build Status](https://travis-ci.org/risan/jne.svg?branch=master)](https://travis-ci.org/risan/jne)
[![HHVM Status](http://hhvm.h4cc.de/badge/risan/jne.svg?style=flat)](http://hhvm.h4cc.de/package/risan/jne)
[![StyleCI](https://styleci.io/repos/16021517/shield?style=flat)](https://styleci.io/repos/16021517)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/risan/jne/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/risan/jne/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/risan/jne/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/risan/jne/?branch=master)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/8976da0e-8a90-4a6b-a839-ff02e1ef680d.svg)](https://insight.sensiolabs.com/projects/8976da0e-8a90-4a6b-a839-ff02e1ef680d)
[![Latest Stable Version](https://poser.pugx.org/risan/jne/v/stable)](https://packagist.org/packages/risan/jne)
[![License](https://poser.pugx.org/risan/jne/license)](https://packagist.org/packages/risan/jne)

PHP HTTP client library for communicating with [JNE](http://www.jne.co.id/) website. This library can be used to retrieve JNE's delivery tariff and all available delivery locations.

## Table of Contents

* [Dependencies](#dependencies)
* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Search for Origin](#search-for-origin)
* [Search for Destination](#search-for-destination)
* [Get Delivery Options](#get-delivery-options)
  * [Find or Create Origin Location](#find-or-create-origin-location)
  * [Find or Create Destination Location](#find-or-create-destination-location)
  * [Create Weight Instance](#create-weight-instance)
  * [Create Package Instance](#create-package-instance)
  * [List All Available Options](#list-all-available-options)

## Dependencies

This package relies on the following libraries to work:

* [Guzzle](https://github.com/guzzle/guzzle)
* [Illuminate Support](https://github.com/illuminate/support)
* [Symfony DomCrawler Component](https://github.com/symfony/dom-crawler)
* [Symfony CssSelector Component](https://github.com/symfony/css-selector)

All above dependencies will be automatically downloaded if you are using [Composer](https://getcomposer.org/) to install this package.

## Installation

To install this library using [Composer](https://getcomposer.org/), simply run the following command inside your project directory:

```bash
composer require risan/jne
```

Or you may also add `risan\jne` package into your `composer.json` file like so:

```bash
"require": {
  "risan/jne": "~1.1"
}
```

Then don't forget to run the following command to install this library:

```bash
composer install
```

## Basic Usage

Here is some basic example about how to use this library:

```php
<?php
// Include autoloder file.
require 'vendor/autoload.php';

// Create a new instance Jne\Jne.
$jne = new Jne\Jne();

// Search for origin city and get the first mathced item.
$bandung = $jne->searchOrigin('Bandung')->first();

// Search for destination city ang get the first matched item.
$depok = $jne->searchDestination('Depok')->first();

// Create a package instance.
// From bandung to depok 10 Kilograms package.
$myPackage = new Jne\Package($origin, $destination, Jne\Weight::fromKilograms(10));

// Get delivery options for $myPackage.
// @return Jne\Collections\DeliveryOptionCollection
$deliveryOptions = $jne->deliveryOptions($myPackage);
```

## Search for Origin

To search for available origin cities or locations, we can use `searchOrigin()` method that owned by the `Jne\Jne` class. We only need to pass the `$query` parameter which is a string.

```php
$jne->searchOrigin(string $query);
```

This method will perform a HTTP request to [jne.co.id](http://www.jne.co.id/) website in order to search for all available origin locations that match the given `$query`.

On success this method will return an instance of `Jne\Collections\LocationCollection` class which contains a collection of `Jne\Location` instances. The `LocationCollection` itself is a subclass of `Illuminate\Support\Collection`, so we may leverage the rich features of [Laravel's collection](http://laravel.com/docs/5.1).

For example, we can find all available origin locations that matched the word `bandar` like so:

```php
$jne = new Jne\Jne();

$origins = $jne->searchOrigin('bandar');
```

We can transform `$origin` into an array using `toArray()` method and see that it contains several `Jne\Location` instances:

```php
print_r($origins->toArray());

Array
(
  [0] => Jne\Location Object
    (
      [name:protected] => BANDAR SRI BENTAN, KAB.BINTAN
      [code:protected] => VE5KMTAxMDA=
    )

  [1] => Jne\Location Object
    (
      [name:protected] => BANDAR,SIMALUNGUN
      [code:protected] => TUVTMjA2MDE=
    )

  [2] => Jne\Location Object
    (
      [name:protected] => BANDARLAMPUNG
      [code:protected] => VEtHMTAwMDA=
    )
)
```

## Search for Destination

To search for all available destination cities or locations, we can use `searchDestination()` method. The usage is very identical with `searchOrigin()` method:

```php
$jne->searchDestination(string $query);
```

This method will also perform a HTTP request to [jne.co.id](http://www.jne.co.id/) website to search for all available destination locations that match the given `$query`.

This method will also return an instance of `Jne\Collections\LocationCollection` class.

For example, we'd like to search for destination locations that match `purwodadi`, we can do it like so:

```php
$jne = new Jne\Jne();

$destinations = $jne->searchDestination('purwodadi');
```

If we printed out the `$destinations` results, we will get the following output:

```php
Array
(
  [0] => Jne\Location Object
    (
        [name:protected] => PURWODADI,KAB.GROBOGAN
        [code:protected] => U1JHMjExMDA=
    )

  [1] => Jne\Location Object
    (
        [name:protected] => PURWODADI,MUARA BELITI BARU
        [code:protected] => UExNMTAzMTI=
    )

  [2] => Jne\Location Object
    (
        [name:protected] => PURWODADI,PASURUAN
        [code:protected] => UEROMTAwMTU=
    )

  [3] => Jne\Location Object
    (
        [name:protected] => PURWODADI,PURWOREJO
        [code:protected] => TUdMMTAzMDg=
    )
)
```

## Get Delivery Options

With this library we can also get all available delivery options offered by JNE, listing all the tariffs and estimatted delivery days.

### Find or Create Origin Location

First we need to find or create an origin location of the package, it must be an instance of `Jne\Location` class. To find the origin location, we can use `searchOrigin()` method:

```php
// Create an instance of Jne\Jne class.
$jne = new Jne\Jne();

// Find origin locations that match `Bandung`.
$origins = $jne->searchOrigin('Bandung');

// Get the first matched location.
$bandung = $origin->first();
```

The `$bandung` variable will hold the following value:

```php
Jne\Location Object
  (
    [name:protected] => BANDUNG
    [code:protected] => QkRPMTAwMDA=
  )
```

If you already know the location's code, you may also create the `Jne\Location` instance manually. With this way we don't have to create an additional HTTP request to JNE website:

```php
$origin = new Jne\Location(string $name, string $code);
```

For example if we already know that `BANDUNG` has a location's code of `QkRPMTAwMDA=`, then we can create `Jne\Location` instance like so:

```php
$bandung = new Jne\Location('BANDUNG', 'QkRPMTAwMDA=');
```

### Find or Create Destination Location

The second step is to find or create a destination location of the package. To find the destination location:

```php
// Create an instance of Jne\Jne class.
$jne = new Jne\Jne();

// Find destination locations that match `Depok`.
$destinations = $jne->searchOrigin('Depok');

// Get the first matched location.
$depok = $destinations->first();
```

Now the above `$depok` variable will hold the following value:

```php
Jne\Location Object
  (
    [name:protected] => DEPOK
    [code:protected] => RFBLMTAwMDA=
  )
```

In case you already know the destination location's code, you can create an instance of `Jne\Location` manually:

```php
$destination = new Jne\Location(string $name, string $code);
```

For example if we already know that `DEPOK` as the destination has a location's code of `RFBLMTAwMDA=`, then we can create it like so:

```php
$depok = new Jne\Location('DEPOK', 'RFBLMTAwMDA=');
```

### Create Weight Instance

The third step is to create a `Jne\Weight` instance that reflects our package's weight. We have several ways to create a `Jne\Weight` instance:

```php
// Create from grams unit.
Jne\Weight::fromGrams(float $grams);

// Create from kilograms unit.
Jne\Weight::fromKilograms(float $kilograms);

// Create from pounds unit.
Jne\Weight::fromPounds(float $pounds);
```

For example if our package is 10 kilograms in weight, we need to create an instance on weight class like so:

```php
$weight = Jne\Weight::fromKilograms(10);
```

### Create Package Instance

The forth step is to create an instance of `Jne\Package` class. This instance represents our package that needs to be delivered.

```php
$package = new Jne\Package($origin, $destination, $weight);
```

Both the `$origin` and the `$destination` are instances of `Jne\Location` instance. While the `$weight` is an instance of `Jne\Weight` class.

Here is the complete example of how to create a package instance:

```php
$jne = new Jne\Jne();

// Create a origin location.
$bandung = new Jne\Location('BANDUNG', 'QkRPMTAwMDA=');

// Find a destination location.
$depok = $jne->searchDestination('DEPOK')->first();

// Create weight.
$weight = Jne\Weight::fromKilograms(10);

$package = new Jne\Package($bandung, $depok, $weight);
```

### List All Available Options

And the last step to retrieve all available delivery options is to call the `deliveryOptions()` method and pass the `Jne\Package` instance:

```php
$jne = new Jne\Jne();

$jne->deliveryOptions(Jne\Package $package);
```

This method will return an instance of `Jne\Collections\DeliveryOptionCollection` class which consist of a collection of `Jne\DeliveryOption` instances. Just like the `LocationCollection` class, this `DeliveryOptionCollection` class is also a subclass of `Illuminate\Support\Collection`.

For example we can fetch all available delivery options for 10 kilograms package from BANDUNG to DEPOK like so:

```php
$jne = new Jne\Jne();

// Create a origin location.
$bandung = new Jne\Location('BANDUNG', 'QkRPMTAwMDA=');

// Create a destination location.
$depok = new Jne\Location('DEPOK', 'RFBLMTAwMDA=');

// Create weight.
$weight = Jne\Weight::fromKilograms(10);

// Create package.
$package = new Jne\Package($bandung, $depok, $weight);

$deliveryOptions = $jne->deliveryOptions($package);
```

The `$deliveryOptions` will contain the collection of `Jne\DeliveryOption` instances. If we printed out the `$deliveryOptions` to the console, we'll get a list of various delivery options:

```php
Array
(
  [0] => Jne\DeliveryOption Object
    (
      [service:protected] => OKE
      [type:protected] => Dokumen / Paket
      [tariff:protected] => 100000
      [estimatedDays:protected] => 2-3 Days
    )

  [1] => Jne\DeliveryOption Object
    (
      [service:protected] => REG
      [type:protected] => Dokumen / Paket
      [tariff:protected] => 110000
      [estimatedDays:protected] => 1-2 Days
    )
  ...
```
