<?php

declare(strict_types=1);
/**
 * @author Alessio Ferri
 * @copyright Alessio Ferri
 * @license Apache-2.0
 */

namespace puffin\log;

/**
 * @deprecated since version 0.1.5
 */
class LoggerFile implements Logger {

    use LoggerCore;

    /**
     * @var resource $dest
     */
    private $dest;
    private $filter;

    /**
     * @param resource $dest
     */
    public function __construct($dest, int $filter = 8) {
        $this->dest = $dest;
        $this->filter = $filter;
    }

    public function log(int $level, string $message, array $info = []): void {
        if ( $level > $this->filter ) {
            return;
        }
        $real_message = $this->interpolate ( $message, $info );
        fwrite ( $this->dest, $real_message );
    }

    public function flush(): void {
        fflush ( $this->dest );
    }

}
