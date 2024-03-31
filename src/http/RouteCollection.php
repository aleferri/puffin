<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\http;

/**
 *
 * @author Alessio
 */
class RouteCollection {

    /** @var callable(callable(array):Response, Request, array):Response */
    private $injector;

    /** @var array<int,array<array{0: string, 1: callable(array): Response}>> */
    private $bins;

    public function __construct(callable $injector = null) {
        if ( $injector === null ) {
            $this->injector = function (callable $handler, string $pattern, Request $r, array $params): Response {
                $params[] = $r;

                return $handler( ...$params );
            };
        } else {
            $this->injector = $injector;
        }

        $this->bins = [ [], [], [], [], [], [], [], [] ];
    }

    /**
     * Injectors
     * @return callable(callable(array):Response, Request, array):Response
     */
    public function injector(): callable {
        return $this->injector;
    }

    /**
     * Filtra gli handler per metodo utilizzato
     * @param int $method metodo utilizzato
     * @return array lista degli handler
     */
    public function filter_by(int $method): array {
        return $this->bins[ $method ];
    }

    /**
     * Register an handler for a pattern received with every method
     */
    public function any(string $pattern, callable $handler): void {
        $this->options( $pattern, $handler );
        $this->get( $pattern, $handler );
        $this->post( $pattern, $handler );
        $this->put( $pattern, $handler );
        $this->patch( $pattern, $handler );
        $this->delete( $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function options(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_OPTIONS, $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function get(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_GET, $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function post(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_POST, $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function put(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_PUT, $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function patch(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_PATCH, $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function delete(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_DELETE, $pattern, $handler );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function custom(string $pattern, callable $handler): void {
        $this->route( HTTP::METHOD_CUSTOM, $pattern, $handler );
    }

    /**
     * Handle other methods
     * @param int $method
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function route(int $method, string $pattern, callable $handler): void {
        $this->bins[ $method ][] = [ $pattern, $handler ];
    }

    /**
     * Inject dependency on route
     * @param callable(callable(array):Response, Request, array):Response $injector
     */
    public function inject(callable $injector): void {
        $this->injector = $injector;
    }

}
