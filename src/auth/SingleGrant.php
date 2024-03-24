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

namespace puffin\auth;

/**
 * Description of SingleGrant
 *
 * @author Alessio
 */
class SingleGrant implements Grant {

    private $grant;

    public function __construct(string $grant) {
        $this->grant = $grant;
    }

    public function id(): string {
        return $this->grant;
    }

    public function compose(Grant $g): Grant {
        if ( $g instanceof SingleGrant ) {
            return new GrantsList( [ $this, $g->grant ] );
        }

        if ( $g instanceof GrantsList ) {
            $e = $g->flatten();
            $e[] = $this;

            return new GrantsList( $e );
        }

        throw new IllegalGrantCombination();
    }

    public function for_context(string $context): Grant {
        if ( $context === '*' ) {
            return $this;
        }

        if ( str_contains( $this->grant, '*.' ) ) {
            return new SingleGrant( str_replace( '*.', $context . '.', $this->grant ) );
        }

        return new GrantsList( [] );
    }

    public function includes(Grant $g): bool {
        if ( $g instanceof SingleGrant ) {
            return $g->grant === $this->grant || '*.*' === $this->grant;
        }

        return false;
    }

    public function flatten(): array {
        return [ $this ];
    }

    public function serialize(): mixed {
        return $this->grant;
    }

    public function grant(): string {
        return $this->grant;
    }

    public function to_string(): string {
        return $this->grant;
    }
}
