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
interface AccessPolicy {

    /**
     * Should allow the act
     * @param Resource|Grant $agent either a resource (like a User) or a grant like ('*.admin')
     * @param string $act act name, or * for wildcard
     * @return bool true if allowed
     */
    public function should_allow(Resource|Grant $agent, string $act): bool;

    /**
     * Should allow the act
     * @param Resource|Grant $agent either a resource (like a User) or a grant like ('*.admin')
     * @param string $act act name, or * for wildcard
     * @return bool true if denied
     */
    public function should_deny(Resource|Grant $agent, string $act): bool;

    /**
     * Should allow the act
     * @param Resource|Grant $agent either a resource (like a User) or a grant like ('*.admin')
     * @param string $act act name, or * for wildcard
     * @return bool true if forwarded to the target
     */
    public function should_forward(Resource|Grant $agent, string $act): bool;

    /**
     * Resulting policy for the query
     * @param Resource|Grant $agent
     * @param string $act
     * @return string allow|deny|forward|unset|test
     */
    public function query_policy(Resource|Grant $agent, string $act): string;

    /**
     * Allow resource or grant to perform the act
     * @param Resource|Grant $agent
     * @param string $act
     * @return void
     */
    public function allow(Resource|Grant $agent, string $act, bool $last = false): void;

    /**
     * Deny resource or grant to perform the act
     * @param Resource|Grant $agent
     * @param string $act
     * @return void
     */
    public function deny(Resource|Grant $agent, string $act, bool $last = false): void;

    /**
     * Forward resource or grant to perform the act to the detailed specification
     * @param Resource|Grant $agent
     * @param string $act
     * @return void
     */
    public function forward(Resource|Grant $agent, string $act, bool $last = false): void;

    /**
     * Serialize the access policy for storage
     * @return mixed
     */
    public function serialize(): mixed;

}
