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

namespace puffin\managed;

/**
 * Description of StaticScope
 *
 * @author Alessio
 */
class StaticScope implements Scope {

    /**
     *
     * @var Resource
     */
    private $agent;

    /**
     *
     * @var array<Resource>
     */
    private $resources;

    public function __construct(Resource $agent) {
        $this->agent = $agent;
        $this->resources = [];
    }

    public function register(Resource $resource) {
        $this->resources[ $resource->uri() ] = $resource;
    }

    public function actions_for(string $resource): ?array {
        return [];
    }

    public function agent(): Resource {
        return $this->agent;
    }

    public function collections(): array {
        return [];
    }

    public function exists(string $resource): bool {
        return isset( $this->resources[ $resource ] );
    }

    public function query(string $resource): ?Resource {
        return $this->resources[ $resource ] ?? null;
    }

    public function teleports(string $scope): array {
        return [];
    }
}
