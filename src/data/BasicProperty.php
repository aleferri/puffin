<?php

/*
 * Copyright 2020 Alessio.
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

namespace puffin\data;

/**
 * Description of BasicProperty
 *
 * @author Alessio
 */
class BasicProperty implements Property {

    private $name;
    private $tags;

    public function __construct(string $name, array $tags) {
        $this->name = $name;
        $this->tags = $tags;
    }

    public function name(): string {
        return $this->name;
    }

    public function tag_by_name(string $tag_name): ?Tag {
        foreach ( $this->tags as $tag ) {
            if ( $tag->name () == $tag_name ) {
                return $tag;
            }
        }
        return null;
    }

    public function tags(): array {
        return $this->tags;
    }

}
