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

namespace puffin\http\body;

/**
 *
 * @author Alessio
 */
class BinaryBody implements RequestBody {

    private $body;

    public function __construct( string $body ) {
        $this->body = $body;
    }

    public function parse( Decoder ...$chain ): mixed {
        $content = $this->body;
        foreach ( $chain as $decoder ) {
            $content = $chain->decode( $decoder );
        }

        return $content;
    }

    public function raw(): string {
        return $this->body;
    }

    public function uploads(): array {
        return [];
    }
}
