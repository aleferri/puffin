<?php

/*
 * Copyright 2021 alessioferri.
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

class BitmaskGrant implements Grant {

    private static $EMPTY_GRANT = null;

    public static function empty_grant() {
        if ( self::$EMPTY_GRANT === null ) {
            self::$EMPTY_GRANT = new BitmaskGrant( 0, '*' );
        }

        return self::$EMPTY_GRANT;
    }

    private $mask;
    private $context;

    /**
     * Construct the BitmaskGrant
     * @param int $mask initial mask
     */
    public function __construct(int $mask, string $context) {
        $this->mask = $mask;
        $this->context = $context;
    }

    public function compose(Grant $g): Grant {
        if ( $g instanceof BitmaskGrant ) {
            if ( $g->context === $this->context ) {
                return new BitmaskGrant( $g->mask | $this->mask, $this->context );
            }
        }
        throw new IllegalGrantCombination();
    }

    public function includes(Grant $g): bool {
        if ( $g instanceof BitmaskGrant ) {
            return ( $this->mask & $g->mask ) !== 0;
        }
        return false;
    }

    public function for_context(string $context): Grant {
        if ( $context === $this->context ) {
            return $this;
        }

        return self::empty_grant();
    }

    public function flatten(): array {
        $list = [];

        $t = 1;

        while ( $t < (\PHP_INT_MAX - 1 ) ) {
            if ( $t & $this->mask ) {
                $list[] = new BitmaskGrant( $t, $this->context );
            }
            $t = $t << 1;
        }

        return $list;
    }

    public function serialize(): mixed {
        return $this->mask;
    }

    public function to_string(): string {
        return $this->context . '.' . $this->mask;
    }

}
