<?php

declare(strict_types=1);

namespace LaravelHyperf\HttpMessage\Exceptions;

use Throwable;

class ServerErrorHttpException extends HttpException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null, array $headers = [])
    {
        parent::__construct(500, $message, $code, $previous, $headers);
    }
}
