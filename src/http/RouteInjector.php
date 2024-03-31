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
 * Description of RoutesProtector
 *
 * @author Alessio
 */
class RouteInjector {

    private $filters;

    public function __construct() {
        $this->filters = [];
    }

    private function to_capacity(array $base, int $index): array {
        while ( count( $base ) <= $index ) {
            $base[] = [];
        }

        return $base;
    }

    public function add_filter(string|int|iterable $methods, string $route, callable $callable): self {
        if ( is_iterable( $methods ) ) {
            foreach ( $methods as $method ) {
                $this->add_filter( $method, $route, $callable );
            }

            return $this;
        }

        if ( is_string( $methods ) ) {
            $methods = explode( ',', $methods );

            foreach ( $methods as $method ) {
                if ( is_string( $method ) ) {
                    $method = HTTP::method_id( $method );
                }
                $this->add_filter( $method, $route, $callable );
            }

            return $this;
        }

        $method = $methods;
        if ( ! isset( $this->filters[ $method ] ) ) {
            $this->filters[] = $this->to_capacity( $this->filters, $method );
        }

        if ( ! isset( $this->filters[ $method ][ $route ] ) ) {
            $this->filters[ $method ][ $route ] = [];
        }
        $this->filters[ $method ][ $route ][] = $callable;

        return $this;
    }

    public function run_filters(callable $callable, string $route, Request $request, array $args): Response {
        $method = $request->method();
        if ( ! isset( $this->filters[ $method ][ $route ] ) ) {
            return $callable( $request, $args );
        }

        // Lock current filters
        $filters = $this->filters[ $method ][ $route ];
        foreach ( $filters as $filter ) {
            $response = $filter( $request, $route, $args );

            if ( $response !== null && $response instanceof Response ) {
                return $response;
            }
        }

        return $callable( $request, $args );
    }

}
