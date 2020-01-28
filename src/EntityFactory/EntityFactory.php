<?php
declare(strict_types=1);

namespace Grzechu\EntityFactory;

interface EntityFactory
{
    public function create(string $title): Entity;
}
