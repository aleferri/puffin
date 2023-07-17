<?php

declare(strict_types = 1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\http;

use puffin\http\body\RequestBody;
use puffin\http\session\Cookies;

/**
 *
 * @author Alessio Ferri
 * @copyright 2020
 */
interface Request {

    /**
     * URI della richiesta, senza la query
     * @return string stringa contenente l'uri della request
     */
    public function uri(): string;

    /**
     * Metodo utilizzato per l'invio
     * @return int una delle costanti dichiarate in alto
     */
    public function method(): int;

    /**
     * Metodo in stringa/sottometodo utilizzato per l'invio
     * @return string uno dei metodi
     */
    public function method_name(): string;

    /**
     * Query se il metodo è emulato usando POST e GET
     * @return bool true se il metodo è emulato
     */
    public function is_emulated_method(): bool;

    /**
     * Query se il metodo è custom o standard
     * @return bool true se il metodo usato è custom
     */
    public function is_custom_method(): bool;

    /**
     * Query HTTP nell'url
     * @return \ArrayAccess query con i dati presenti nell'url
     */
    public function query(): \ArrayAccess;

    /**
     * Lista di header inviati con la richiesta
     * @return array lista degli header
     */
    public function headers(): array;

    /**
     * Contenuto della Request
     * @return RequestBody
     */
    public function body(): ?RequestBody;

    /**
     * Origin of the Request
     * @return RequestOrigin
     */
    public function origin(): RequestOrigin;

    /**
     * Cookies
     * @return Cookies list of cookies
     */
    public function cookies(): Cookies;
}
