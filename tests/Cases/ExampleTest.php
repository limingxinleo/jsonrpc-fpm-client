<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use HyperfTest\Stub\IdGenerator;
use Xin\JsonRPC\FpmClient\Packer\JsonLengthPacker;
use Xin\JsonRPC\FpmClient\Transporter\TcpTransporter;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends AbstractTestCase
{
    public function testExample()
    {
        $this->assertTrue(true);

        // $client = new IdGenerator('IdGenerateService', new TcpTransporter('127.0.0.1', 9502), new JsonLengthPacker());
        //
        // $ret = $client->id($id = uniqid());
        //
        // $this->assertStringContainsString($id, $ret);
    }
}
