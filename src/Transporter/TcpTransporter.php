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
namespace Xin\JsonRPC\FpmClient\Transporter;

use Xin\JsonRPC\FpmClient\Exception\ConnectionException;

class TcpTransporter implements TransporterInterface
{
    /**
     * @var null|resource
     */
    protected $client;

    public function __construct(string $ip, int $port)
    {
        if ($this->client) {
            fclose($this->client);
            unset($this->client);
        }
        $client = stream_socket_client("tcp://{$ip}:{$port}");
        if ($client === false) {
            throw new ConnectionException('Connect failed.');
        }

        $this->client = $client;
    }

    public function send(string $data)
    {
        fwrite($this->client, $data);
    }

    public function recv()
    {
        return fread($this->client, 65535);
    }
}
