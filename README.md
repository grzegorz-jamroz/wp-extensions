# Wordpress Extensions

Library allow to build quicker some custom functionalities inside your wordpress theme without using plugins.

## Requirements

- PHP 7.4 ![php](https://img.shields.io/badge/php-7.4%20>-blue)
- Wordpress 5.32: ![version](https://img.shields.io/badge/wordpress-5.32%20>-yellow)


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

- [Custom Post Type](src/CustomPostType/README.md)
- [Custom Taxonomy](src/CustomTaxonomy/README.md)
