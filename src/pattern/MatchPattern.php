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

namespace puffin\pattern;

/**
 * Description of MatchPattern
 *
 * @author Alessio
 */
class MatchPattern {

    public static function match(string $string, string $pattern) {
        $params = [];

        //Adapted from flight-php matching algorithm, original copyright is attributed to the mantainer of the flight-php repository and his contributors
        if ( '/*' !== $pattern && $pattern !== $string ) {
            $last_char = substr( $pattern, -1 );

            $regex_replace = str_replace( [ ')', '/*' ], [ ')?', '(/?|/.*?)' ], $pattern );

            $replace_callback = function (array $matches) use (&$params): string {
                $params[ $matches[ 1 ] ] = null;
                if ( isset( $matches[ 3 ] ) ) {
                    return '(?P<' . $matches[ 1 ] . '>' . $matches[ 3 ] . ')';
                }

                return '(?P<' . $matches[ 1 ] . '>[^/\?]+)';
            };

            $regex = preg_replace_callback( '#@([\w]+)(:([^/\(\)]*))?#', $replace_callback, $regex_replace );

            // Fix trailing slash
            if ( '/' === $last_char ) {
                $regex .= '?';
            } else {
                $regex .= '/?';
            }

            $matches = [];
            $result = preg_match( '#^' . $regex . '(?:\?.*)?$#', $string, $matches );

            if ( ! $result ) {
                return [ false, [] ];
            }

            foreach ( $params as $k => $v ) {
                $params[ $k ] = ( isset( $matches[ $k ] ) ) ? urldecode( $matches[ $k ] ) : null;
            }

            $params = array_values( $params );
        }

        return [ true, $params ];
    }

}
