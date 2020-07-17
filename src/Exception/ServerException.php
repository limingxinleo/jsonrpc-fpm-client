<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Xin\JsonRPC\FpmClient\Exception;

use Throwable;

class ServerException extends \RuntimeException
{
    /**
     * @var array
     */
    protected $error;

    public function __construct(array $error = [], Throwable $previous = null)
    {
        $code = $error['data']['code'] ?? 0;
        $message = $error['data']['message'] ?? 'Server Error';

        $this->error = $error;
        parent::__construct($message, $code, $previous);
    }

    public function getError(): array
    {
        return $this->error;
    }
}
