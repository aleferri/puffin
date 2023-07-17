<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\loader;

use \puffin\http\RouteCollection;

/**
 * @deprecated since version 0.1.5
 */
class Loader {

    private $routes;

    public function __construct(RouteCollection $routes) {
        $this->routes = $routes;
    }

    public function load(string $filename): void {
        if ( \is_file ( $filename ) ) {
            $fn = include ($filename);

            $fn ( $this->routes );
        }
    }

    public function load_all(string $dir): void {
        $list = glob ( "{$dir}/*/routes.php", GLOB_NOSORT );

        foreach ( $list as $file ) {
            $this->load ( $file );
        }
    }

    public function routes(): RouteCollection {
        return $this->routes;
    }

}
