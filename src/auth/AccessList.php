<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\auth;

class AccessList {

    private $cleared;
    private $banned;

    public function __construct(array $cleared = [], array $banned = []) {
        $this->banned = $banned;
        $this->cleared = $cleared;
    }

    public function allow(Grant $g): void {
        $this->cleared[] = $g;
    }

    public function deny(Grant $g): void {
        $this->banned[] = $g;
    }

    public function has_access(Grant $g): bool {
        foreach ( $this->banned as $banned ) {
            if ( $banned->includes ( $g ) ) {
                return false;
            }
        }

        foreach ( $this->cleared as $cleared ) {
            if ( $cleared->includes ( $g ) ) {
                return true;
            }
        }

        return false;
    }

}
