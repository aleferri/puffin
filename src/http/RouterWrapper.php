<?php

namespace puffin\http;

class RouterWrapper implements Router {

    private $base_router;
    private $wrappers;

    public function __construct(Router $base_router) {
        $this->base_router = $base_router;
        $this->wrappers = $wrappers;
    }

    public function wrap_route(callable $wrapper) {
        $this->wrappers[] = $wrapper;
    }

    public function route(Request $request, RouteCollection $collection): Response {
        if ( count( $this->wrappers ) > 0 ) {
            $wrapper = $this->wrappers[ 0 ];
            return $wrapper( $handler, $r, $params, $this->wrappers, 1 );
        }
        return $this->base_router->route($request, $collection);
    }

}