<?php

declare(strict_types = 1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\http;

use puffin\http\body\RequestBody;
use puffin\http\session\Cookies;

class SimpleRequest implements Request {

    /**
     * @var string $uri
     */
    private $uri;

    /**
     * @var int $uri
     */
    private $method;

    /**
     * @var \puffin\collections\HashMap $uri
     */
    private $query;

    /**
     * @var array $headers
     */
    private $headers;

    /**
     * @var RequestBody $content
     */
    private $body;

    /**
     * @var RequestOrigin $origin
     */
    private $origin;

    /**
     * @var Cookies $cookies
     */
    private $cookies;

    public function __construct(HTTPMethod $method, string $uri, array $query, array $headers, RequestOrigin $origin, Cookies $cookies, ?RequestBody $body = null) {
        $this->method = $method;
        $this->uri = $uri;
        $this->query = new \puffin\collections\HashMap( $query );
        $this->headers = $headers;
        $this->body = $body;
        $this->origin = $origin;
        $this->cookies = $cookies;
    }

    public function uri(): string {
        return $this->uri;
    }

    public function method(): int {
        return $this->method->id;
    }

    public function method_name(): string {
        return $this->method->name;
    }

    public function is_emulated_method(): bool {
        return $this->method->request_method !== $this->method->name && HTTP::is_standard_method( $this->method->name );
    }

    public function is_custom_method(): bool {
        return $this->method->id === HTTP::METHOD_CUSTOM;
    }

    public function query(): \ArrayAccess {
        return $this->query;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function body(): ?RequestBody {
        return $this->content;
    }

    public function origin(): RequestOrigin {
        return $this->origin;
    }

    public function cookies(): Cookies {
        return $this->cookies;
    }
}
