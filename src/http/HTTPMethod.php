<?php

namespace puffin\http;

class HTTPMethod {

    public static function of(string $method) {
        return new HTTPMethod( HTTP::method_id( $method ), $method, $method );
    }

    public static function emulate(string $method, string $on_method) {
        return new HTTPMethod( HTTP::method_id( $method ), $method, $on_method );
    }

    public static function custom(string $custom, string $on_method) {
        return new HTTPMethod( HTTP::method_id( 'CUSTOM' ), $custom, $on_method );
    }

    public $id;
    public $name;
    public $request_method;

    public function __construct( int $id, string $name, ?string $request_method = null ) {
        $this->id = $id;
        $this->name = $name;
        $this->request_method = $request_method ?? $this->name;
    }

}