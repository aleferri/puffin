<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\collections;

class HashMap implements \ArrayAccess {

    private $container;

    public function __construct(array $container = []) {
        $this->container = $container;
    }

    /**
     * @param int|string $offset
     */
    public function offsetExists($offset): bool {
        return isset( $this->container[ $offset ] );
    }

    /**
     * @param int|string $offset
     * @return mixed
     */
    public function offsetGet($offset): mixed {
        return $this->container[ $offset ];
    }

    /**
     * @param int|string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, mixed $value): void {
        $this->container[ $offset ] = $value;
    }

    /**
     * @param int|string $offset
     */
    public function offsetUnset($offset): void {
        unset( $this->container[ $offset ] );
    }

}
