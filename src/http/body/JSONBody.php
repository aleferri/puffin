<?php

/*
 * Copyright 2023 Alessio.
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

namespace puffin\http\body;

/**
 * Description of JSONBody
 *
 * @author Alessio
 */
class JSONBody implements RequestBody {

    private $body;
    private $json;
    private $files;

    public function __construct(string $body, array $files = []) {
        $this->body = $body;
        $this->json = \json_decode( $this->body );
        $this->files = $files;
    }

    public function parse(Decoder ...$chain): mixed {
        $content = $this->json;
        foreach ( $chain as $decoder ) {
            $content = $decoder->decode( $content );
        }

        return $content;
    }

    public function raw(): string {
        return $this->body;
    }

    public function uploads(): array {
        return $this->files;
    }
}