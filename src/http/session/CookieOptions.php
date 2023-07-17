<?php

namespace puffin\http\session;

class CookieOptions {

    public static function default_options(string $path = '', string $domain = ''): self {
        return new self( $path, $domain );
    }

    public $path;
    public $domain;
    public $secure;
    public $httponly;

    public function __construct(string $path = '', string $domain = '', bool $secure = true, bool $httponly = true) {
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httponly = $httponly;
    }

}
