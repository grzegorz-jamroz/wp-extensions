# Custom Post Type

#### Basic usage:

1\. Create class `MoviePostType` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomPostType/MoviePostType.php`

```php
<?php
declare(strict_types=1);

namespace App\CustomPostType;

use Grzechu\CustomPostType\PostType;

class MoviePostType extends PostType
{
    public function getArgs(): array
    {
        return [
            'labels' => $this->getLabels(),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-video-alt',
            'show_in_rest' => true,
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ],
        ];
    }

    public function getSingularName(): string
    {
        return 'Movie';
    }

    public function getPluralName(): string
    {
        return 'Movies';
    }

    public function getPostTypeKey(): string
    {
        return 'movie';
    }
}
```

As you can see `MoviePostType` has to extends `PostType`.

2\. Instantiate `MoviePostType` for example inside 
`wordpress/wp-content/themes/your-theme/functions.php`

```php
use App\CustomPostType\MoviePostType;

MoviePostType::getInstance();
```

3\. **That's it** - you should be able now to see and use **Movies** in wp-admin panel.
