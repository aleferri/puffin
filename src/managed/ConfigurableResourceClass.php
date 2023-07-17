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

namespace puffin\managed;

/**
 * Description of ConfigurableResourceClass
 *
 * @author Alessio
 */
class ConfigurableResourceClass implements ResourceClass {

    private $name;
    private $slug;
    private $access_policy;
    private $homepage_template;

    public function __construct(string $name, string $slug, AccessPolicyClass $access_policy, string $homepage_template = '{c_slug}/{id}') {
        $this->name = $name;
        $this->slug = $slug;
        $this->access_policy = $access_policy;
        $this->homepage_template = $homepage_template;
    }

    public function access_policy(): AccessPolicy {
        return $this->access_policy;
    }

    public function homepage(Resource $resource): string {
        $patterns = [
            '{id}', '{c_slug}', '{slug}', '{domain}'
        ];
        $replacements = [
            $resource->value( 'id' ),
            $this->slug,
            $resource->value( 'slug' ),
            $resource->value( 'domain' )
        ];

        return str_replace( $patterns, $replacements, $this->homepage_template );
    }

    public function name(): string {
        return $this->name;
    }

    public function slug(): string {
        return $this->slug;
    }
}
