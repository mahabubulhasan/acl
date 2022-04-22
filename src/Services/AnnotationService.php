<?php
/**
 * Created by PhpStorm.
 * User: Mahabubul Hasan
 * Date: 3/11/2018
 * Time: 1:47 PM
 */

namespace Uzzal\Acl\Services;


class AnnotationService
{
    const PATTERN_RESOURCE = '/@resource\([\'"]?(.+)[\'"]\)/i';
    const PATTERN_ALLOW_ROLE = '/@allowRole\([\'"]?(.+)[\'"]\)/i';

    private $_class;
    private $_method;

    /**
     * AnnotationService constructor.
     * @param $action string
     */
    public function __construct($action)
    {
        if (strpos($action, '@')) {
            list($this->_class, $this->_method) = explode('@', $action);
        }
    }

    /**
     * reads the @resource('human readable name of the resource')
     * @return string
     */
    public function getResource()
    {
        return $this->_parse(self::PATTERN_RESOURCE);
    }

    /**
     * @param $pattern
     * @return string
     */
    private function _parse($pattern)
    {
        if (!$this->_class) {
            return '';
        }
        try {
            $method = new \ReflectionMethod($this->_class, $this->_method);
            preg_match($pattern, $method->getDocComment(), $matches);
            return count($matches) == 2 ? $matches[1] : '';
        } catch (\ReflectionException $e) {
            return '';
        }
    }

    /**
     * reads the allowed role to the specific action @allowRole('Default, Admin')
     * @return string
     */
    public function getAllowRole()
    {
        return $this->_parse(self::PATTERN_ALLOW_ROLE);
    }
}