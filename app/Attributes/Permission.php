<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Permission
{
    public function __construct(public string $name) {}
}
