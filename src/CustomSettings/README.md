# Custom settings page

#### 1. Quick check:

add inside `wordpress\wp-content\themes\your-theme\functions.php`
```php
<?php

use Grzechu\CustomSettings\SampleSettings;

// Remember to include autoloader
require_once __DIR__ . '/vendor/autoload.php';

// ...

new SampleSettings();
```

*Sample settings* should appear in wp-admin panel. If everything works than you can build your own settings.

#### 2. Basic usage:

`wordpress\wp-content\themes\your-theme\functions.php`
```php
<?php

use Grzechu\CustomSettings\SampleSettings;

// Remember to include autoloader
require_once __DIR__ . '/vendor/autoload.php';

// ...

new SampleSettings();
```
