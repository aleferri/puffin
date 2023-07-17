<?php

namespace puffin\http;

class RequestOrigin {

    public static function localhost(?string $user_agent = null) {
        return new self( '127.0.0.1', $user_agent ?? 'test' );
    }

    public $ip;
    public $user_agent;

    public function __construct(string $ip, string $user_agent) {
        $this->ip = $ip;
        $this->user_agent = $user_agent;
    }

}