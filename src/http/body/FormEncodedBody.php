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
 * Description of FormEncodedBody
 *
 * @author Alessio
 */
class FormEncodedBody implements RequestBody {

    private $body;
    private $form_data;
    private $files;

    public function __construct(string|array $body = '', array $files = []) {

        if ( is_string( $body ) ) {
            $this->body = $body;
            $this->form_data = \parse_url( $body );
        } else {
            $this->body = \http_build_query( $body );
            $this->form_data = $body;
        }

        $this->files = $files;
    }

    //put your code here
    public function parse(Decoder ...$chain): mixed {
        $content = $this->form_data;
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
