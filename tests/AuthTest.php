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
use \puffin\auth\BitmaskGrant;

final class AuthTest extends TestCase {

    public function testCompose(): void {
        $grant = new BitmaskGrant( 1, '*' );
        $other = new BitmaskGrant( 2, '*' );

        $combined = $grant->compose( $other );

        $this->assertEquals( $combined->serialize(), 3 );
    }

    public function testIncludes(): void {
        $grant = new BitmaskGrant( 7, '*' );
        $other = new BitmaskGrant( 3, '*' );

        $this->assertEquals( $grant->includes( $other ), true );
    }

    public function testACL(): void {
        $acl = new \puffin\auth\AccessList();

        $exec = new BitmaskGrant( 4, '*' );
        $read = new BitmaskGrant( 2, '*' );

        $acl->allow( $exec );
        $acl->deny( $read );

        $test1 = new BitmaskGrant( 5, '*' );
        $test2 = $exec->compose( $read, '*' );
        $test3 = new BitmaskGrant( 4, '*' );
        $test4 = new BitmaskGrant( 2, '*' );

        $this->assertTrue( $acl->has_access( $test1 ) );
        $this->assertTrue( $acl->has_access( $test3 ) );
        $this->assertFalse( $acl->has_access( $test2 ) );
        $this->assertFalse( $acl->has_access( $test4 ) );
    }

}
