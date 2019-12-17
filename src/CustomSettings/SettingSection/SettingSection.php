<?php
declare(strict_types=1);

namespace Grzechu\CustomSettings\SettingSection;

abstract class SettingSection
{
    protected $id;
    protected $title;
    protected $options;

    public function __construct(
        string $id,
        string $title,
        array $options = []
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->options = $options;
    }

    public function getOption(string $option)
    {
        return $this->options[$option] ?? null;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    abstract public function __invoke();
}
