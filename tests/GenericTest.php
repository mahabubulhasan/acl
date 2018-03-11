<?php
/**
 * @author: Mahabubul Hasan <codehasan@gmail.com>
 * Date: 2/15/2018
 * Time: 2:57 PM
 */
namespace Uzzal\Acl\Tests;

use PHPUnit\Framework\TestCase;
use Uzzal\Acl\Commands\AclResource;
use Uzzal\Acl\Services\RoleService;

class GenericTest extends TestCase
{
    public function testGetNewAndDeletedPermissions(){
        $service = new RoleService();
        $old = ['A','B', 'C', 'D'];
        $new = ['C', 'D', 'E', 'F'];

        $output = [
            'insert'=>[2=>'E', 3=>'F'],
            'delete'=>[0=>'A', 1=>'B']
        ];

        $this->assertEquals($output, $service->getNewAndDeletedPermissions($old, $new));
    }

}