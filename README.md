# WC Asperato

[![Packagist Version](https://img.shields.io/packagist/v/itinerisltd/wc-asperato.svg)](https://packagist.org/packages/itinerisltd/wc-asperato)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/itinerisltd/wc-asperato.svg)](https://packagist.org/packages/itinerisltd/wc-asperato)
[![Packagist Downloads](https://img.shields.io/packagist/dt/itinerisltd/wc-asperato.svg)](https://packagist.org/packages/itinerisltd/wc-asperato)
[![GitHub License](https://img.shields.io/github/license/itinerisltd/wc-asperato.svg)](https://github.com/ItinerisLtd/wc-asperato/blob/master/LICENSE)
[![Hire Itineris](https://img.shields.io/badge/Hire-Itineris-ff69b4.svg)](https://www.itineris.co.uk/contact/)

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->


- [Minimum Requirements](#minimum-requirements)
- [Installation](#installation)
- [To Webkul](#to-webkul)
  - [Task 1 - pid](#task-1---pid)
  - [Task 2 - payment status](#task-2---payment-status)
- [To Itineris Team](#to-itineris-team)
- [Not Supported / Not Implemented](#not-supported--not-implemented)
- [Incompatibility](#incompatibility)
- [Test Credentials](#test-credentials)
- [FAQ](#faq)
  - [Will you add support for older PHP versions?](#will-you-add-support-for-older-php-versions)
  - [It looks awesome. Where can I find some more goodies like this?](#it-looks-awesome-where-can-i-find-some-more-goodies-like-this)
  - [This plugin isn't on wp.org. Where can I give a ⭐️⭐️⭐️⭐️⭐️ review?](#this-plugin-isnt-on-wporg-where-can-i-give-a-%EF%B8%8F%EF%B8%8F%EF%B8%8F%EF%B8%8F%EF%B8%8F-review)
- [Testing](#testing)
- [Feedback](#feedback)
- [Change Log](#change-log)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

[Asperato](https://asperato.com/) integration for WooCommerce.

## Minimum Requirements

- PHP v7.2
- WordPress v4.9.8
- WooCommerce v3.4.4

## Installation

```json
# composer.json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:ItinerisLtd/wc-asperato.git"
    }
  ]
}
```

```bash
$ composer require itinerisltd/wc-asperato
```

## To Webkul

### Task 1 - pid

> 'pid' is the Salesforce ID of the related payment object row.  
> It will have to be obtained from Salesforce.
> The basic principal is to go through the journey where the customer decides on what they wish to purchase.
> Once they get to the point of fulfilment (i.e. payment) a record would be inserted into the payment object in Salesforce and then the customer can be transferred to the Ecommerce URL that is generated.  Before the Asperato paypage is then displayed we'll grab data from Salesforce using the parameters and that will pre-populate the Asperato pay page with amount, currency, etc.
>
> -- Asperato Support

You need to hook into [`wc_asperato_pid`](./src/GatewayOperations/Receipt.php) and return a string:
```php
add_filter('wc_asperato_pid', function(\WC_Order $order): string {
    $pid = xxxxxx // Retrieve payment reference from Salesforce.
    return $pid;
});
```

### Task 2 - payment status

After users filling out Asperato iFrame form successfully, this plugin set the order status to `on-hold`.

You need to:
- hook into correct WooCommerce action
- check payment status on Salesforce
- update WooCommerce order status

## To Itineris Team

[Asperato](https://asperato.com/) is not up to Itineris standards. 
Using this plugin requires **prior approval** from the PHP team.

Before we retrieve payment reference from Salesforce:
```php
add_filter('wc_asperato_pid', function() {
    return '';
});
```

## Not Supported / Not Implemented

- camid
- recurring payment
- refund
- void

## Incompatibility

- [Privacy Badger](https://www.eff.org/privacybadger)

## Test Credentials

pmRef: 903
Credit card number: 4242 4242 4242 4242
CVV: 123
Expiry Date: Any date in the next year

## FAQ

### Will you add support for older PHP versions?

Never! This plugin will only works on [actively supported PHP versions](https://secure.php.net/supported-versions.php).

Don't use it on **end of life** or **security fixes only** PHP versions.

### It looks awesome. Where can I find some more goodies like this?

- Articles on [Itineris' blog](https://www.itineris.co.uk/blog/)
- More projects on [Itineris' GitHub profile](https://github.com/itinerisltd)
- Follow [@itineris_ltd](https://twitter.com/itineris_ltd) and [@TangRufus](https://twitter.com/tangrufus) on Twitter
- Hire [Itineris](https://www.itineris.co.uk/services/) to build your next awesome site

### This plugin isn't on wp.org. Where can I give a ⭐️⭐️⭐️⭐️⭐️ review?

Thanks! Glad you like it. It's important to make my boss know somebody is using this project. Instead of giving reviews on wp.org, consider:

- tweet something good with mentioning [@itineris_ltd](https://twitter.com/itineris_ltd)
- star this Github repo
- watch this Github repo
- write blog posts
- submit pull requests
- [hire Itineris](https://www.itineris.co.uk/services/)

## Testing

```bash
$ composer test
$ composer check-style
```

Pull requests without tests will not be accepted!

## Feedback

**Please provide feedback!** We want to make this library useful in as many projects as possible.
Please submit an [issue](https://github.com/ItinerisLtd/wc-asperato/issues/new) and point out what you do and don't like, or fork the project and make suggestions.
**No issue is too small.**

## Change Log

Please see [CHANGELOG](./CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email hello@itineris.co.uk instead of using the issue tracker.

## Credits

[WC Asperato](https://github.com/ItinerisLtd/wc-asperato) is a [Itineris Limited](https://www.itineris.co.uk/) project created by [Tang Rufus](https://typist.tech).

Full list of contributors can be found [here](https://github.com/ItinerisLtd/wc-asperato/graphs/contributors).

## License

[WC Asperato](https://github.com/ItinerisLtd/wc-asperato) is licensed under the GPLv2 (or later) from the [Free Software Foundation](http://www.fsf.org/).
Please see [License File](LICENSE) for more information.
