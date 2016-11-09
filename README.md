
![Build Status](https://travis-ci.org/accredible/acms-php-api.svg?branch=master)

# Accredible API PHP SDK

## Overview
The Accredible platform enables organizations to create, manage and distribute digital credentials as digital certificates or open badges.

An example digital certificate and badge can be viewed here: https://www.credential.net/10000005

This Composer package wraps the Accredible API in PHP for easy integration into projects. Full API documentation can be found here: http://docs.accrediblecredentialapi.apiary.io/

## Install
```bash
composer require accredible/acms-php-api dev-master
```

## Usage

Add `use ACMS\Api;` to the class you'd like to use the API in.

```php
use ACMS\Api;

// Instantiate the API instance replacing APIKey with your API key
$api = new Api("APIKey");

// Get a Credential
$api->get_credential(10000005);

// Get an array of Credentials 
$api->get_credentials(null, "john@example.com");

// Create a Credential - Name, Email, Group ID
$api->create_credential("John Doe", "john@example.com", 54018);

// Update a Credential
$api->update_credential(10000005, "Jonathan Doe");

// Delete a Credential
$api->delete_credential(10000005);

// Get a Group
$api->get_group(100);

// Create a Group - Name, Course Name, Course Description, Course Link
$api->create_group("PHPTest", "Test course", "Test course description.", "http://www.example.com");

// Update a Group 
$api->update_group(100, 'PHPTest2');

// Delete a Group
$api->delete_group(100);
```

### License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
