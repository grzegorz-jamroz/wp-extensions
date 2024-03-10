<h1 align="center">Rockujemy Wordpress Extensions</h1>

<p align="center">
    <strong>Library used in Rockujemy themes and plugins.</strong>
</p>

<p align="center">
    <img src="https://img.shields.io/badge/php->=7.4-blue?colorB=%238892BF" alt="Code Coverage">  
    <img src="https://img.shields.io/badge/release-v1.0.1-blue" alt="Release Version">   
</p>

# Installation

Open console in your WordPress theme folder or plugin folder:

```bash
cd wordpress\wp-content\themes\your-theme
```

or

```bash
cd wordpress\wp-content\plugins\your-plugin
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
