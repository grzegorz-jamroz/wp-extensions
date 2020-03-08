<?php
declare(strict_types=1);

namespace Grzechu\Customizer;

interface SettingInterface
{
    public function getSettingId(): string;
    public function getArgs(): array;
}
