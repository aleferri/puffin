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

use puffin\http\Request;
use puffin\http\Response;
use puffin\http\HTTPServer;
use puffin\pattern\MatchPattern;

/**
 * Description of Realms
 *
 * @author Alessio
 */
class Realms {

    private $list;

    public function __construct() {
        $this->list = [];
    }

    public function register(Realm $realm) {
        $this->list[] = $realm;
    }

    public function realms(): array {
        return $this->list;
    }

    private function find_realm_of(string $uri, array $params): ?Realm {
        foreach ( $this->list as $realm ) {
            $routes = $realm->guarded_routes();

            foreach ( $routes as $route ) {
                [ $ok, $params ] = MatchPattern::match( $route, $uri );

                if ( $ok ) {
                    return $realm;
                }
            }
        }

        return null;
    }

    public function prefilter_routes(Request $request, Login $login, array $params): ?Response {
        $realm = $this->find_realm_of( $request->uri() );

        if ( $realm === null || $realm->is_authenticated( $login, $params, $request->uri() ) ) {
            return null;
        }

        if ( $realm instanceof RealmLoginable ) {
            $maybe_portal = $realm->authenticate( $login );

            if ( $maybe_portal === null ) {
                return HTTPServer::deny();
            }

            $maybe_redirect = $maybe_portal->default_route( $login );

            if ( $maybe_redirect === null ) {
                return HTTPServer::deny();
            }

            return HTTPServer::redirect( $maybe_redirect );
        }

        return HTTPServer::deny();
    }
}
