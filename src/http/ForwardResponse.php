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

use puffin\http\session\Cookies;

/**
 * Description of ForwardResponse
 *
 * @author Alessio
 */
class ForwardResponse implements Response {

    private $status;
    private $headers;
    private $include;
    private $cookies;

    public function __construct(int $status = 200, array $headers = [], string $include = '') {
        $this->status = $status;
        $this->headers = $headers;
        $this->include = $include;
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

    public function body(): string {
        ob_start();
        include( $this->include );

        return ob_get_clean();
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
