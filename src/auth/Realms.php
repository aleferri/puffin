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

namespace puffin\auth;

use puffin\http\RouteInjector;

/**
 * Description of Realms
 *
 * @author Alessio
 */
class Realms {

    private $list;
    private $authenticator;

    public function __construct(Authenticator $authenticator) {
        $this->list          = [];
        $this->authenticator = $authenticator;
    }

    public function register(Realm $realm) {
        $this->list[] = $realm;
    }

    public function realms(): array {
        return $this->list;
    }

    public function realm(string $slug): ?Realm {
        foreach ( $this->list as $entry ) {
            if ( $slug === $entry->slug() ) {
                return $entry;
            }
        }

        return null;
    }

    public function watch_routes(string $slug, RouteInjector $injector) {
        $realm = $this->realm( $slug );

        if ( $realm === null ) {
            return false;
        }

        $guardian = new RealmGuardian( $realm, $this->authenticator );

        $callable = [ $guardian, 'filter' ];

        foreach ( $realm->protected_routes() as $selector ) {
            [ $methods, $route ] = $selector;

            $injector->add_filter( $methods, $route, $callable );
        }

        return true;
    }

}
