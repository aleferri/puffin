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

namespace puffin\io\filesystem;

/**
 * Description of UploadedFile
 *
 * @author Alessio
 */
class UploadedFile implements File {

    private $title;
    private $key;
    private $temp_name;
    private $path;
    private $size;
    private $error;

    public function __construct(string $title, string $key, string $temp_name, string $path, int $size, int $error) {
        $this->title = $title;
        $this->key = $key;
        $this->temp_name = $temp_name;
        $this->path = $path;
        $this->size = $size;
        $this->error = $error;
    }

    public function title(): string {
        return $this->title;
    }

    public function key(): string {
        return $this->key;
    }

    public function name(): string {
        return $this->temp_name;
    }

    public function mime(): string {
        return \mime_content_type( $this->path );
    }

    public function path(): string {
        return $this->path;
    }

    public function size(): int {
        return $this->size;
    }

    public function data(): string {
        return file_get_contents( $this->path );
    }
}
