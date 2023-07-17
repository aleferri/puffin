<?php

namespace puffin\http\session;

class Cookie {

    private $name;
    private $value;
    private $expiration;
    private $options;

    public function __construct(string $name, string $value, int $expiration, CookieOptions $options) {
        $this->name = $name;
        $this->value = $value;
        $this->expiration = $expiration;
        $this->options = $options;
    }

    public function name(): string {
        return $this->name;
    }

    public function value(): string {
        return $this->value;
    }

    public function expiration(): int {
        return $this->expiration;
    }

    public function options(): CookieOptions {
        return $this->options;
    }

}
