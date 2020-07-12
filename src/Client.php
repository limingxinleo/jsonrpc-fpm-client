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
namespace Xin\JsonRPC\FpmClient;

use Hyperf\Contract\PackerInterface;

class Client
{
    protected $client;

    protected $service;

    protected $packer;

    protected $formatter;

    public function __construct(string $service, PackerInterface $packer)
    {
        $this->service = $service;
        $this->packer = $packer;
        $this->formatter = new DataFormatter();
    }
}
