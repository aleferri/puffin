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

interface Scope {

    /**
     * Current agent for the resource
     */
    public function agent(): Resource;

    /**
     * Check if resource exists in the scope or not
     */
    public function exists(string $resource): bool;

    /**
     * Query a specific resource
     * @return null if resource is not accessible
     */
    public function query(string $resource): ?Resource;

    /**
     * Return all collections visibles in the scope
     */
    public function collections(): array;

    /**
     * Query all actions for a resource
     * @return null if the resource is not accessible, an array otherwise
     */
    public function actions_for(string $resource): ?array;

    /**
     * Teleports to other scopes
     */
    public function teleports(string $scope): array;

}
