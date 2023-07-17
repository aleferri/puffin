<?php

/*
 * Copyright 2023 Alessio.
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

namespace puffin\setup;

use \puffin\http\RouteCollection;

/**
 * Description of RoutesDiscovery
 *
 * @author Alessio
 */
class RoutesDiscovery {

    private $routes;

    public function __construct(RouteCollection $routes) {
        $this->routes = $routes;
    }

    public function import(string $filename): void {
        if ( \is_file ( $filename ) ) {
            $fn = include ($filename);

            $fn ( $this->routes );
        }
    }

    public function discover_routes(string $dir): void {
        $list = glob ( "{$dir}/*/routes.php", GLOB_NOSORT );

        foreach ( $list as $file ) {
            $this->import ( $file );
        }
    }

    public function routes(): RouteCollection {
        return $this->routes;
    }

}
