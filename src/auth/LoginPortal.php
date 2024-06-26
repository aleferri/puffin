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

/**
 *
 * @author Alessio
 */
interface LoginPortal {

    /**
     * Slug of portal
     * @return string
     */
    public function slug(): string;

    /**
     * Name of portal
     * @return string
     */
    public function name(): string;

    /**
     * LoginPortal permissions with regards to current user
     * @param Login $login
     * @return UserPermissions
     */
    public function permissions(Login $login): UserPermissions;

    /**
     * List of routes
     * @return array
     */
    public function routes(): array;

    /**
     * Return preferred login route for the current login
     * @param Login $login
     * @return string|null
     */
    public function default_route(Login $login): ?string;

    /**
     * Force login
     * @return Login
     */
    public function login(): Login;

}
