<?php

/*
 * Copyright 2021 alessioferri.
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

use PHPUnit\Framework\TestCase;
use puffin\auth\SingleGrant;
use puffin\managed\AccessPolicyClass;
use puffin\io\FileSink;
use puffin\log\LoggerSink;

final class AccessPolicyTest extends TestCase {

    public function testAllow(): void {
        $access_policy = new AccessPolicyClass( [] );
        $access_policy->deny( new SingleGrant( '*.*' ), '*:*', false );
        $access_policy->forward( new SingleGrant( '*.*' ), '[?self]:details', true );

        $this->assertEquals( 'test', $access_policy->query_policy( new SingleGrant( '*.page' ), 'details' ) );
    }

    public function testParse(): void {
        $temp = fopen( "logtest_accesspolicyclass.log", 'w' );
        $sink = new FileSink( $temp );

        $log = new LoggerSink( $sink, LOG_INFO );

        $test = [ '*.*' => [ '*:*|deny', '*:exists|allow', '*:homepage|allow' ] ];

        $access_policy = AccessPolicyClass::parse( json_encode( $test ), $log );

        $this->assertEquals( 'allow', $access_policy->query_policy( new SingleGrant( '*.guest' ), 'homepage' ) );
    }
}
