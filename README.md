#  API Client

PHP bindings for the Labelary.com API (http://labelary.com).

[API Documentation](http://labelary.com/service.html#parameters)

[![Build Status](https://travis-ci.org/printu/labelary.svg?branch=master)](https://travis-ci.org/printu/labelary)
[![Code Climate](https://codeclimate.com/github/printu/labelary/badges/gpa.svg)](https://codeclimate.com/github/printu/labelary)
[![Test Coverage](https://codeclimate.com/github/printu/labelary/badges/coverage.svg)](https://codeclimate.com/github/printu/labelary/coverage)

## Installation

The API client can be installed via [Composer](https://github.com/composer/composer).

In your composer.json file:

```json
{
    "require": {
        "printu/labelary": "~2.0"
    }
}
```

Once the composer.json file is created you can run `composer install` for the initial package install and `composer update` to update to the latest version of the API client.

The client uses [Guzzle](http://docs.guzzlephp.org/en/stable/).

## Basic Usage

Remember to include the Composer autoloader in your application:

```php
<?php
use GuzzleHttp\Exception\GuzzleException;

require_once 'vendor/autoload.php';

// Application code...
$labelary = new Labelary\Client();

$zpl = '^xa^cfa,50^fo100,100^fdHello World^fs^xz';

try {
    $response = $labelary->printers->labels([
        'zpl' => $zpl,
        'response' => 'application/pdf',
        'rotate' => 180
    ]);
} catch (GuzzleException $e) {
    throw new Exception("API Labelary error: ".$e->getMessage());
}
```

## License

MIT license. See the [LICENSE](LICENSE) file for more details.