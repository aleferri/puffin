<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\log;

trait LoggerCore {

    public function emergency(string $message, array $info = []): void {
        $this->log ( 0, $message, $info );
    }

    public function alert(string $message, array $info = []): void {
        $this->log ( 1, $message, $info );
    }

    public function critical(string $message, array $info = []): void {
        $this->log ( 2, $message, $info );
    }

    public function error(string $message, array $info = []): void {
        $this->log ( 3, $message, $info );
    }

    public function warning(string $message, array $info = []): void {
        $this->log ( 4, $message, $info );
    }

    public function notice(string $message, array $info = []): void {
        $this->log ( 5, $message, $info );
    }

    public function info(string $message, array $info = []): void {
        $this->log ( 6, $message, $info );
    }

    public function debug(string $message, array $info = []): void {
        $this->log ( 7, $message, $info );
    }

    protected function interpolate(string $message, array $info): string {
        $from = [];
        $into = [];
        foreach ( $info as $key => $val ) {
            $from[] = '{' . $key . '}';
            $into[] = $val;
        }

        return str_replace ( $from, $into, $message );
    }

}
