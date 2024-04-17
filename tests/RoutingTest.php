<?php

use PHPUnit\Framework\TestCase;
use \puffin\http\SimpleRouter;
use \puffin\http\SimpleRequest;
use \puffin\http\RequestOrigin;
use \puffin\http\Response;
use \puffin\http\Request;
use \puffin\http\Route;
use \puffin\http\SimpleResponse;
use \puffin\http\RouteCollection;
use \puffin\http\HTTPMethod;
use \puffin\http\session\Cookies;

final class RoutingTest extends TestCase {

    public function testNotFound(): void {
        $default = new SimpleResponse( 404 );

        $router     = new SimpleRouter( $default );
        $collection = new RouteCollection();

        $empty_query = [];

        $request = new SimpleRequest(
            HTTPMethod::of( 'GET' ), '/404', $empty_query, [], RequestOrigin::localhost(), Cookies::empty(), null
        );

        $response = $router->route( $request, $collection );

        $this->assertEquals( $response, $default );
    }

    public function testMatch(): void {
        $default = new SimpleResponse( 404 );

        $self = $this;

        $route = function (Request $request, string $name) use ($self) {
            $self->assertEquals( $name, 'anything' );

            return new SimpleResponse( 200, [], $name );
        };

        $router     = new SimpleRouter( $default );
        $collection = new RouteCollection();
        $collection->get( '/@name', $route );

        $request = new SimpleRequest(
            HTTPMethod::of( 'GET' ), '/anything', [], [], RequestOrigin::localhost(), Cookies::empty(), null
        );

        $response = $router->route( $request, $collection );

        $this->assertEquals( $response->status(), 200 );
        $this->assertEquals( $response->headers(), [] );
        $this->assertEquals( $response->body(), 'anything' );
    }

    public function testMatchOverride(): void {
        $default = new SimpleResponse( 404 );

        $self = $this;

        $route = function (Request $request, string $name) use ($self) {
            $self->assertTrue( false );

            return new SimpleResponse( 200, [], $name );
        };

        $collection = new RouteCollection();
        $collection->get( '/@name', $route );
        $collection->add_filter(
            function (Route $route, $request, $params) {
                $route->add_filter(
                    'before', 'override',
                    function () {
                        return new SimpleResponse( 200, [], 'override' );
                    }
                );
            }
        );

        $request = new SimpleRequest(
            HTTPMethod::of( 'GET' ), '/anything', [], [], RequestOrigin::localhost(), Cookies::empty(), null
        );

        $router   = new SimpleRouter( $default );
        $response = $router->route( $request, $collection );

        $this->assertEquals( $response->status(), 200 );
        $this->assertEquals( $response->headers(), [] );
        $this->assertEquals( $response->body(), 'override' );
    }

    public function testNestedRoute(): void {
        $default = new SimpleResponse( 404 );

        $request = new SimpleRequest(
            HTTPMethod::of( 'GET' ), '/api/protected/v1/ok', [], [], RequestOrigin::localhost(), Cookies::empty(), null
        );

        $router     = new SimpleRouter( $default );
        $collection = new RouteCollection();

        $protected = function (Request $request) use ($router): Response {
            $bottomRoutes = new RouteCollection();
            $bottomRoutes->get(
                '/api/protected/v1/@name',
                function (Request $request, string $name): Response {
                    return new SimpleResponse( 200, [], "OK {$name}" );
                }
            );

            $response = $router->route( $request, $bottomRoutes );
            $this->assertEquals( $response->body(), "OK ok" );
            return $response;
        };

        $collection->get( '/api/protected/*', $protected );

        $response = $router->route( $request, $collection );
        $this->assertEquals( $response->body(), "OK ok" );
        $this->assertEquals( $response->status(), 200 );
    }

    public function testMatchEmulated(): void {
        $default = new SimpleResponse( 404 );

        $self = $this;

        $route = function (Request $request, string $name) use ($self) {
            $self->assertEquals( $name, 'anything' );

            return new SimpleResponse( 200, [], $name );
        };

        $router     = new SimpleRouter( $default );
        $collection = new RouteCollection();
        $collection->put( '/@name', $route );

        $request = new SimpleRequest(
            HTTPMethod::emulate( 'PUT', 'POST' ), '/anything', [], [], RequestOrigin::localhost(), Cookies::empty(),
            null
        );

        $response = $router->route( $request, $collection );

        $this->assertEquals( $response->status(), 200 );
        $this->assertEquals( $response->headers(), [] );
        $this->assertEquals( $response->body(), 'anything' );
    }

    public function testMatchCustom(): void {
        $default = new SimpleResponse( 404 );

        $self = $this;

        $route = function (Request $request, string $name) use ($self) {
            $self->assertEquals( $name, 'anything' );

            return new SimpleResponse( 200, [], $name );
        };

        $router     = new SimpleRouter( $default );
        $collection = new RouteCollection();
        $collection->custom( 'QUERY /@name', $route );

        $request = new SimpleRequest(
            HTTPMethod::custom( 'QUERY', 'POST' ), '/anything', [], [], RequestOrigin::localhost(), Cookies::empty(),
            null
        );

        $response = $router->route( $request, $collection );

        $this->assertEquals( $response->status(), 200 );
        $this->assertEquals( $response->headers(), [] );
        $this->assertEquals( $response->body(), 'anything' );
    }

}
