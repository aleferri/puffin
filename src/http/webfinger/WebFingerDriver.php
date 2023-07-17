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

use puffin\managed\Scope;
use puffin\log\Logger;
use puffin\log\LoggerSink;

/**
 * Description of WebFingerDriver
 *
 * @author Alessio
 */
class WebFingerDriver implements WebFinger {

    private $domain;
    private $base_mount;
    private $log;

    public function __construct(string $domain, string $base_mount, ?Logger $logger = null) {
        $this->domain = $domain;
        $this->base_mount = $base_mount;
        $this->log = $logger;

        if ( $this->log === null ) {
            $this->log = LoggerSink::none();
        }
    }

    public function query(string $resource_uri, Scope $scope): ?WebFingerResponse {
        [ $kind, $url ] = explode( ':', $resource_uri );
        [ $resource_id, $domain ] = explode( '@', $url );

        $this->log->info( $resource_uri );

        if ( $domain !== $this->domain ) {
            return null;
        }

        $uri = $this->base_mount . $kind . '/' . $resource_id;

        $this->log->info( 'URI: {uri}', [ 'uri' => $uri ] );

        if ( !$scope->exists( $uri ) ) {
            return null;
        }

        $resource = $scope->query( $uri );

        $links = $resource->links();

        $content = [
            'subject' => $resource->uri(),
            'aliases' => [],
            'properties' => [],
            'links' => $links
        ];

        $headers = [
            'Content-Type' => 'application/json'
        ];

        return new WebFingerResponseSimple(
                $content,
                $headers
        );
    }
}
