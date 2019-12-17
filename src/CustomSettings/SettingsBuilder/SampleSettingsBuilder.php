<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings\SettingsBuilder;

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
