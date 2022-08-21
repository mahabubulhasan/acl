<?php
namespace Uzzal\Acl\Services;


use Illuminate\Support\Facades\Log;

class AnnotationService implements AttributableInterface
{
    const PATTERN_RESOURCE = '/@resource\([\'"]?(.+)[\'"]\)/i';
    const PATTERN_ALLOW_ROLE = '/@allowRole\([\'"]?(.+)[\'"]\)/i';

    private $_class;
    private $_method;

    public function setAction($action)
    {
        Log::info('setAction: ');
        Log::info($action);
        if (strpos($action, '@')) {
            list($this->_class, $this->_method) = explode('@', $action);
        }
    }

    /**
     * reads the @resource('human readable name of the resource')
     * @return string
     */
    public function getResourceName()
    {
        $tmp = $this->_parse(self::PATTERN_RESOURCE);
        Log::info('getResourceName: ');
        Log::info($tmp);
        return $tmp;
    }

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
    public function getRoleString()
    {
        $tmp = $this->_parse(self::PATTERN_ALLOW_ROLE);
        Log::info('getRoleString: ');
        Log::info($tmp);
        return $tmp;
    }
}