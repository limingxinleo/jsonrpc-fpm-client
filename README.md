# JSONRPC FPM Client

[![Build Status](https://travis-ci.com/limingxinleo/jsonrpc-fpm-client.svg?branch=master)](https://travis-ci.com/limingxinleo/jsonrpc-fpm-client)

## 安装

```
composer require limingxinleo/jsonrpc-fpm-client
```

## 使用

实现 Client

```php
<?php

use Xin\JsonRPC\FpmClient\Client;

/**
 * @method string id(string $id)
 * @method void exception()
 */
class IdGenerator extends Client
{
}

```

调用 RPC

```php
<?php

use Xin\JsonRPC\FpmClient\Packer\JsonLengthPacker;
use Xin\JsonRPC\FpmClient\Transporter\TcpTransporter;

$client = new IdGenerator('IdGenerateService', new TcpTransporter('127.0.0.1', 9502), new JsonLengthPacker());
$ret = $client->id($id = uniqid());
```

