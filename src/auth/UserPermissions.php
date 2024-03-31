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
interface UserPermissions {

    /**
     * Applicant
     * @return string
     */
    public function applicant(): string;

    /**
     * Object
     * @return string
     */
    public function resource(): string;

    /**
     * Can read the content of the resource, fully or in part
     * @return bool
     */
    public function is_readable(): bool;

    /**
     * Readable sections of the resource
     * @return array
     */
    public function readable_sections(): array;

    /**
     * Can edit the content of the resource, fully or in part
     * @return bool
     */
    public function is_editable(): bool;

    /**
     * Editable sections of the resource
     * @return array
     */
    public function editable_sections(): array;

    /**
     * Can drop the resource
     * @return array
     */
    public function is_droppable(): array;

    /**
     * Can link the resource to another resource, all or parts of it, while keeping it private
     * @return bool
     */
    public function is_linkable(): bool;

    /**
     * Can know about the existence of the resource, this resource must be redacted when linked from other resources
     * @return bool
     */
    public function is_observable(): bool;

    /**
     * List a series of actions that are actionable on the resource
     * @return array
     */
    public function actions(): array;

}
