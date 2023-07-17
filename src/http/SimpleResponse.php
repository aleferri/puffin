<?php

declare(strict_types = 1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\http;

use puffin\http\session\Cookies;

class SimpleResponse implements Response {

    private $status;
    private $headers;
    private $body;

    public function __construct(int $status = 200, array $headers = [], string $body = '') {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
        $this->cookies = Cookies::empty();
    }

    public function with_status(int $http_code): Response {
        $this->status = $http_code;

        return $this;
    }

    public function with_headers(array $headers): Response {
        $this->headers = $headers;

        return $this;
    }

    public function with_header(string $header, string $value): Response {
        $this->headers[ $header ] = $value;

        return $this;
    }

    public function without_header(string $header): Response {
        unset( $this->headers[ $header ] );

        return $this;
    }

    public function with_body(string $body): Response {
        $this->body = $body;

        return $this;
    }

    public function body(): string {
        return $this->body;
    }

    public function status(): int {
        return $this->status;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function cookies(): Cookies {
        return $this->cookies;
    }
}
