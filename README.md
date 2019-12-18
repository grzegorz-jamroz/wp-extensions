# Wordpress Extensions

Library allow to build quicker some custom functionalities inside your wordpress theme without using plugins.

## Requirements

- PHP 7.3 ![php](https://img.shields.io/badge/php-7.3-blue)
- Wordpress 5.3: ![version](https://img.shields.io/badge/wordpress-5.3-yellow)


# Installation

Open console in your wordpress theme folder:

```bash
cd wordpress\wp-content\themes\your-theme
```

Run [Composer](https://getcomposer.org) to install this package in your project:

```bash
composer require grzegorz-jamroz/wp-extensions
```

Remember to require `vendor/autoload.php` file in your code to enable the class autoloading mechanism provided by Composer.

You can do it for example in the beginning of:
`wordpress/wp-content/themes/your-theme/functions.php`

```bash
require_once __DIR__ . '/vendor/autoload.php';
```

# Usage

- [Custom settings page](src/CustomSettings/README.md)
- [Custom metabox](src/CustomMetabox/README.md)
