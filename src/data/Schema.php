<?php

namespace puffin\data;

/**
 *
 * @author Alessio
 */
interface Schema extends \IteratorAggregate {

    /**
     * Schema name
     */
    public function name(): string;

    /**
     * Property list
     */
    public function properties(): array;

    /**
     * Property of name $name
     */
    public function property(string $name): ?Property;

    /**
     * Name of the progressive key
     */
    public function progressive_key(): string;

    /**
     * List of indexes name
     */
    public function indexes(): array;

    /**
     * Clone schema
     */
    public function clone(string $new_name): Schema;

}
