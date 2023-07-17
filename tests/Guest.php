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

/**
 * Description of Guest
 *
 * @author Alessio
 */
class Guest implements \puffin\managed\Resource {

    private $class;
    private $id;
    private $username;
    private $email;

    public function __construct(\puffin\managed\ResourceClass $class, int $id, string $username, string $email) {
        $this->id = $id;
        $this->class = $class;
        $this->username = $username;
        $this->email = $email;
    }

    public function uri(): string {
        return $this->class->homepage( $this );
    }

    public function value(string $name): mixed {
        if ( $name === 'id' ) {
            return $this->id;
        }
        if ( $name === 'slug' ) {
            return $this->username;
        }

        return null;
    }

    public function resource_class(): \puffin\managed\ResourceClass {
        return $this->class;
    }

    public function link(\puffin\managed\Resource $content, string $role): void {

    }

    public function links(): array {
        return [];
    }

    public function unlink(\puffin\managed\Resource|string $content): bool {
        return false;
    }
}
