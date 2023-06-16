<?php
declare(strict_types=1);

namespace RockujemyWpExt\EntityFactory;

interface EntityFactory
{
    public function create(string $title): Entity;
}
