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

namespace puffin\managed;

/**
 *
 * @author Alessio
 */
interface Resource {

    /**
     * Unique URI of the resource, often in the format of [$resourceClass:/$slug/$id]
     * @return string
     */
    public function uri(): string;

    /**
     * Class of the resource
     * @return ResourceClass
     */
    public function resource_class(): ResourceClass;

    /**
     * Value of the resource
     * @param string $name
     * @return mixed
     */
    public function value(string $name): mixed;

    /**
     *
     * @return array
     */
    public function links(): array;

    /**
     *
     * @param Resource $content
     * @param string $role
     * @return void
     */
    public function link(Resource $content, string $role): void;

    /**
     *
     * @param Resource|string $content
     * @return bool
     */
    public function unlink(Resource|string $content): bool;
}
