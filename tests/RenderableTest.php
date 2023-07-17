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
use \puffin\template\RenderableInclude;
use \puffin\http\RenderableResponse;
use \puffin\http\ForwardResponse;

final class RenderableTest extends TestCase {

    public function testRenderable(): void {

        $include = new RenderableInclude( 'tests/example_include.php' );
        $text = $include->render();
        $source = $include->as_source();

        $this->assertEquals( $source->next(), 'Ciao' );
        $this->assertEquals( $text, 'Ciao' );
    }

    public function testRenderableResponse(): void {
        $include = new RenderableInclude( 'tests/example_include.php' );

        $response = new RenderableResponse( 200, [], $include );
        $response->with_arg( 'expr', 'Happy Easter' );

        $this->assertEquals( $response->body(), 'Happy Easter' );
    }

    public function testForwardResponse(): void {
        $response = new ForwardResponse( 200, [], 'tests/example_include.php' );

        $this->assertEquals( $response->body(), 'Ciao' );
    }

}
