<?php

namespace Uzzal\Acl\Services;

use ReflectionClass;
use Uzzal\Acl\Attributes\Authorize;
use Uzzal\Acl\Attributes\Resource;

class AttributeService implements AttributableInterface
{
    private $_class_name;
    private $_method;
    private $_roles = [];
    private $_resource = [];
    private $_is_parsed = false;

    private function _parse()
    {
        if ($this->_is_parsed) {
            return;
        }
        if (!$this->_class_name) {
            return;
        }

        $reflection = new ReflectionClass($this->_class_name);

        foreach ($reflection->getMethods() as $method) {
            if ($method->getName() == $this->_method) {
                $this->_roles = $this->_readAttribute($method, Authorize::class);
                $this->_resource = $this->_readAttribute($method, Resource::class);
            }
        }

        $this->_is_parsed = true;
    }

    private function _readAttribute(\ReflectionMethod $method, $attributeClass)
    {
        $attributes = $method->getAttributes($attributeClass);

        foreach ($attributes as $attr) {
            if ($attr->getName() == $attributeClass) {
                return $attr->getArguments();
            }
        }
        return [];
    }

    public function getResourceName()
    {
        $this->_parse();
        if (count($this->_resource) > 0) {
            return $this->_resource[0];
        }
        return '';
    }

    public function getRoleString()
    {
        $this->_parse();
        if (count($this->_roles) > 0) {
            return implode(', ', $this->_roles);
        }
    }

    public function setAction($action)
    {
        if (strpos($action, '@')) {
            list($this->_class_name, $this->_method) = explode('@', $action);
        }

        $this->_is_parsed = false;
    }

    public static function hasAuthorizeAttribute($action)
    {
        $className = '';
        $methodName = '';
        if (strpos($action, '@')) {
            list($className, $methodName) = explode('@', $action);
        }

        if ($className == '' || $methodName == '') {
            return false;
        }

        $reflection = new ReflectionClass($className);

        foreach ($reflection->getMethods() as $method) {
            if ($method->getName() == $methodName) {
                $attributes = $method->getAttributes(Authorize::class);
                foreach ($attributes as $attr) {
                    if ($attr->getName() == Authorize::class) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}
