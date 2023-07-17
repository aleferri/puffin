<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\log;

/**
 * LoggerInterface-like interface, except it doesn't require an additional useless class LogLevel and has a shorter name
 * LogLevel description is provided by independent constants by PHP
 */
interface Logger {

    public function emergency(string $message, array $info = []): void;

    public function alert(string $message, array $info = []): void;

    public function critical(string $message, array $info = []): void;

    public function error(string $message, array $info = []): void;

    public function warning(string $message, array $info = []): void;

    public function notice(string $message, array $info = []): void;

    public function info(string $message, array $info = []): void;

    public function debug(string $message, array $info = []): void;

    public function log(int $level, string $message, array $info = []): void;

    public function flush(): void;

}
