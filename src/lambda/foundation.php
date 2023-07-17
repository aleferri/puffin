<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\lambda;

/**
 * Any element of the iterable is true for the condition
 */
function any(iterable $iter, callable $condition): bool {
    foreach ( $iter as $elem ) {
        if ( $condition ( $elem ) ) {
            return true;
        }
    }

    return false;
}

/**
 * All elements of the iterable are true for the condition
 */
function all(iterable $iter, callable $condition): bool {
    foreach ( $iter as $elem ) {
        if ( ! $condition ( $elem ) ) {
            return false;
        }
    }

    return true;
}

/**
 * Filter an array and return the filtered elements
 */
function filter_in(iterable $iter, callable $filter): array {
    $filtered = [];

    foreach ( $iter as $k => $elem ) {
        if ( $filter ( $elem ) ) {
            $filtered[ $k ] = $elem;
        }
    }

    return $filtered;
}

/**
 * Filter an array and return the unfiltered
 * @param iterable $iter iterable to iterate over
 * @param callable $filter filter to apply
 * @return array unfiltered list
 */
function filter_out(iterable $iter, callable $filter): array {
    $filtered = [];

    foreach ( $iter as $k => $elem ) {
        if ( ! $filter ( $elem ) ) {
            $filtered[ $k ] = $elem;
        }
    }

    return $filtered;
}

/**
 * Apply a function to each element of the array
 */
function map(iterable $iter, callable $apply): array {
    $applied = [];

    foreach ( $iter as $k => $elem ) {
        $applied[ $k ] = $apply ( $elem );
    }

    return $applied;
}

function get_any(\ArrayAccess|array $array, mixed $default, string ...$keys): mixed {
    foreach( $keys as $key ) {
        if ( isset( $array[ $key ] ) && $array[ $key ] !== null ) {
            return $array[ $key ];
        }
    }

    return $default;
}