# Custom metaboxes

#### Basic usage:

1\. Create class `PostMetaboxBuilder` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomMetabox/PostMetaboxBuilder.php`

```php
<?php
declare(strict_types=1);

namespace App\CustomMetabox;

use Grzechu\CustomMetabox\MetaboxBuilder;
use Grzechu\CustomMetabox\MetaboxField\DropdownField;
use Grzechu\CustomMetabox\MetaboxField\TextField;
use Grzechu\CustomMetabox\MetaboxFieldCollection;

class PostMetaboxBuilder extends MetaboxBuilder
{
    protected function addFields(MetaboxFieldCollection $fields): void
    {
        $fields->add(
            new TextField(
                'post_password_field',
                'Post password'
            ),
            new DropdownField(
                'post_show_footer_field',
                'Footer',
                [
                    'choices' => [
                        'hide' => 'Hide footer',
                        'show' => 'Show footer',
                    ],
                ]
            )           
        );
    }
}
```

`PostMetaboxBuilder` has to extends `MetaboxBuilder`.
You can add all needed fields inside `addFields` method. 
To add new fields you can use default field types or easy [create own types](#create-own-metabox-field-types).

Default types which provide library:
- TextField
- DropdownField

2\. Create class `PostMetabox` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomMetabox/PostMetabox.php`

```php
<?php
declare(strict_types=1);

namespace App\CustomMetabox;

use Grzechu\CustomMetabox\Metabox;

class PostMetabox extends Metabox
{
    public function __construct()
    {
        parent::__construct(
            PostMetaboxBuilder::class,
            'post_settings_metabox',
            'Post settings',
            ['post'],
            'side'
        );
    }
}
```

`PostMetabox` has to extends `Metabox`.

Parameters which constructor takes are described below:

| Parameter                    | Description                      |
|------------------------------|----------------------------------|
| string $builderClassName     | Class name where we added fields |
| string $id                   | Meta box ID (used in the 'id' attribute for the meta box) |
| string $title                | Title of the meta box. |
| array $screens = []          | Optional. The screen or screens on which to show the box (such as a post type, 'link', or 'comment'). Accepts a array of screen IDs. Default is the current screen.  If you have used add_menu_page() or add_submenu_page() to create a new screen (and hence screen_id), make sure your menu slug conforms to the limits of sanitize_key() otherwise the 'screen' menu may not correctly render on your page. |
| string $context = 'advanced' | Optional. The context within the screen where the boxes should display. Available contexts vary from screen to screen. Post edit screen contexts include 'normal', 'side', and 'advanced'. Comments screen contexts include 'normal' and 'side'. Menus meta boxes (accordion sections) all use the 'side' context. Global default is 'advanced'. |
| string $priority = 'default' | Optional. The priority within the context where the boxes should show ('high', 'low'). Default 'default'. |
| array $args = []             | Optional. Data that should be set as the $args property of the box array (which is the second parameter passed to your callback). |

#### MetaboxField:
| Parameter           | Description                      |
|---------------------|----------------------------------|
| string $id          | This is the same as Metadata key. It will be stored inside table `wp_postmeta` under field `meta_key` |
| array $options = [] | Additional options which you can pass to your field. For example you can pass `choices` to DropdownFields  |

#### Create own metabox field types:

1\. Create class `EmailField` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomMetabox/MetaboxField/EmailField.php`

```php
<?php
declare(strict_types=1);

namespace App\CustomMetabox\MetaboxField;

use Grzechu\CustomMetabox\MetaboxField;
use WP_Post;

class EmailField extends MetaboxField
{
    public function html(WP_Post $post): string
    {
        $value = esc_attr(get_post_meta($post->ID, $this->id, true));

        return <<<HTML
            <p class="post-attributes-label-wrapper">
                <p class="post-attributes-label-wrapper"><strong>$this->label</strong></p>
                <input type="email" name="$this->id" id="$this->id" value="$value" />
            </p>
        HTML;
    }
}
```

Your custom fields has to extends `MetaboxField`.

2\. You can use it inside your builder

```php
<?php
declare(strict_types=1);

namespace App\CustomMetabox;

use App\CustomMetabox\MetaboxField\EmailField;
use Grzechu\CustomMetabox\MetaboxBuilder;
use Grzechu\CustomMetabox\MetaboxFieldCollection;

class PostMetaboxBuilder extends MetaboxBuilder
{
    protected function addFields(MetaboxFieldCollection $fields): void
    {
        $fields->add(
            new EmailField(
                'post_email_field',
                'Post email'
            )   
        );
    }
}
```
