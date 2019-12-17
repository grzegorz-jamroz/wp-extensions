<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings;

use Grzechu\SettingField\SettingField;
use Grzechu\SettingField\SettingFieldCollection;
use Grzechu\SettingsBuilder\SettingsBuilder;
use Grzechu\SettingSection\SettingSectionCollection;

abstract class Settings
{
    protected $pluralLabel;
    protected $pageSlug;
    protected $icon;
    protected $position;
    protected $capability = 'manage_options';

    /**
     * @var SettingsBuilder
     */
    protected $builder;

    public function __construct(
        $pluralLabel,
        $pageSlug,
        $icon,
        $position,
        $builderClass
    ) {
        $this->pluralLabel = $pluralLabel;
        $this->pageSlug = $pageSlug;
        $this->icon = $icon;
        $this->position = $position;
        $this->setBuilder($builderClass);
        add_action('admin_init', [$this, 'init']);
        add_action('admin_menu', [$this, 'add_menu_page']);
    }

    public function init()
    {
        $this->builder->create();
    }

    public function add_menu_page() {
        add_menu_page(
            $this->pluralLabel,
            $this->pluralLabel,
            $this->capability,
            $this->pageSlug,
            [$this, 'renderPage'],
            $this->icon,
            $this->position
        );
    }

    public function renderPage()
    {
        if (!current_user_can($this->capability)) {
            return;
        }

        $this->prepareFlashMessage();
        $title = esc_html(get_admin_page_title());

        echo <<<HTML
            <div class="wrap">
                <h1>$title</h1>
                <form action="options.php" method="post">
        HTML;

        /** @var SettingField $field */
        foreach ($this->builder->getFields() as $field) {
            settings_fields($field->getSection());
        }

        do_settings_sections($this->pageSlug);
        submit_button('Save Settings');

        echo <<<HTML
                </form>
            </div>
        HTML;
    }

    protected function prepareFlashMessage()
    {
        $messageSlug = sprintf('%_messages', $this->pageSlug);

        if (isset($_GET['settings-updated'])) {
            add_settings_error(
                $messageSlug,
                $messageSlug,
                'Settings Saved',
                'updated'
            );
        }

        settings_errors($messageSlug);
    }

    protected function setBuilder(string $class): void
    {
        $sections = new SettingSectionCollection();
        $fields = new SettingFieldCollection($sections);

        $this->builder = new $class(
            $this->pageSlug,
            $sections,
            $fields
        );
    }
}
