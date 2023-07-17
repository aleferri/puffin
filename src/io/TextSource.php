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

namespace puffin\io;

/**
 *
 * @author Alessio
 */
class TextSource implements Source {

    private $text;

    public function __construct(string $text) {
        $this->text = $text;
    }

    /**
     * Next chunck of data
     * @return string next chunck
     */
    public function next(): string {
        return $this->text;
    }

    /**
     * Into dump the stream into a sink
     * @param Sink $sink
     */
    public function into(Sink $sink): void {
        $sink->write( $this->text );
    }

}
