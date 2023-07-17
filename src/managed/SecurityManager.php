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

use puffin\auth\Grant;

/**
 *
 * @author Alessio
 */
interface SecurityManager {

    /**
     * Calculate policy for the resource given the agent grants
     * @param Resource $agent
     * @param string $act
     * @param Resource $object
     * @return array
     */
    public function agent_can(Resource $agent, string $act, Resource|string $object): bool;

    /**
     * Access policy of the specified resource
     * @param Resource|string $resource
     * @return AccessPolicy
     */
    public function policy_of(Resource|string $resource): AccessPolicy;

    /**
     * List all grants for a resource
     * @param Resource|string $resource
     * @return Grant
     */
    public function grants_of(Resource|string $resource): Grant;

    /**
     * Give grant to a resource
     * @param Resource|string $resource
     * @param Grant $grant
     * @return bool
     */
    public function give(Resource|string $resource, Grant $grant): bool;

    /**
     * Give grant to a resource on another resource
     * @param Resource|string $resource
     * @param Grant $grant
     * @param Resource|string $target
     * @return bool
     */
    public function give_on(Resource|string $resource, Grant $grant, Resource|string $target): bool;

}
