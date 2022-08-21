<?php

namespace Uzzal\Acl\Services;

interface AttributableInterface
{
    public function setAction($action);
    public function getResourceName();
    public function getRoleString();
}