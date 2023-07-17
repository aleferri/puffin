<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\auth;

interface Grant {

    /**
     * Compose two Grants in the one merged grant
     */
    public function compose(Grant $g): Grant;

    /**
     * Check if a Grant includes another Grant
     */
    public function includes(Grant $g): bool;

    /**
     * List a subgrant with only the specified context
     * @param string $context
     * @return Grant the subgrant
     */
    public function for_context(string $context): Grant;

    /**
     * Flatten all grants
     * @return array
     */
    public function flatten(): array;

    /**
     * Serialize grant
     * @return mixed
     */
    public function serialize(): mixed;

    /**
     * Return the grant to string
     * @return string
     */
    public function to_string(): string;

}
