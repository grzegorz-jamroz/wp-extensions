<?php
declare(strict_types=1);

namespace App\CustomSettings\SettingsBuilder;

use App\CustomSettings\SettingField\SettingField;
use App\CustomSettings\SettingField\SettingFieldCollection;
use App\CustomSettings\SettingSection\SettingSection;
use App\CustomSettings\SettingSection\SettingSectionCollection;

abstract class SettingsBuilder
{
    private $sections;
    private $fields;
    private $pageSlug;

    public function __construct(
        string $pageSlug,
        SettingSectionCollection $sections,
        SettingFieldCollection $fields
    ) {
        $this->pageSlug = $pageSlug;
        $this->sections = $sections;
        $this->fields = $fields;
    }

    public function create()
    {
        $this->addSections($this->sections);
        $this->addFields($this->fields);
        $this->buildSections();
        $this->buildFields();
    }

    public function getFields(): SettingFieldCollection
    {
        return $this->fields;
    }

    abstract protected function addSections(SettingSectionCollection $sections): void;
    abstract protected function addFields(SettingFieldCollection $fields): void;

    private function buildSections()
    {
        /** @var SettingSection $section */
        foreach ($this->sections as $section) {
            add_settings_section(
                $section->getId(),
                $section->getTitle(),
                $section,
                $this->pageSlug
            );
        }
    }

    private function buildFields()
    {
        /** @var SettingField $field */
        foreach ($this->fields as $field) {
            register_setting(
                $field->getSection(),
                $field->getId(),
                $field->getOption('settingArgs')
            );

            add_settings_field(
                $field->getId(),
                $field->getTitle(),
                $field,
                $this->pageSlug,
                $field->getSection(),
                $field->getOption('fieldArgs')
            );
        }
    }
}
