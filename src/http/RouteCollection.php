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

    /** @var array<int,array<Route>> */
    private $bins;

    /**
     *
     * @var array<callable>
     */
    private $filters;

    public function __construct() {
        $this->bins    = [ [], [], [], [], [], [], [], [] ];
        $this->filters = [];
    }

    /**
     * Filtra gli handler per metodo utilizzato
     * @param int $method metodo utilizzato
     * @return array<Route> lista degli handler
     */
    public function filter_by(int $method): array {
        return $this->bins[ $method ];
    }

    /**
     * Add a filter
     * @param callable $callable
     * @return void
     */
    public function add_filter(callable $callable): void {
        $this->filters[] = $callable;
    }

    /**
     * List of filters
     * @return array
     */
    public function filters(): array {
        return $this->filters;
    }

    /**
     * Register an handler for a pattern received with every method
     */
    public function any(string $pattern, callable $handler, array $metadata = []): void {
        $this->options( $pattern, $handler, $metadata );
        $this->get( $pattern, $handler, $metadata );
        $this->post( $pattern, $handler, $metadata );
        $this->put( $pattern, $handler, $metadata );
        $this->patch( $pattern, $handler, $metadata );
        $this->delete( $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function options(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_OPTIONS, $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function get(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_GET, $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function post(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_POST, $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function put(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_PUT, $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function patch(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_PATCH, $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function delete(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_DELETE, $pattern, $handler, $metadata );
    }

    /**
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function custom(string $pattern, callable $handler, array $metadata = []): void {
        $this->route( HTTP::METHOD_CUSTOM, $pattern, $handler, $metadata );
    }

    /**
     * Handle other methods
     * @param int $method
     * @param string $pattern
     * @param callable(array):Response $handler
     */
    public function route(int $method, string $pattern, callable $handler, array $metadata = []): void {
        $this->bins[ $method ][] = new Route( $method, $pattern, $handler, $metadata );
    }

}
