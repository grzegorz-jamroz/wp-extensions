<?php
declare(strict_types=1);

namespace App\CustomSettings;

use App\CustomSettings\SettingField\SettingField;
use App\CustomSettings\SettingsBuilder\SampleSettingsBuilder;

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
