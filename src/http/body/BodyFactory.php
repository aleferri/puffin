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

namespace puffin\http\body;

use puffin\http\HTTPMethod;
use puffin\io\filesystem\UploadedFile;

/**
 * Description of BodyFactory
 *
 * @author Alessio
 */
class BodyFactory {

    public const EMPTY_METHODS = [ 'HEAD', 'OPTION', 'GET', 'DELETE' ];
    public const FORM_ENCODED_TYPES = [ 'multipart/form-data', 'application/x-www-form-urlencoded' ];

    public static function handle_post(): RequestBody {
        $files = [];
        foreach ( $_FILES as $key => $data ) {
            $files[] = new UploadedFile( $data[ 'name' ], $key, $data[ 'tmp_name' ], $data[ 'full_path' ], $data[ 'size' ], $data[ 'error' ] );
        }

        $json = filter_input( \INPUT_POST, '_json' );
        if ( defined( 'HTTP_JSON_FIELD_IN_POST' ) && is_string( $json ) ) {
            return new JSONBody( $json, $files );
        }

        return new FormEncodedBody( $_POST, $files );
    }

    public static function of(HTTPMethod $method, array $headers): ?RequestBody {
        if ( in_array( $method->name, self::EMPTY_METHODS ) || !isset( $headers[ 'Content-Type' ] ) ) {
            return null;
        }

        $content_type = $headers[ 'Content-Type' ];

        if ( $content_type === 'application/json' ) {
            return new JSONBody( file_get_contents( 'php://input' ) );
        }

        if ( $content_type === 'application/xml' ) {
            return new XMLBody( file_get_contents( 'php::/input' ) );
        }

        if ( $method->name === 'POST' ) {
            if ( ini_get( 'enable_post_data_reading' ) ) {
                return self::handle_post();
            }

            return new FormEncodedBody( file_get_contents( 'php://input' ), [] );
        }

        if ( in_array( $content_type, self::FORM_ENCODED_TYPES ) ) {
            return new FormEncodedBody( file_get_contents( 'php://input' ) );
        }

        return new BinaryBody( file_get_contents( 'php://input' ) );
    }
}
