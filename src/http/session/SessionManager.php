<?php

namespace puffin\http\session;

use puffin\http\Request;

/**
 *
 * @author Alessio
 */
interface SessionManager {

    public const EXPIRED = 0;
    public const REVOKED = 1;

    /**
     *
     * @param Request $request
     * @param bool $create
     * @return Session
     */
    public function init(Request $request, bool $create = false): Session;

    /**
     * Query session from id
     * @param string $id
     * @return Session
     */
    public function query(string $id): Session;

    /**
     * Update the session
     */
    public function sync(Session $session): Session;

    /**
     * Distrugge la sessione
     * @param Session $session
     */
    public function destroy(Session $session): void;

    /**
     * Invalida la sessione corrente con una ragione
     * @param string $id id della sessione
     * @param int $reason ragione dell'invalidazione
     * @return void
     */
    public function invalidate(string $id, int $reason = self::EXPIRED): void;

}
