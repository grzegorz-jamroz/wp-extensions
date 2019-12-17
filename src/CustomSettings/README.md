# Custom settings page

#### Basic usage:

1\. Create class `SampleSettings` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomSettings/SampleSettings.php`

```php
<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings;

use Grzechu\CustomSettings\SettingsBuilder\SampleSettingsBuilder;

class SampleSettings extends Settings
{
    public function __construct() {
        parent::__construct(
            'Sample settings',
            'sample_settings',
            'dashicons-admin-post',
            25,
            SampleSettingsBuilder::class
        );
    }
}
```

As you can see `SampleSettings` has to extends `Settings`.
You can extend `renderPage` method to modify age rendering.

2\. Create class `SampleSettingsBuilder` for example inside 
`wordpress/wp-content/themes/your-theme/src/CustomSettings/SampleSettingsBuilder.php`

```php
<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings\SettingsBuilder;

use Grzechu\CustomSettings\SettingField\SettingFieldCollection;
use Grzechu\CustomSettings\SettingField\TextareaField;
use Grzechu\CustomSettings\SettingSection\SimpleSection;
use Grzechu\CustomSettings\SettingSection\SettingSectionCollection;

class SampleSettingsBuilder extends SettingsBuilder
{
    protected function addSections(SettingSectionCollection $sections): void
    {
        $sections->add(
            new SimpleSection(
                'first_sample_section',
                'First sample section',
                [
                    'description' => 'This is first section.',
                ]
            ),
            new SimpleSection(
                'second_sample_section',
                'Second sample section',
                [
                    'description' => 'This is second section.',
                ]
            ),
        );
    }

    protected function addFields(SettingFieldCollection $fields): void
    {
        $fields->add(
            new TextareaField(
                'first_sample_section',
                'first_sample_section_field_one',
                'Field one',
                [
                    'settingArgs' => [
                        'sanitize_callback' => null
                    ],
                ]
            ),
            new TextareaField(
                'first_sample_section',
                'first_sample_section_field_two',
                'Field two',
                [
                    'settingArgs' => [
                        'sanitize_callback' => null
                    ],
                ]
            ),
            new TextareaField(
                'second_sample_section',
                'second_sample_section_field_one',
                'Field one',
                [
                    'settingArgs' => [
                        'sanitize_callback' => null
                    ],
                ]
            ),
        );
    }
}
```

As you can see `SampleSettingsBuilder` has to extends `SettingsBuilder`.
You can add as many sections and fields inside `addSections` and `addFields` methods.

3\. **That's it** - you should be able now to see and use *Sample settings* in wp-admin panel.

#### Create own SettingField:

If you would like to create your own field type than you can do it the same way as it is inside [TextareaField](src/CustomSettings/SettingField/TextareaField.php)

#### Create own SettingSection:

If you would like to create your own field type than you can do it the same way as it is inside [SettingSection](src/CustomSettings/SettingSection/SettingSection.php)
