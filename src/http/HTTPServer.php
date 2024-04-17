<?php

/*
 * Copyright 2022 Alessio.
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

namespace puffin\http;

use function puffin\lambda\get_any;
use puffin\http\session\Cookies;

/**
 * Description of HTTPServer
 *
 * @author Alessio
 */
class HTTPServer {

    public const EMULATE_METHOD_HEADER       = 'X-EMULATE-METHOD';
    public const OVERRIDE_HTTP_METHOD_HEADER = 'X-HTTP-Method-Override';
    public const OVERRIDE_METHOD_HEADER      = 'X-Method-Override';
    public const CUSTOM_METHOD_HEADER        = 'X-CUSTOM-METHOD';

    public static function current_origin(): RequestOrigin {
        $ip         = get_any( $_SERVER, 'UNKNOWN', 'HTTP_CLIENT_IP', 'REMOTE_ADDR' );
        $user_agent = $_SERVER[ 'HTTP_USER_AGENT' ];

        return new RequestOrigin( $ip, $user_agent );
    }

    public static function resolve_method(string $request_method, array $headers): HTTPMethod {
        $method = HTTPMethod::of( $request_method );

        if ( defined( 'HTTP_EMULATED_METHODS' ) ) {
            $override_header = self::EMULATE_METHOD_HEADER;

            if ( ! isset( $headers[ $override_header ] ) ) {
                $override_header = self::OVERRIDE_HTTP_METHOD_HEADER;
            }

            if ( ! isset( $headers[ $override_header ] ) ) {
                $override_header = self::OVERRIDE_METHOD_HEADER;
            }

            if ( ! isset( $headers[ $override_header ] ) ) {
                return $method;
            }

            $method = HTTPMethod::emulate( \strtoupper( $headers[ $override_header ] ), $request_method );
        }

        if ( defined( 'HTTP_CUSTOM_METHODS' ) ) {
            if ( isset( $headers[ self::CUSTOM_METHOD_HEADER ] ) ) {
                $method = HTTPMethod::custom( \strtoupper( $headers[ self::CUSTOM_METHOD_HEADER ] ), $request_method );
            }
        }

        return $method;
    }

    public static function accept(): Request {
        $request_method = $_SERVER[ 'REQUEST_METHOD' ] ?? 'GET';
        $request_uri    = $_SERVER[ 'REQUEST_URI' ] ?? '/';

        $headers = apache_request_headers();

        $method = self::resolve_method( $request_method, $headers );

        if ( $method->id === null ) {
            exit();
        }

        $request_body = body\BodyFactory::of( $method, $headers );

        return new SimpleRequest(
            $method, $request_uri, $_GET, $headers, self::current_origin(), Cookies::recover(), $request_body,
        );
    }

    public static function accept_fake(string $request_method, string $request_uri, array $headers, array $query): Request {
        $method = self::resolve_method( $request_method, $headers );

        if ( $method->id === null ) {
            exit();
        }

        $request_body = body\BodyFactory::of( $method, $headers );
        $origin       = new RequestOrigin( '127.0.0.1', 'none' );

        return new SimpleRequest(
            $method, $request_uri, $query, $headers, $origin, Cookies::recover(), $request_body,
        );
    }

    public static function send(Response $r): void {
        http_response_code( $r->status() );
        foreach ( $r->headers() as $k => $v ) {
            header( "{$k}: $v", true );
        }

        $cookies = $r->cookies();
        foreach ( $cookies as $cookie ) {
            setcookie(
                $cookie->name, $cookie->value, $cookie->expiration, $cookie->options->path, $cookie->options->domain,
                $cookie->options->secure, $cookie->options->httponly
            );
        }

        echo $r->body();
    }

    /**
     * JSON response
     * @param array $body content of json
     * @param int $http_code code to send
     * @param array $headers additional headers
     * @return Response resulting response
     */
    public static function json(array $body, int $http_code = 200, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'application/json';

        return new SimpleResponse( $http_code, $headers, \json_encode( $body ) );
    }

    /**
     * HTML response
     * @param string $body body of the html
     * @param int $http_code http code to send
     * @param array $headers additional headers
     * @return Response resulting response to send
     */
    public static function html(string $body, int $http_code = 200, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'text/html';

        return new SimpleResponse( $http_code, $headers, $body );
    }

    /**
     * XML response
     * @param string $body body of the html
     * @param int $http_code http code to send
     * @param array $headers additional headers
     * @return Response resulting response to send
     */
    public static function xml(string $body, int $http_code, array $headers = []): Response {
        $headers[ 'Content-Type' ] = 'application/xml';

        return new SimpleResponse( $http_code, $headers, $body );
    }

    /**
     * Return file as a response
     * @param string $body body of the file
     * @param string $mime mime of the file
     * @param string $filename filename to present for the user
     * @param array $headers base headers, default empty, all required header will be overwritten
     * @return Response resulting response to send
     */
    public static function file(string $body, string $mime, string $filename = 'document', array $headers = []): Response {
        $headers[ 'Content-Control' ]           = 'public';
        $headers[ 'Content-Type' ]              = "{$mime};";
        $headers[ 'Content-Transfer-Encoding' ] = 'Binary';
        $headers[ 'Content-Length' ]            = strlen( $body );
        $headers[ 'Content-Disposition' ]       = "attachment; filename='{$filename}'";
        return new SimpleResponse( 200, $headers, $body );
    }

    /**
     * Static file serve
     * @param string $filename filename of the static file full path included
     * @return Response resulting response to send
     */
    public static function static_file(string $filename): Response {
        $basename                               = basename( $filename );
        $mime                                   = mime_content_type( $filename );
        $headers                                = [];
        $headers[ 'Content-Control' ]           = 'public';
        $headers[ 'Content-Type' ]              = "{$mime};";
        $headers[ 'Content-Transfer-Encoding' ] = 'Binary';
        $headers[ 'Content-Length' ]            = filesize( $filename );
        $headers[ 'Content-Disposition' ]       = "attachment; filename='{$basename}'";
        return new LazyResponse(
            200, $headers,
            function () use ($filename): string {
                return file_get_contents( $filename );
            }
        );
    }

    /**
     * Deny request for insufficient authorization
     * @param string $body
     * @return Response
     */
    public static function deny(string $body = ''): Response {
        return new SimpleResponse( 401, [], $body );
    }

    /**
     * Redirect browser to another location
     * @param string $location new location
     * @return Response resulting response
     */
    public static function redirect(string $location): Response {
        return new SimpleResponse( 301, [ 'Location' => $location ], '' );
    }

}
