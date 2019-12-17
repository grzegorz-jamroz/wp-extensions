<?php
declare(strict_types=1);

namespace Grzechu\SettingField;

abstract class SettingField
{
    protected $section;
    protected $id;
    protected $title;
    private $options;

    public function __construct(
        string $section,
        string $id,
        string $title,
        array $options = []
    ) {
        $this->section = $section;
        $this->id = $id;
        $this->title = $title;
        $this->setOptions($options);
    }

    abstract public function __invoke();

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSection(): string
    {
        return $this->section;
    }

    public function getOption(string $option)
    {
        return $this->options[$option] ?? null;
    }

    private function setOptions(array $options): void
    {
        $defaultOptions = [
            'settingArgs' => [
                'sanitize_callback' => 'sanitize_text_field',
            ],
            'fieldArgs' => [],
        ];

        $this->options = wp_parse_args($options, $defaultOptions);
    }
}
