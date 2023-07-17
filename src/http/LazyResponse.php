<?php

/*
 * Copyright 2021 alessioferri.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace puffin\http;

use puffin\http\session\Cookies;

/**
 * LazyResponse delay body presentation until the last possible moment
 *
 * @author alessioferri
 */
class LazyResponse implements Response {

    private $http_code;
    private $headers;
    private $cookies;
    private $generator;

    /**
     *
     * @param int $http_code
     * @param array $headers
     * @param callable|null $generator
     */
    public function __construct(int $http_code = 200, array $headers = [], ?callable $generator = null) {
        $this->http_code = $http_code;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->generator = $generator;
        $this->cookies = Cookies::empty();
    }

    public function body(): string {
        if ( $this->generator === null ) {
            return '';
        }
        return ($this->generator)();
    }

    public function headers(): array {
        return $this->headers;
    }

    public function status(): int {
        return $this->http_code;
    }

    public function with_body(string $body): Response {
        $this->generator = function () use ($body): string {
            return $body;
        };

        return $this;
    }

    public function with_header(string $header, string $value): Response {
        $this->headers[ $header ] = $value;

        return $this;
    }

    public function with_headers(array $headers): Response {
        $this->headers = $headers;

        return $this;
    }

    public function with_status(int $http_code): Response {
        $this->http_code = $http_code;

        return $this;
    }

    public function without_header(string $header): Response {
        unset( $this->headers[ $header ] );

        return $this;
    }

    public function cookies(): Cookies {
        return $this->cookies;
    }
}
