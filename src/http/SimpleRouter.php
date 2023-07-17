<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri, Mike Cao <mike@mikecao.com>
 * @license Apache-2.0
 */

namespace puffin\http;

class SimpleRouter implements Router {

    private $default;

    public function __construct(Response $default) {
        $this->default = $default;
    }

    public function route(Request $request, RouteCollection $collection): Response {
        if ( !$request->is_custom_method() ) {
            return $this->fast_route( $request, $collection );
        }

        $candidates = $collection->filter_by ( $request->method () );

        foreach ( $candidates as $candidate ) {
            [ $complex_pattern, $handler ] = $candidate;
            [ $method, $pattern ] = explode( ' ', $complex_pattern );
            [ $ok, $params ] = $this->match ( $request->uri (), $pattern );

            if ( $ok && $method === $request->method_name() ) {
                $injector = $collection->injector ();

                return $injector ( $handler, $request, $params );
            }
        }

        return $this->default;
    }

    public function fast_route(Request $request, RouteCollection $collection): Response {
        $candidates = $collection->filter_by ( $request->method () );

        foreach ( $candidates as $candidate ) {
            [ $pattern, $handler ] = $candidate;
            [ $ok, $params ] = $this->match ( $request->uri (), $pattern );

            if ( $ok ) {
                $injector = $collection->injector ();

                return $injector ( $handler, $request, $params );
            }
        }

        return $this->default;
    }

    private function match(string $uri, string $pattern): array {
        $params = [];

        //Adapted from flight-php matching algorithm, original copyright is attributed to the mantainer of the flight-php repository and his contributors
        if ( '/*' !== $pattern && $pattern !== $uri ) {
            $last_char = substr ( $pattern, -1 );

            $regex_replace = str_replace ( [ ')', '/*' ], [ ')?', '(/?|/.*?)' ], $pattern );

            $replace_callback = function(array $matches) use (&$params): string {
                $params[ $matches[ 1 ] ] = null;
                if ( isset ( $matches[ 3 ] ) ) {
                    return '(?P<' . $matches[ 1 ] . '>' . $matches[ 3 ] . ')';
                }

                return '(?P<' . $matches[ 1 ] . '>[^/\?]+)';
            };

            $regex = preg_replace_callback ( '#@([\w]+)(:([^/\(\)]*))?#', $replace_callback, $regex_replace );

            // Fix trailing slash
            if ( '/' === $last_char ) {
                $regex .= '?';
            } else {
                $regex .= '/?';
            }

            $matches = [];
            $result = preg_match ( '#^' . $regex . '(?:\?.*)?$#', $uri, $matches );

            if ( ! $result ) {
                return [ false, [] ];
            }

            foreach ( $params as $k => $v ) {
                $params[ $k ] = ( isset ( $matches[ $k ] ) ) ? urldecode ( $matches[ $k ] ) : null;
            }

            $params = array_values ( $params );
        }

        return [ true, $params ];
    }

}
