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

namespace puffin\http;

use puffin\auth\Login;

/**
 * Description of AuthenticatedRequest
 *
 * @author Alessio
 */
class AuthenticatedRequest extends SimpleRequest {

    public function __construct(Request $base, Login $login) {
        parent::__construct(
            $base->method_id(), $base->uri(), $base->query(), $base->headers(), $base->body(), $base->cookies()
        );
        $this->attributes()[ 'login' ] = $login;
    }

    public function is_authenticated(): bool {
        $attributes = $this->attributes();

        return isset( $attributes[ 'login' ] );
    }

    public function authentication(): ?Login {
        if ( $this->is_authenticated() ) {
            return ($this->attributes())[ 'login' ];
        }

        return null;
    }

}
