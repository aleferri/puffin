<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\auth;

interface Login {

    public const ANONYMOUS = '__unknown__';

    /**
     * Acting User id
     */
    public function user_id(): int;

    /**
     * Username of the current login
     */
    public function username(): string;

    /**
     * @return array<string>
     * Grants given to the current Login
     */
    public function grants(): array;

    /**
     * Resource uri for which the user is acting as
     */
    public function acting_self(): string;

    /**
     * Current realm, in case of multiple realms, the main one
     * @return string
     */
    public function active_realm(): string;

    /**
     * Authenticated realms
     * @return array<string>
     */
    public function auth_realms(): array;

    /**
     * Authentication key used
     */
    public function auth_key(): string;

    /**
     * Authenticated user id
     */
    public function auth_user_id(): int;

    /**
     * Authentication method
     */
    public function auth_method(): string;

    /**
     * Check authentication
     */
    public function auth_checked(): int;

}
