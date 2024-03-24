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

namespace puffin\log;

use plog\Logger;
use plog\LoggerHelper;
use puffin\io\Sink;
use puffin\io\NullSink;
use puffin\io\FileSink;

/**
 * Description of LoggerSink
 *
 * @author Alessio
 */
class LoggerSink implements Logger {

    /**
     * Create a none logger
     * @return Logger
     */
    public static function none(): Logger {
        $sink = new NullSink();

        return new self( $sink, \LOG_INFO );
    }

    /**
     * Create a file backed logger
     * @param string $path
     * @return Logger
     */
    public static function file(string $path): Logger {
        $sink = new FileSink( $path );

        return new self( $sink, \LOG_INFO );
    }

    use LoggerHelper;

    private $sink;
    private $filter;

    public function __construct(Sink $sink, int $filter) {
        $this->sink = $sink;
        $this->filter = $filter;
    }

    public function log(int $level, string $message, array $info = []): void {
        if ( $level > $this->filter ) {
            return;
        }
        $formatted = $this->interpolate( $message, $info );
        $this->sink->writeln( $formatted );
    }

    public function flush(): void {
        $this->sink->flush();
    }
}
