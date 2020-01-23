# Custom Post Type

#### Basic usage:

1\. Create class `Genere` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomTaxonomy/Genere.php`

```php
<?php
declare(strict_types=1);

namespace App\CustomTaxonomy;

use Grzechu\CustomTaxonomy\Taxonomy;

class Genere extends Taxonomy
{

    public function getTaxonomyKey(): string
    {
        return 'genere';
    }

    public function getSingularName(): string
    {
        return 'Genere';
    }

    public function getPluralName(): string
    {
        return 'Generies';
    }

    public function getPostTypes(): array
    {
        return ['movie'];
    }

    public function getArgs(): array
    {
        return [
            'labels' => $this->getLabels(),
        ];
    }
}
```

As you can see `Genere` has to extends `Taxonomy`.

2\. Instantiate `Genere` for example inside 
`wordpress/wp-content/themes/your-theme/functions.php`

```php
use App\CustomTaxonomy\Genere;

Genere::getInstance();
```

3\. **That's it** - you should be able now to see and use **Generies** for `Movies` in wp-admin panel.
