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
 * Description of XMLBody
 *
 * @author Alessio
 */
class XMLBody implements RequestBody {

    private $body;
    private $document;

    public function __construct(string|\SimpleXMLElement $body) {
        if ( is_string( $body ) ) {
            $this->body = $body;
            $this->document = simplexml_load_string( $body );
        } else {
            $this->body = $body->asXML();
            $this->document = $body;
        }
    }

    public function parse(Decoder ...$chain): mixed {
        $content = $this->document;

        foreach ( $chain as $decoder ) {
            $content = $decoder->decode( $decoder );
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
