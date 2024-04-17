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

namespace puffin\http;

/**
 * Description of Route
 *
 * @author Alessio
 */
class Route {

    private $method;
    private $pattern;
    private $handler;
    private $metadata;
    private $filters;

    public function __construct(int $method, string $pattern, callable $handler, array $metadata = []) {
        $this->method   = $method;
        $this->pattern  = $pattern;
        $this->handler  = $handler;
        $this->metadata = $metadata;
        $this->filters  = [];
    }

    public function method(): int {
        return $this->method;
    }

    public function pattern(): string {
        return $this->pattern;
    }

    public function handler(): callable {
        return $this->handler;
    }

    public function metadata(): array {
        return $this->metadata;
    }

    public function set(string $key, mixed $value): void {
        $this->metadata[ $key ] = $value;
    }

    public function get(string $key, mixed $default = null): mixed {
        return $this->metadata[ $key ] ?? $default;
    }

    public function exists(string $key): bool {
        return isset( $this->metadata[ $key ] );
    }

    public function add_filter(string $event, string $fname, callable $filter) {
        $queue           = $this->filters[ $event ] ?? [];
        $queue[ $fname ] = $filter;

        $this->filters[ $event ] = $queue;
    }

    public function remove_filter(string $event, string $fname) {
        $queue = $this->filters[ $event ] ?? [];
        unset( $queue[ $fname ] );

        $this->filters[ $event ] = $queue;
    }

    public function filters(string $event) {
        return $this->filters[ $event ] ?? [];
    }

}
