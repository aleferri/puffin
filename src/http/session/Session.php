<?php

namespace puffin\http\session;

use puffin\auth\Login;
use puffin\ext\FeatureSet;

/**
 *
 * @author Alessio
 */
interface Session {

    /**
     * session identifier in table
     * @return int
     */
    public function id(): int;

    /**
     * Session cookie
     */
    public function session_cookie(): string;

    /**
     * Contenuto della sessione
     * @return array
     */
    public function session_content(): array;

    /**
     * Created at, immutable
     */
    public function created_at(): \DateTimeImmutable;

    /**
     * Updated at, can change only after refresh()
     */
    public function updated_at(): \DateTimeImmutable;

    /**
     * Expire after, can change only after refresh()
     */
    public function expire_after(): \DateTimeImmutable;

    /**
     * User ip, never changing
     */
    public function user_ip(): string;

    /**
     * User agent, never changing
     */
    public function user_agent(): string;

    /**
     * Login, can change only after with_auth()
     */
    public function login(): Login;

    /**
     * Expire after, can change only after refresh()
     */
    public function viewing_resource(): string;

    /**
     * Refresh the session with the currently viewing resource,
     * auto update updated_at, expire_after, viewing_resource
     * @return Session new session
     */
    public function refresh(string $viewing): Session;

    /**
     * Regenerate the cookie
     * @return Session new session
     */
    public function regenerate(): Session;

    /**
     * Change session content
     * @return Session new session
     */
    public function with_content(array $content): Session;

    /**
     * Set authentication
     * @return Session new session
     */
    public function with_auth(Login $login): Session;

    /**
     * Identifica se la sessione è sincronizzata
     * @return bool
     */
    public function is_synced(): bool;

    /**
     * Session applicable FeatureSet
     * @return FeatureSet
     */
    public function features(): FeatureSet;
}
