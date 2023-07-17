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

namespace puffin\http\webfinger;

use puffin\http\Response;

/**
 *
 * @author Alessio
 */
interface WebFingerResponse extends Response {

    /**
     * Subject in resource-class:resource@domain format
     * @return string
     */
    public function subject(): string;

    /**
     * List of aliases
     * @return array
     */
    public function aliases(): array;

    /**
     * List of object properties
     * @return array
     */
    public function properties(): array;

    /**
     * List of links for the object
     * @return array<Link>
     */
    public function links(): array;

    /**
     *
     * @param array $properties
     * @return WebFingerResponse
     */
    public function with_properties(array $properties): WebFingerResponse;

    /**
     *
     * @param array $links
     * @return WebFingerResponse
     */
    public function with_links(array $links): WebFingerResponse;
}
