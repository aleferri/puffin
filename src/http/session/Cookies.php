<?php

namespace puffin\http\session;

class Cookies {

    public static function recover(): self {
        $cookies = [];

        $base_expiration = new \DateTimeImmutable();
        $timestamp = $base_expiration->getTimestamp();

        foreach ( $_COOKIE as $name => $value ) {
            $cookies = new Cookie( $name, $value, $timestamp + (60 * 60 * 24), new CookieOptions() );
        }

        return new self( $cookies );
    }

    public static function empty() {
        return new self( [] );
    }

    private $cookies;

    public function __construct(array $cookies) {
        $this->cookies = $cookies;
    }

    public function set(string $name, string $value, int $expiration, CookieOptions $options): void {
        $this->cookies[] = new Cookie( $name, $value, $expiration, $options );
    }

    public function get(string $name): ?string {
        foreach ( $this->cookies as $cookie ) {
            if ( $cookie->name === $name ) {
                return $cookie->value;
            }
        }

        return null;
    }

}
