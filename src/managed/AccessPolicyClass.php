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
use puffin\log\Logger;
use puffin\log\LoggerSink;

/**
 * Description of AccessPolicyClass
 *
 * @author Alessio
 */
class AccessPolicyClass implements AccessPolicy {

    public static function parse(string $encoded, Logger $logger): self {
        $decoded = json_decode( $encoded, true );

        return new self( $decoded, $logger );
    }

    private $list;
    private $log;

    public function __construct(array $list, ?Logger $log = null) {
        $this->list = $list;
        $this->log = $log;

        if ( $this->log === null ) {
            $this->log = LoggerSink::none();
        }
    }

    private function set_policy(Grant $g, string $act, string $policy) {
        $all = $g->flatten();

        foreach ( $all as $grant ) {
            $name = $grant->to_string();
            if ( isset( $this->list[ $name ] ) ) {
                $this->list[ $name ][] = "{$act}|{$policy}";
            } else {
                $this->list[ $name ] = [ "{$act}|{$policy}" ];
            }
        }
    }

    private function split(Resource|Grant $agent): array {
        $grant = $agent;

        if ( $agent instanceof Resource ) {
            $grant = $agent->grants();
            $resource = $agent;
        } else {
            $resource = null;
        }

        return [ $grant, $resource ];
    }

    private function grant_of(Resource|Grant $agent): Grant {
        $grant = $agent;

        if ( $agent instanceof Resource ) {
            $grant = $agent->grants();
        }

        return $grant;
    }

    public function allow(Resource|Grant $agent, string $act, bool $last = false): void {
        $g = $this->grant_of( $agent );

        $policy = 'allow';

        if ( $last ) {
            $policy .= '.';
        }

        $this->set_policy( $g, $act, $policy );
    }

    public function deny(Resource|Grant $agent, string $act, bool $last = false): void {
        $g = $this->grant_of( $agent );

        $policy = 'deny';

        if ( $last ) {
            $policy .= '.';
        }

        $this->set_policy( $g, $act, $policy );
    }

    public function forward(Resource|Grant $agent, string $act, bool $last = false): void {
        $g = $this->grant_of( $agent );

        $policy = 'forward';

        if ( $last ) {
            $policy .= '.';
        }

        $this->set_policy( $g, $act, $policy );
    }

    private function poll_policy_of_key(string $target_act, array $list): string {
        $strenght = -1;
        $policy = 'unset';

        foreach ( $list as $rule ) {
            [ $left, $result ] = explode( '|', $rule );
            [ $condition, $act ] = explode( ':', $left );

            if ( $act !== $target_act && $act !== '*' ) {
                continue;
            }

            //act match

            if ( $condition === '*' && $strenght <= 0 ) {
                $strenght = 0;
                $policy = $result;
            }

            if ( $condition !== '*' ) {
                return 'test';
            }
        }

        return $policy;
    }

    private function poll_policy_of(Grant $flat_grant, string $target_act): string {

        $policy = 'unset';

        foreach ( $this->list as $key => $list ) {

            $this->log->info( '{key} => {list}', [ 'key' => $key, 'list' => json_encode( $list ) ] );

            if ( $key === '*.*' ) {
                continue;
            }

            if ( $flat_grant->name() === $key ) {
                $test = $this->poll_policy_of_key( $target_act, $list );
                if ( $test !== 'unset' ) {
                    return $test;
                }
            }
        }

        return $policy;
    }

    public function query_policy(Resource|Grant $agent, string $act): string {
        $g = $this->grant_of( $agent );

        $all = $g->flatten();

        $default_policy = $this->poll_policy_of_key( $act, $this->list[ '*.*' ] );

        $this->log->info( $default_policy );

        if ( str_ends_with( $default_policy, '.' ) ) {
            return substr( $default_policy, 0, -1 );
        }

        $policy = $default_policy;

        foreach ( $all as $grant ) {
            $query = $this->poll_policy_of( $grant, $act );

            $this->log->info( $query );

            if ( $query === 'unset' ) {
                continue;
            }

            if ( str_ends_with( $query, '.' ) ) {
                return substr( $query, 0, -1 );
            }

            if ( $query === 'forward' || $query === 'test' ) {
                $policy = $query;
            }

            if ( $policy !== 'forward' && $policy !== 'test' ) {
                $policy = $query;
            }
        }

        return $policy;
    }

    public function serialize(): mixed {
        return json_encode( $this->list );
    }

    public function should_allow(Resource|Grant $agent, string $act): bool {
        return 'allow' === $this->query_policy( $agent, $act );
    }

    public function should_deny(Resource|Grant $agent, string $act): bool {
        return 'deny' === $this->query_policy( $agent, $act );
    }

    public function should_forward(Resource|Grant $agent, string $act): bool {
        return 'forward' === $this->query_policy( $agent, $act );
    }
}
