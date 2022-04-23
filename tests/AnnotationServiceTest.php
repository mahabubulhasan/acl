<?php
/**
 * Created by PhpStorm.
 * User: Mahabubul Hasan
 * Date: 3/11/2018
 * Time: 8:12 PM
 */

namespace Uzzal\Acl\Tests;

use PHPUnit\Framework\TestCase;
use Uzzal\Acl\Services\AnnotationService;

class AnnotationServiceTest extends TestCase
{
    public function testAnnotations()
    {
        $obj = new AnnotationService('Uzzal\Acl\Tests\AnnotationDummy@dummyMethod');
        $this->assertEquals('Default, Admin', $obj->getRoleString());
        $this->assertEquals('This is a dummy resource', $obj->getResourceName());
    }
}

class AnnotationDummy
{
    /**
     * @resource('This is a dummy resource')
     * @allowRole('Default, Admin')
     */
    public function dummyMethod()
    {
        return true;
    }
}
