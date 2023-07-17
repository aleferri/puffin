<?php

/*
 * Copyright 2022 Alessio.
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

use puffin\template\Renderable;
use puffin\http\session\Cookies;

/**
 * Description of ForwardResponse
 *
 * @author Alessio
 */
class RenderableResponse implements Response {

    private $status;
    private $headers;
    private $renderable;
    private $args;
    private $cookies;

    public function __construct(int $status, array $headers, Renderable $renderable) {
        $this->status = $status;
        $this->headers = $headers;
        $this->renderable = $renderable;
        $this->args = [];
        $this->cookies = Cookies::empty();
    }

    public function with_status(int $http_code): Response {
        $this->status = $http_code;

        return $this;
    }

    public function with_headers(array $headers, bool $add = true): Response {
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
        return new SimpleResponse( $this->status, $this->headers, $body );
    }

    public function with_arg(string $key, $value): RenderableResponse {
        $this->args[ $key ] = $value;
        return $this;
    }

    public function without_arg(string $key): RenderableResponse {
        unset( $this->args[ $key ] );
        return $this;
    }

    public function body(): string {
        return $this->renderable->render( $this->args );
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
