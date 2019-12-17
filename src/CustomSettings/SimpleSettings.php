<?php
declare(strict_types=1);

namespace App\CustomSettings;

use Grzechu\SettingField\SettingField;
use Grzechu\SettingsBuilder\SampleSettingsBuilder;

class SimpleSettings extends Settings
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
