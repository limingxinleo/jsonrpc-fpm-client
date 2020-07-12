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
use Xin\JsonRPC\FpmClient\Exception\ServerException;
use Xin\JsonRPC\FpmClient\Packer\JsonLengthPacker;
use Xin\JsonRPC\FpmClient\Transporter\TransporterInterface;

/**
 * @internal
 * @coversNothing
 */
class ClientTest extends AbstractTestCase
{
    protected function tearDown()
    {
        \Mockery::close();
    }

    public function testSendAndRecv()
    {
        $packer = new JsonLengthPacker();
        $id = uniqid();
        $transporter = \Mockery::mock(TransporterInterface::class);
        $transporter->shouldReceive('send')->withAnyArgs()->andReturnUsing(function ($string) use ($packer, $id) {
            $data = $packer->unpack($string);
            $this->assertSame([$id], $data['params']);
            $this->assertSame('/id_generate/id', $data['method']);
        });
        $transporter->shouldReceive('recv')->andReturnUsing(function () use ($packer) {
            return $packer->pack([
                'jsonrpc' => '2.0',
                'id' => uniqid(),
                'result' => 'Hello Hyperf.',
                'context' => [],
            ]);
        });
        $client = new IdGenerator('IdGenerateService', $transporter, $packer);
        $ret = $client->id($id);
        $this->assertSame('Hello Hyperf.', $ret);
    }

    public function testException()
    {
        $packer = new JsonLengthPacker();
        $transporter = \Mockery::mock(TransporterInterface::class);
        $transporter->shouldReceive('send')->withAnyArgs()->andReturnUsing(function ($string) use ($packer) {
            $data = $packer->unpack($string);
            $this->assertSame('/id_generate/exception', $data['method']);
        });
        $transporter->shouldReceive('recv')->andReturnUsing(function () use ($packer) {
            return $packer->pack([
                'jsonrpc' => '2.0',
                'id' => uniqid(),
                'error' => [
                    'data' => [
                        'code' => 500,
                        'message' => 'Inner Server Error',
                    ],
                ],
                'context' => [],
            ]);
        });
        $client = new IdGenerator('IdGenerateService', $transporter, $packer);

        $this->expectException(ServerException::class);
        $this->expectExceptionCode(500);
        $this->expectExceptionMessage('Inner Server Error');
        $client->exception();
    }
}
