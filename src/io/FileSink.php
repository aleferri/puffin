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
 * Description of FileSink
 *
 * @author Alessio
 */
class FileSink implements Sink {

    private $file;

    public function __construct(mixed $file) {
        $this->file = $file;
    }

    public function flush(): void {
        \fflush ( $this->file );
    }

    public function write(string $text): void {
        \fwrite ( $this->file, $text );
    }

    public function writeln(string $text): void {
        \fwrite ( $this->file, $text . "\n" );
    }

}
