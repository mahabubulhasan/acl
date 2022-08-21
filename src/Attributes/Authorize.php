<?php

namespace Uzzal\Acl\Attributes;

use Attribute;

#[Attribute]
class Authorize
{
    public function __construct(?string $roles = null)
    {
    }
}