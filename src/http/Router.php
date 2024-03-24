<?php

declare(strict_types = 1);
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
interface Router {

    /**
     * Route della Request sui match disponibili
     * @param \puffin\http\Request $request richiesta corrente
     * @param \puffin\http\RouteCollection $collection pattern e callback disponibili
     */
    public function route(Request $request, RouteCollection $collection): Response;
}
