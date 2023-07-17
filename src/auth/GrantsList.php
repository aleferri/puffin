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
 * Description of GrantsList
 *
 * @author Alessio
 */
class GrantsList implements Grant {

    private $list;

    public function __construct(array $list) {
        $this->list = $list;
    }

    public function compose(Grant $g): Grant {
        if ( $g instanceof GrantsList ) {
            $list = $this->list;

            foreach ( $g->list as $grant ) {
                if ( ! $this->includes( $grant ) ) {
                    $list[] = $grant;
                }
            }

            return new GrantsList( $list );
        }

        if ( $g instanceof SingleGrant ) {
            $list = $this->list;
            $list[] = $g->grant();

            return new GrantsList( $list );
        }

        throw new IllegalGrantCombination();
    }

    public function includes(Grant $g): bool {
        if ( $g instanceof GrantsList ) {
            foreach ( $g->list as $grant ) {
                if ( ! in_array( $grant, $this->list ) ) {
                    return false;
                }
            }

            return true;
        }

        if ( $g instanceof SingleGrant ) {
            return in_array( $g->grant(), $this->list );
        }

        return false;
    }

    public function for_context(string $context): Grant {
        $list = [];

        foreach ( $this->list as $grant ) {
            if ( str_contains( $grant, $context . '.' ) ) {
                $list[] = $grant;
            }
        }

        return new GrantsList( $list );
    }

    public function flatten(): array {
        return $this->list;
    }

    public function serialize(): mixed {
        return json_encode( $this->list );
    }

    public function to_string(): string {
        return json_encode( $this->list );
    }

}
