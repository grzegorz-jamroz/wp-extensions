<?php
declare(strict_types=1);

namespace Grzechu\Customizer;

interface ControlInterface
{
    public function getSetting(): Setting;
    public function getArgs(): array;
}
