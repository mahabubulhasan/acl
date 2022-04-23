<?php

namespace Uzzal\Acl\Attributes;

use Attribute;

#[Attribute]
class Resource
{
    public function __construct(?string $name)
    {
    }
}