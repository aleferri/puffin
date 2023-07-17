<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\http;

class HTTP {

    public const METHOD_GET = 0;
    public const METHOD_OPTIONS = 1;
    public const METHOD_POST = 2;
    public const METHOD_PUT = 3;
    public const METHOD_PATCH = 4;
    public const METHOD_DELETE = 5;
    public const METHOD_HEAD = 6;
    public const METHOD_CONNECT = 7;
    public const METHOD_TRACE = 8;
    public const METHOD_CUSTOM = 1000;
    
    // Method map from string to int
    public const METHODS_BY_NAME = [
        'GET' => self::METHOD_GET, 'OPTIONS' => self::METHOD_OPTIONS,
        'POST' => self::METHOD_POST, 'PUT' => self::METHOD_PUT,
        'PATCH' => self::METHOD_PATCH, 'DELETE' => self::METHOD_DELETE,
        'HEAD' => self::METHOD_HEAD, 'TRACE' => self::METHOD_TRACE,
        'CUSTOM' => self::METHOD_CUSTOM,
    ];

    public const METHODS_BY_ID = [

    ];

    public static function method_id(string $method): ?int {
        if ( isset( self::METHODS_BY_NAME[ $method ] ) ) {
            return self::METHODS_BY_NAME[ $method ];
        }

        return null;
    }

    public static function is_standard_method(string $method): bool {
        return $method !== 'CUSTOM' && isset( self::METHOD_BY_NAME[ $method ] );
    }

}
