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
