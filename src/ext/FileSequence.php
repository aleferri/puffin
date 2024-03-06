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

namespace puffin\ext;

/**
 * Description of FileSequence
 *
 * @author Alessio
 */
class FileSequence implements Sequence {

    private $name;
    private $path;

    public function __construct(string $name, string $path) {
        $this->name = $name;
        $this->path = $path;
    }

    public function name(): string {
        return $this->name;
    }

    public function next(?callable $transaction): int {
        $file = fopen( $this->path, 'r+' );

        $b = flock( $file, LOCK_EX );
        while ( ! $b ) {
            $b = flock( $file, LOCK_EX );
        }

        $str = fgets( $file, 40 );
        if ( $str === null ) {
            $prev = 0;
        } else {
            $prev = intval( $str );
        }
        $next = $prev + 1;

        try {
            if ( $transaction !== null ) {
                $transaction( $next );
            }

            ftruncate( $file, 0 );
            fwrite( $file, $next . '' );
            fflush( $file );            // flush output before releasing the lock
            flock( $file, LOCK_UN );    // release the lock

            return $next;
        } catch ( \Throwable $ex ) {
            flock( $file, LOCK_UN );    // release the lock

            throw $ex;
        }
    }

}
