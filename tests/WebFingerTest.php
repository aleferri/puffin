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

use PHPUnit\Framework\TestCase;
use puffin\log\LoggerSink;
use puffin\io\FileSink;

include('Guest.php');

/**
 * Description of WebFingerTest
 *
 * @author Alessio
 */
class WebFingerTest extends TestCase {

    public function testSimpleRequest(): void {
        $temp = fopen( "logtest_webfinger.log", 'w' );
        $sink = new FileSink( $temp );

        $logger = new LoggerSink( $sink, LOG_INFO );

        $webfinger = new puffin\http\webfinger\WebFingerDriver( 'test.com', '/', $logger );

        $access_policy = new \puffin\managed\AccessPolicyClass( [ '*.*' => [ '*:exists|allow', '*:homepage|allow' ] ] );

        $users = new puffin\managed\ConfigurableResourceClass( 'users', 'users', $access_policy, '/{c_slug}/{slug}' );
        $accts = new puffin\managed\ConfigurableResourceClass( 'acct', 'acct', $access_policy, '/{c_slug}/{slug}' );

        $guest = new Guest( $users, 0, 'guest', 'guest@guest.it' );
        $manuel = new Guest( $accts, 1, 'manuel', 'manuel@guest.it' );

        $logger->info( 'RESOURCE: ' . $manuel->uri() );

        $scope = new \puffin\managed\StaticScope( $guest, '/' );
        $scope->register( $manuel );

        $response = $webfinger->query(
                'acct:manuel@test.com', $scope
        );

        $this->assertNotEquals( null, $response );
        $this->assertEquals( $manuel->uri(), $response->subject() );
    }
}
