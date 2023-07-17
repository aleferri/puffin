<?php

/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace puffin\http\webfinger;

use puffin\http\Response;
use puffin\http\session\Cookies;

/**
 * Description of WebFingerResponseSimple
 *
 * @author Alessio
 */
class WebFingerResponseSimple implements WebFingerResponse {

    private $content;
    private $headers;

    public function __construct(array $content, array $headers) {
        $this->content = $content;
        $this->headers = $headers;
    }

    public function subject(): string {
        return $this->content[ 'subject' ];
    }

    public function aliases(): array {
        return $this->content[ 'aliases' ];
    }

    public function links(): array {
        return $this->content[ 'links' ];
    }

    public function properties(): array {
        return $this->content[ 'properties' ];
    }

    public function body(): string {
        return json_encode( $this->content );
    }

    public function cookies(): Cookies {
        return null;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function status(): int {
        return 200;
    }

    public function with_links(array $links): WebFingerResponse {
        $content = $this->content;
        $content[ 'links' ] = $links;

        return new WebFingerResponseSimple( $content, $this->headers );
    }

    public function with_properties(array $properties): WebFingerResponse {
        $content = $this->content;
        $content[ 'properties' ] = $properties;

        return new WebFingerResponseSimple( $content, $this->headers );
    }

    public function with_body(string $body): Response {
        return new \puffin\http\SimpleResponse( 200, $this->headers, $body );
    }

    public function with_header(string $header, string $value): Response {
        $headers = $this->headers;

        $headers[ $header ] = $value;

        return $this->with_headers( $headers );
    }

    public function with_headers(array $headers): Response {
        return new self( $this->content, $headers );
    }

    public function with_status(int $http_code): Response {
        return new puffin\http\SimpleResponse( $http_code, $this->headers, json_encode( $this->content ) );
    }

    public function without_header(string $header): Response {
        $headers = $this->headers;

        unset( $headers[ $header ] );

        return $this->with_headers( $headers );
    }
}
